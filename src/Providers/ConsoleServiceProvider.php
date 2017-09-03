<?php

namespace Studio\Totem\Providers;

use Studio\Totem\Events\Executed;
use Studio\Totem\Events\Executing;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register any services.
     *
     * @return void
     */
    public function boot()
    {
        // TODO: refactor this to resolving callback while 5.5 branching
        $this->app->booted(function () {
            if ($this->app->runningInConsole()) {
                $this->schedule($this->app->make(Schedule::class));
            }
        });
    }

    /**
     * Prepare schedule from tasks.
     *
     * @param Schedule $schedule
     */
    public function schedule(Schedule $schedule)
    {
        $tasks = app('totem.tasks')->findAllActive();

        $tasks->each(function ($task) use ($schedule) {
            $event = $schedule->command($task->command, $task->compileParameters(true));

            $event->cron($task->getCronExpression())
                ->name($task->description)
                ->timezone($task->timezone)
                ->before(function () use ($task, $event) {
                    $event->start = microtime(true);
                    Executing::dispatch($task);
                })
                ->after(function () use ($event, $task) {
                    Executed::dispatch($task, $event->start);
                })
                ->sendOutputTo(storage_path($task->getMutexName()));
            if ($task->dont_overlap) {
                $event->withoutOverlapping();
            }
            if ($task->run_in_maintenance) {
                $event->evenInMaintenanceMode();
            }
        });
    }
}

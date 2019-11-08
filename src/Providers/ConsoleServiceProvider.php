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
        if ($this->app->env == 'testing'){
          return;
        }
        $this->app->resolving(Schedule::class, function ($schedule) {
            $this->schedule($schedule);
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
            if ($task->run_on_one_server && in_array(config('cache.default'), ['memcached', 'redis'])) {
                $event->onOneServer();
            }
        });
    }
}

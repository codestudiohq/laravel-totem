<?php

namespace Studio\Totem\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Studio\Totem\Events\Executed;
use Studio\Totem\Events\Executing;
use Studio\Totem\Totem;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Register any services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->resolving(Schedule::class, function ($schedule) {
            if (Totem::isEnabled()) {
                $this->schedule($schedule);
            }
        });
    }

    /**
     * Prepare schedule from tasks.
     *
     * @param  Schedule  $schedule
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
                ->thenWithOutput(function ($output) use ($event, $task) {
                    Executed::dispatch($task, $event->start ?? microtime(true), $output);
                });
            if ($task->dont_overlap) {
                $event->withoutOverlapping();
            }
            if ($task->run_in_maintenance) {
                $event->evenInMaintenanceMode();
            }
            if ($task->run_on_one_server && in_array(config('cache.default'), ['memcached', 'redis', 'database', 'dynamodb'])) {
                $event->onOneServer();
            }
            if ($task->run_in_background) {
                $event->runInBackground();
            }
        });
    }
}

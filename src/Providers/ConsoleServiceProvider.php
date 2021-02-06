<?php

namespace Studio\Totem\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Studio\Totem\Events\Executed;
use Studio\Totem\Events\Executing;

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

        Storage::makeDirectory(config('totem.log_folder'));

        Storage::put(config('totem.log_folder').'/test.txt', 'abcdegf');

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
                    Executed::dispatch($task, $event->start ?? microtime(true));
                })
                ->sendOutputTo(Storage::path($task->getMutexName()));
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

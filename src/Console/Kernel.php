<?php

namespace Studio\Totem\Console;

use Studio\Totem\Events\Tasks\Executed;
use Studio\Totem\Events\Tasks\Executing;
use Studio\Totem\Contracts\TaskInterface;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as AppKernel;

class Kernel extends AppKernel
{
    /**
     * @var TaskInterface
     */
    private $tasks;

    /**
     * Kernel constructor.
     * @param Application $app
     * @param Dispatcher $events
     * @param TaskInterface $tasks
     */
    public function __construct(Application $app, Dispatcher $events, TaskInterface $tasks)
    {
        $this->tasks = $tasks;

        parent::__construct($app, $events);
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $this->prepareSchedule($schedule);
        //        $schedule->command('inspire')
        //            ->hourly()
        //            ->timezone('America/Chicago');

        parent::schedule($schedule);
    }

    /**
     * @return array
     */
    public function getCommands()
    {
        return collect($this->all())->sortBy(function ($command) {
            return $command->getDescription();
        });
    }

    public function prepareSchedule($schedule)
    {
        $tasks = $this->tasks->findAllActive();

        $tasks->each(function ($task) use ($schedule) {
            $event = $schedule->command($task->command.' '.$task->parameters);

            $event->cron($task->getCronExpression())
                ->name($task->description)
                ->timezone($task->timezone)
                ->before(function () use ($task, $event) {
                    $event->start = microtime(true);
                    Executing::dispatch($task);
                })
                ->after(function () use ($event, $task) {
                    Executed::dispatch($task, $event);
                })
                ->sendOutputTo(storage_path('logs/schedule-'.sha1($event->mutexName()).'.log'));
            if ($task->dont_overlap) {
                $event->withoutOverlapping();
            }
            if ($task->run_in_maintenance) {
                $event->evenInMaintenanceMode();
            }

            if ($task->notification_email_address) {
                $event->emailOutputTo($task->notification_email_address);
            }
        });
    }
}

<?php

namespace Studio\Totem\Console;

use App\Console\Kernel as AppKernel;
use Studio\Totem\Contracts\TaskInterface;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;

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

        parent::schedule($schedule);
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return collect($this->all())->reject(function ($command) {
            return ! $command instanceof Command;
        })->flatMap(function ($command) {
            return [get_class($command) => $command->getVerboseName()];
        })->toArray();
    }

    public function prepareSchedule($schedule)
    {
        $tasks = $this->tasks->findAllActive();

        $tasks->each(function ($task) use ($schedule) {
            $command = $this->app[$task->command];
            if ($command) {
                $schedule->command($command->getName())
                    ->cron($task->cron)
                    ->appendOutputTo(storage_path('app/tasks/task-'.$task->id.'.log'))
                    ->emailOutputTo($task->notification_email_address);
            }
        });
    }
}

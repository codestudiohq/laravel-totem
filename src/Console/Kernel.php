<?php

namespace Studio\Totem\Console;

use Studio\Totem\Console\Commands\Command;
use Illuminate\Console\Scheduling\Schedule;

class Kernel extends \Illuminate\Foundation\Console\Kernel
{
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
        $tasks = $this->app['totem.tasks']->findAllActive();

        $tasks->each(function ($task) use ($schedule) {
            $command = $this->app[$task->command];
            if ($command) {
                $schedule->command($command->getName())->cron($task->cron);
            }
        });
    }
}

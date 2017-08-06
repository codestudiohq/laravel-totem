<?php

namespace Studio\Totem\Console;

use App\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Studio\Totem\Console\Commands\Command;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);
    }

    /**
     * @return array
     */
    public function getCommands(): array
    {
        return collect($this->all())->reject(function($command) {
            return ! $command instanceof Command;
        })->flatMap(function ($command) {
            return [get_class($command) => $command->getVerboseName()];
        })->toArray();
    }

    /**
     * @param array $commands
     */
    public function setCommands(array $commands)
    {
        $this->commands = $commands;
    }
}

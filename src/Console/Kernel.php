<?php

namespace Studio\Totem\Console;

class Kernel extends \Illuminate\Foundation\Console\Kernel
{
    /**
     * Get all of the commands registered with the console.
     *
     * @return array
     */
    public function all()
    {
        $this->bootstrap();

        if (! $this->commandsLoaded) {
            $this->commands();

            $this->commandsLoaded = true;
        }

        return collect($this->getArtisan()->all())->sortBy(function ($command) {
            return $command->getDescription();
        });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        if (method_exists($this, 'load')) {
            $this->load(base_path('app/Console/Commands'));
        }

        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}

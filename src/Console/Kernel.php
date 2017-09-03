<?php

namespace Studio\Totem\Console;

use Illuminate\Support\Facades\Artisan;

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

        $this->commands();

        return collect(Artisan::all())->sortBy(function ($command) {
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
        if (file_exists(base_path('routes/console.php'))) {
            require base_path('routes/console.php');
        }
    }
}

<?php

namespace Studio\Totem\Console;

use Illuminate\Foundation\Console\Kernel as AppKernel;

class Kernel extends AppKernel
{
    /**
     * Get a list of all artisan commands.
     *
     * @return array
     */
    public function getCommands()
    {
        return collect($this->all())->sortBy(function ($command) {
            return $command->getDescription();
        });
    }
}

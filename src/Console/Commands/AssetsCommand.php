<?php

namespace Studio\Totem\Console\Commands;

use Illuminate\Console\Command;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'totem:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the Totem assets';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag'   => 'totem-assets',
            '--force' => true,
        ]);
    }
}

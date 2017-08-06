<?php

namespace Studio\Totem\Console\Commands;

use Illuminate\Console\Scheduling\Schedule;

class ListSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'totem:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all scheduled commands';

    /**
     * @var Schedule
     */
    private $schedule;

    /**
     * Create a new command instance.
     *
     * @param Schedule $schedule
     * @return void
     */
    public function __construct(Schedule $schedule)
    {
        parent::__construct();

        $this->schedule = $schedule;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (count($this->schedule->events()) > 0) {
            $events = collect($this->schedule->events())->map(function ($event) {
                return [
                    'command'   => ucfirst(ltrim(str_after($event->command, "'artisan'"))),
                    'schedule'  => $event->expression,
                ];
            });

            $this->table(
                ['Command', 'Schedule'],
                $events
            );
        } else {
            $this->info('No Scheduled Commands Found');
        }
    }
}

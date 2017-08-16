<?php

namespace Studio\Totem\Events\Tasks;

use Studio\Totem\Events\Event;
use Studio\Totem\Task;

class Executed extends Event
{
    public function __construct(Task $task, $event)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $event->start;

        $task->results()->create([
            'duration' => $time_elapsed_secs * 1000,
            'result'    => file_get_contents(storage_path('logs/schedule-'.sha1($event->mutexName()).'.log'))
        ]);

    }
}

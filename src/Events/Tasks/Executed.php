<?php

namespace Studio\Totem\Events\Tasks;

use Studio\Totem\Task;
use Studio\Totem\Events\Event;
use Studio\Totem\Notifications\TaskCompleted;

class Executed extends Event
{
    /**
     * Executed constructor.
     *
     * @param Task $task
     * @param string $start
     */
    public function __construct(Task $task, $start)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $start;

        $output = file_get_contents(storage_path($task->getMutexName()));

        $task->results()->create([
            'duration'  => $time_elapsed_secs * 1000,
            'result'    => $output,
        ]);

        $task->notify(new TaskCompleted($output));
    }
}

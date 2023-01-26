<?php

namespace Studio\Totem\Events;

use Studio\Totem\Notifications\TaskCompleted;
use Studio\Totem\Task;

class Executed extends BroadcastingEvent
{
    /**
     * Executed constructor.
     *
     * @param  Task  $task
     * @param  string  $started
     */
    public function __construct(Task $task, $started, $output)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $started;

        $result = $task->results()->create([
            'duration'  => $time_elapsed_secs * 1000,
            'result'    => $output,
        ]);

        $task->notify(new TaskCompleted($result));
        $task->autoCleanup();
    }
}

<?php

namespace Studio\Totem\Events;

use Studio\Totem\Task;
use Studio\Totem\Notifications\TaskCompleted;

class Executed extends BroadcastingEvent
{
    /**
     * Executed constructor.
     *
     * @param Task $task
     * @param float $started
     */
    public function __construct(Task $task, float $started)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $started;

        if (file_exists(storage_path($task->getMutexName()))) {
            $output = file_get_contents(storage_path($task->getMutexName()));

            $task->results()->create([
                'duration'  => $time_elapsed_secs * 1000,
                'result'    => $output,
            ]);

            unlink(storage_path($task->getMutexName()));

            $task->notify(new TaskCompleted($output));
            $task->autoCleanup();
        }
    }
}

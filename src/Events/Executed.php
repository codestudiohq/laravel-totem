<?php

namespace Studio\Totem\Events;

use Illuminate\Support\Facades\Storage;
use Studio\Totem\Notifications\TaskCompleted;
use Studio\Totem\Task;

class Executed extends BroadcastingEvent
{
    /**
     * Executed constructor.
     *
     * @param Task $task
     * @param string $started
     */
    public function __construct(Task $task, $started)
    {
        parent::__construct($task);

        $time_elapsed_secs = microtime(true) - $started;

        if (Storage::exists($task->getMutexName())) {
            $output = Storage::get($task->getMutexName());

            $task->results()->create([
                'duration'  => $time_elapsed_secs * 1000,
                'result'    => $output,
            ]);

            Storage::delete($task->getMutexName());

            $task->notify(new TaskCompleted($output));
            $task->autoCleanup();
        }
    }
}

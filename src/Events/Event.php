<?php

namespace Studio\Totem\Events;

use Studio\Totem\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class Event
{
    use Dispatchable, SerializesModels;

    /**
     * @var Task
     */
    public $task;

    /**
     * Updated constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }
}

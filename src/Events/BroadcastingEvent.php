<?php

namespace Studio\Totem\Events;

use Studio\Totem\Task;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class BroadcastingEvent extends TaskEvent implements ShouldBroadcastNow
{
    use InteractsWithSockets;

    /**
     * @var Task
     */
    public $task;

    /**
     * constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]|PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.events');
    }
}

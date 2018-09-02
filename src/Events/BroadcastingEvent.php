<?php


namespace Studio\Totem\Events;


use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Studio\Totem\Task;

class BroadcastingEvent extends Event implements ShouldBroadcast
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
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('task.events');
    }
}
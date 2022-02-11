<?php

namespace Studio\Totem\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Studio\Totem\Task;

class Updating extends BroadcastingEvent
{
    /**
     * @var array
     */
    private array $input;

    /**
     * Create a new event instance.
     *
     * @param  array  $input
     * @param  Task  $task
     */
    public function __construct(array $input, Task $task)
    {
        $this->input = $input;
        parent::__construct($task);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}

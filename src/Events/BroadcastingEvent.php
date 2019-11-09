<?php

namespace Studio\Totem\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BroadcastingEvent extends TaskEvent implements ShouldBroadcast
{
    use InteractsWithSockets;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = config('totem.broadcasting.queue');

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]|PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel(config('totem.broadcasting.channel'));
    }

    /**
     * Toggles event broadcasting on/off based on config value.
     *
     * @return bool
     */
    public function broadcastWhen()
    {
        return config('totem.broadcasting.enabled');
    }
}

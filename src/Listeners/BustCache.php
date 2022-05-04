<?php

namespace Studio\Totem\Listeners;

use Studio\Totem\Events\Event;

class BustCache extends Listener
{
    /**
     * Handle the event.
     *
     * @param  \Studio\Totem\Events\Event  $event
     */
    public function handle(Event $event)
    {
        $this->clear($event);
    }

    /**
     * Clear Cache.
     *
     * @param  Event  $event
     */
    protected function clear(Event $event)
    {
        if ($event->task) {
            $this->app['cache']->forget('totem.task.'.$event->task->id);
        }

        $this->app['cache']->forget('totem.tasks.all');
        $this->app['cache']->forget('totem.tasks.active');
    }
}

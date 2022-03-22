<?php

namespace Studio\Totem\Listeners;

use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Studio\Totem\Contracts\TaskInterface;

class Listener implements ShouldQueue
{
    /**
     * @var TaskInterface.
     */
    protected $tasks;

    /**
     * @var Container
     */
    protected $app;

    /**
     * Create the event listener.
     *
     * @param  Container  $app
     * @param  TaskInterface  $tasks
     */
    public function __construct(Container $app, TaskInterface $tasks)
    {
        $this->tasks = $tasks;
        $this->app = $app;
    }
}

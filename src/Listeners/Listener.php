<?php

namespace Studio\Totem\Listeners;

use Illuminate\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Studio\Totem\Repositories\EloquentTaskRepository;

class Listener implements ShouldQueue
{
    /**
     * @var EloquentTaskRepository.
     */
    protected $tasks;

    /**
     * @var Container
     */
    protected $app;

    /**
     * Create the event listener.
     *
     * @param Container              $app
     * @param EloquentTaskRepository $tasks
     */
    public function __construct(Container $app, EloquentTaskRepository $tasks)
    {
        $this->tasks = $tasks;
        $this->app = $app;
    }
}

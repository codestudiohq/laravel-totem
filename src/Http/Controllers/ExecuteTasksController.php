<?php

namespace Studio\Totem\Http\Controllers;

use Studio\Totem\Task;
use Studio\Totem\Repositories\EloquentTaskRepository;

class ExecuteTasksController extends Controller
{
    /**
     * @var EloquentTaskRepository
     */
    private $tasks;

    /**
     * @param EloquentTaskRepository $tasks
     */
    public function __construct(EloquentTaskRepository $tasks)
    {
        parent::__construct();

        $this->tasks = $tasks;
    }

    /**
     * Execute a specific task.
     *
     * @param int|Task $task
     * @return \Illuminate\Http\Response
     */
    public function index($task)
    {
        $this->tasks->execute($task);

        return redirect()->back();
    }
}

<?php

namespace Studio\Totem\Http\Controllers;

use Illuminate\Http\Request;
use Studio\Totem\Contracts\TaskInterface;

class ActiveTasksController extends Controller
{
    /**
     * @var TaskInterface
     */
    private $tasks;

    /**
     * TasksController constructor.
     * @param TaskInterface $tasks
     */
    public function __construct(TaskInterface $tasks)
    {
        parent::__construct();

        $this->tasks = $tasks;
    }

    public function store(Request $request)
    {
        $task = $this->tasks->activate($request->all());

        return response()->json($task, 200);
    }

    public function destroy($id)
    {
        $task = $this->tasks->deactivate($id);

        return response()->json($task, 200);
    }
}

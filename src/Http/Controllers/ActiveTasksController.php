<?php

namespace Studio\Totem\Http\Controllers;

use Illuminate\Http\Request;
use Studio\Totem\Repositories\EloquentTaskRepository;

class ActiveTasksController extends Controller
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
     * Store a newly active task in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $task = $this->tasks->activate($request->input('task_id'));

        return response()->json($task, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->tasks->deactivate($id);

        return response()->json($task, 200);
    }
}

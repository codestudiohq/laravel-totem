<?php

namespace Studio\Totem\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class ExecuteTasksController extends Controller
{
    /**
     * Execute a specific task.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($task)
    {
        $command = app($task->command);
        Artisan::call($command->getName());

        return redirect()->back();
    }
}

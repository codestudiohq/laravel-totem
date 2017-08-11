<?php


namespace Studio\Totem\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class ExecuteTasksController extends Controller
{
    public function index($task)
    {
        $command = app($task->command);
        Artisan::call($command->getName());
        return redirect()->back();
    }
}

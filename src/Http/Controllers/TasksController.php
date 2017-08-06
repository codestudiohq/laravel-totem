<?php

namespace Studio\Totem\Http\Controllers;

use Studio\Totem\Console\Kernel;
use Studio\Totem\Contracts\TaskInterface;
use Studio\Totem\Http\Requests\CreateTaskRequest;

class TasksController extends Controller
{
    /**
     * @var TaskInterface
     */
    private $tasks;
    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * TasksController constructor.
     * @param TaskInterface $tasks
     * @param Kernel $kernel
     */
    public function __construct(TaskInterface $tasks, Kernel $kernel)
    {
        $this->tasks = $tasks;

        $this->kernel = $kernel;
    }

    public function index()
    {
        return view('totem::tasks.index');
    }

    public function create()
    {
        $commands = collect($this->kernel->getCommands());

        $commands = $commands->flatMap(function($command) {
           $resolved = app($command);
           return [$command => $resolved->getPrettyName() . " (" . $resolved->getDescription() . ")"];
        })->toArray();

        return view('totem::tasks.create',[
            'commands' => $commands
        ]);
    }

    public function store(CreateTaskRequest $request)
    {
        $task = $this->tasks->store($request->all());

        return redirect()->route('totem.tasks.all')->with('success', trans('totem::message.success'));
    }
}

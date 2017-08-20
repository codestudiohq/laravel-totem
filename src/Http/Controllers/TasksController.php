<?php

namespace Studio\Totem\Http\Controllers;

use Studio\Totem\Task;
use Studio\Totem\Console\Kernel;
use Studio\Totem\Contracts\TaskInterface;
use Studio\Totem\Http\Requests\CreateTaskRequest;
use Studio\Totem\Http\Requests\UpdateTaskRequest;

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
        parent::__construct();
        $this->tasks = $tasks;

        $this->kernel = $kernel;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('totem::tasks.index', [
            'tasks' => $this->tasks->builder()->paginate(10),
        ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('totem::tasks.form', [
            'task'      => new Task,
            'commands'  => $this->kernel->getCommands(),
            'timezones' => timezone_identifiers_list(),
        ]);
    }

    /**
     * @param CreateTaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateTaskRequest $request)
    {
        $this->tasks->store($request->all());

        return redirect()
            ->route('totem.tasks.all')
            ->with('success', trans('totem::messages.success.create'));
    }

    /**
     * @param $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($task)
    {
        return view('totem::tasks.view', [
            'task'  => $task,
        ]);
    }

    /**
     * @param $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($task)
    {
        return view('totem::tasks.form', [
            'task'      => $task,
            'commands'  => $this->kernel->getCommands(),
            'timezones' => timezone_identifiers_list(),
        ]);
    }

    /**
     * @param UpdateTaskRequest $request
     * @param $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTaskRequest $request, $task)
    {
        $task = $this->tasks->update($request->all(), $task);

        return redirect()->route('totem.task.view', $task)
            ->with('task', $task)
            ->with('success', trans('totem::messages.success.update'));
    }

    /**
     * @param $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($task)
    {
        $this->tasks->destroy($task);

        return redirect()
            ->route('totem.tasks.all')
            ->with('success', trans('totem::messages.success.delete'));
    }
}

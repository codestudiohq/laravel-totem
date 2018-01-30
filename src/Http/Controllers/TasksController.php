<?php

namespace Studio\Totem\Http\Controllers;

use Studio\Totem\Task;
use Studio\Totem\Totem;
use Studio\Totem\Frequency;
use Studio\Totem\Contracts\TaskInterface;
use Studio\Totem\Http\Requests\TaskRequest;

class TasksController extends Controller
{
    /**
     * @var TaskInterface
     */
    private $tasks;

    /**
     * TasksController constructor.
     *
     * @param TaskInterface $tasks
     */
    public function __construct(TaskInterface $tasks)
    {
        parent::__construct();

        $this->tasks = $tasks;
    }

    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('totem::tasks.index', [
            'tasks' => $this->tasks->builder()->orderBy('description')->paginate(20),
        ]);
    }

    /**
     * Show the form for creating a new task.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('totem::tasks.form', [
            'task'          => new Task,
            'commands'      => Totem::getCommands(),
            'timezones'     => timezone_identifiers_list(),
            'frequencies'   => Totem::frequencies(),
        ]);
    }

    /**
     * Store a newly created task in storage.
     *
     * @param TaskRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskRequest $request)
    {
        $this->tasks->store($request->all());

        return redirect()
            ->route('totem.tasks.all')
            ->with('success', trans('totem::messages.success.create'));
    }

    /**
     * Display the specified task.
     *
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
     * Show the form for editing the specified task.
     *
     * @param $task
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($task)
    {
        return view('totem::tasks.form', [
            'task'          => $task,
            'commands'      => Totem::getCommands(),
            'timezones'     => timezone_identifiers_list(),
            'frequencies'   => Totem::frequencies(),
        ]);
    }

    /**
     * Update the specified task in storage.
     *
     * @param TaskRequest $request
     * @param $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskRequest $request, $task)
    {
        $task = $this->tasks->update($request->all(), $task);

        return redirect()->route('totem.task.view', $task)
            ->with('task', $task)
            ->with('success', trans('totem::messages.success.update'));
    }

    /**
     * Remove the specified task from storage.
     *
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

    /**
     * JSON representation of tasks and their frequencies.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function export()
    {
        return response($this->tasks->findAll()->toJson(), 200, [
            'Content-Type' => 'application/json',
            'Content-Disposition' => 'attachment; filename="totem_tasks.json"',
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function import()
    {
        $errors = [];
        $records_imported = 0;
        if (request()->hasFile('tasks')) {
            $file = request()->file('tasks');
            if (ends_with($file->getClientOriginalName(), '.json')) {
                try {
                    $data = json_decode(file_get_contents($file->getPathname()));
                    foreach ($data as $record) {
                        $task = Task::updateOrCreate([
                            'id' => $record->id,
                        ], [
                            'description' => $record->description,
                            'command' => $record->command,
                            'parameters' => $record->parameters,
                            'expression' => $record->expression,
                            'timezone' => $record->timezone,
                            'is_active' => $record->is_active,
                            'dont_overlap' => $record->dont_overlap,
                            'run_in_maintenance' => $record->run_in_maintenance,
                            'notification_email_address' => $record->notification_email_address,
                            'notification_phone_number' => $record->notification_phone_number,
                            'notification_slack_webhook' => $record->notification_slack_webhook,
                            'auto_cleanup_num' => $record->auto_cleanup_num,
                            'auto_cleanup_type' => $record->auto_cleanup_type,
                        ]);

                        if (! empty($record->frequencies)) {
                            foreach ($record->frequencies as $freq) {
                                Frequency::updateOrCreate([
                                    'id' => $freq->id,
                                ], [
                                    'task_id' => $task->id,
                                    'label' => $freq->label,
                                    'interval' => $freq->interval,
                                ]);
                            }
                        }
                        $records_imported++;
                    }
                } catch (\Exception $ex) {
                    $errors[] = 'An error occurred while importing data.';
                }
            }
        }

        if ($records_imported == 0) {
            $errors[] = 'Invalid data or no record selected.';
        }

        return redirect(route('totem.tasks.all'))->withErrors($errors);
    }
}

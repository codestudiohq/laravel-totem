<?php

namespace Studio\Totem\Repositories;

use Studio\Totem\Task;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Deleted;
use Studio\Totem\Events\Updated;
use Studio\Totem\Events\Creating;
use Studio\Totem\Events\Deleting;
use Studio\Totem\Events\Executed;
use Studio\Totem\Events\Updating;
use Illuminate\Support\Collection;
use Studio\Totem\Events\Activated;
use Studio\Totem\Events\Deactivated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Studio\Totem\Contracts\TaskInterface;

class EloquentTaskRepository implements TaskInterface
{
    /**
     * Return task eloquent builder.
     *
     * @return Task
     */
    public function builder() : Task
    {
        return new Task;
    }

    /**
     * Find a task by id.
     *
     * @param int|Task $id
     *
     * @return Task
     */
    public function find($id) : Task
    {
        if ($id instanceof Task) {
            return $id;
        }

        return Cache::rememberForever('totem.task.'.$id, function () use ($id) {
            return Task::find($id);
        });
    }

    /**
     * Find all tasks.
     *
     * @return Collection
     */
    public function findAll() : Collection
    {
        return Cache::rememberForever('totem.tasks.all', function () {
            return Task::all();
        });
    }

    /**
     * Find all active tasks.
     *
     * @return Collection
     */
    public function findAllActive() : Collection
    {
        return Cache::rememberForever('totem.tasks.active', function () {
            return $this->findAll()->filter(function ($task) {
                return $task->is_active;
            });
        });
    }

    /**
     * Create a new task.
     *
     * @param array $input
     *
     * @return bool|Task
     */
    public function store(array $input)
    {
        $task = new Task;

        if (Creating::dispatch($input) === false) {
            return false;
        }

        $task->fill(array_only($input, $task->getFillable()))->save();

        Created::dispatch($task);

        return $task;
    }

    /**
     * Update the given task.
     *
     * @param array $input
     * @param Task|int $task
     *
     * @return bool|Task
     */
    public function update(array $input, $task)
    {
        $task = $this->find($task);

        if (Updating::dispatch($input, $task) === false) {
            return false;
        }

        $task->fill(array_only($input, $task->getFillable()))->save();

        Updated::dispatch($task);

        return $task;
    }

    /**
     * Delete the given task.
     *
     * @param int|Task $id
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function destroy($id) : bool
    {
        $task = $this->find($id);

        if (Deleting::dispatch($task->id) === false) {
            return false;
        }

        $task->delete();

        Deleted::dispatch();

        return true;
    }

    /**
     * Activate the given task.
     *
     * @param int|Task $id
     *
     * @return Task
     */
    public function activate($id) : Task
    {
        $task = $this->find($id);

        $task->fill(['is_active' => true])->save();

        Activated::dispatch($task);

        return $task;
    }

    /**
     * Deactive the given task.
     *
     * @param int|Task $id
     *
     * @return Task
     */
    public function deactivate($id) : Task
    {
        $task = $this->find($id);

        $task->fill(['is_active' => false])->save();

        Deactivated::dispatch($task);

        return $task;
    }

    /**
     * Execute a given task.
     *
     * @param int|Task $id
     *
     * @return Task
     */
    public function execute($id) : task
    {
        $task = $this->find($id);
        $start = microtime(true);
        try {
            Artisan::call($task->command, $task->compileParameters());

            file_put_contents(storage_path($task->getMutexName()), Artisan::output());
        } catch (\Exception $e) {
            file_put_contents(storage_path($task->getMutexName()), $e->getMessage());
        }

        Executed::dispatch($task, $start);

        return $task;
    }

    /**
     * Import tasks.
     *
     * @param $input
     * @return bool|int|Task|void
     */
    public function import($input)
    {
        collect(json_decode(array_get($input, 'content')))
            ->each(function ($data) {
                $task = $this->find($data->id);

                if (is_null($task)) {
                    $this->store((array) $data);

                    return;
                }

                $this->update((array) $data, $task);
            });
    }
}

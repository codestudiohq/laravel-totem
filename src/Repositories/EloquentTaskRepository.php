<?php

namespace Studio\Totem\Repositories;

use Studio\Totem\Task;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Updated;
use Studio\Totem\Events\Creating;
use Studio\Totem\Events\Updating;
use Studio\Totem\Events\Activated;
use Studio\Totem\Events\Deactivated;
use Illuminate\Support\Facades\Cache;
use Studio\Totem\Contracts\TaskInterface;

class EloquentTaskRepository implements TaskInterface
{
    public function builder()
    {
        return new Task;
    }

    public function find($id)
    {
        if ($id instanceof Task) {
            return $id;
        }

        return Cache::rememberForever('totem.task.'.$id, function () use ($id) {
            return Task::find($id);
        });
    }

    public function isActive($id)
    {
        $task = $this->find($id);

        return $task->is_active;
    }

    public function findAll()
    {
        return Cache::rememberForever('totem.tasks.all', function () {
            return Task::all();
        });
    }

    public function findAllActive()
    {
        return Cache::rememberForever('totem.tasks.active', function () {
            return $this->findAll()->filter(function ($task) {
                return $task->is_active;
            });
        });
    }

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

    public function destroy($id)
    {
        $task = $this->find($id);

        if ($task) {
            Deleted::dispatch($task);

            $task->frequencies()->delete();

            $task->delete();

            return true;
        }

        return false;
    }

    public function activate($input)
    {
        $task = $this->find($input['task_id']);

        $task->fill(['is_active' => true])->save();

        Activated::dispatch($task);

        return $task;
    }

    public function deactivate($id)
    {
        $task = $this->find($id);

        $task->fill(['is_active' => false])->save();

        Deactivated::dispatch($task);

        return $task;
    }
}

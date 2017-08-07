<?php

namespace Studio\Totem\Repositories;

use Studio\Totem\Task;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Creating;
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

        return Cache::tags(['totem:task'])->rememberForever($id, function () use ($id) {
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
        return Cache::tags(['totem:tasks'])->rememberForever('all', function () {
            return Task::all();
        });
    }

    public function findAllActive()
    {
        return Cache::tags(['totem:tasks'])->rememberForever('active', function () {
            return $this->findAll()->filter(function ($task) {
                return $task->is_active;
            });
        });
    }

    /**
     * {@inheritdoc}
     */
    public function store(array $input)
    {
        $task = new Task;

        if (Creating::dispatch($input) === false) {
            return false;
        }

        $task->fill(array_except($input, ['frquencies']))->save();

        $frequencies = array_get($input, 'frequencies', []);

        $task->frequencies()->createMany($frequencies);

        Created::dispatch($task);

        return $task;
    }

    public function update(array $input, $task)
    {
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

        return $task;
    }

    public function deactivate($id)
    {
        $task = $this->find($id);

        $task->fill(['is_active' => false])->save();

        return $task;
    }
}

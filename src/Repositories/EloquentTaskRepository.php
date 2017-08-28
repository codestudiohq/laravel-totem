<?php

namespace Studio\Totem\Repositories;

use Studio\Totem\Task;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Deleted;
use Studio\Totem\Events\Updated;
use Studio\Totem\Events\Creating;
use Studio\Totem\Events\Updating;
use Studio\Totem\Events\Activated;
use Studio\Totem\Events\Deactivated;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Studio\Totem\Events\Tasks\Executed;
use Studio\Totem\Contracts\TaskInterface;

class EloquentTaskRepository implements TaskInterface
{
    /**
     * Return task eloquent builder.
     *
     * @return Task
     */
    public function builder()
    {
        return new Task;
    }

    /**
     * Find a task by id.
     *
     * @param int|Task $id
     * @return int|Task
     */
    public function find($id)
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
     * @return mixed
     */
    public function findAll()
    {
        return Cache::rememberForever('totem.tasks.all', function () {
            return Task::all();
        });
    }

    /**
     * Find all active tasks.
     *
     * @return mixed
     */
    public function findAllActive()
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
     * @return bool|Task
     */
    public function store(array $input)
    {
        $task = new Task;

        if (Creating::dispatch($input) === false) {
            return false;
        }

        $task->fill(array_only($input, $task->getFillable()))->save();

        if ($input['type'] == 'frequency') {
            foreach ($input['frequencies'] as $_frequency) {
                $frequency = $task->frequencies()->create($_frequency);

                if (isset($_frequency['parameters'])) {
                    $frequency->parameters()->createMany($_frequency['parameters']);
                }
            }
        }

        Created::dispatch($task);

        return $task;
    }

    /**
     * Update the given task.
     *
     * @param array $input
     * @param Task $task
     * @return bool|int|Task
     */
    public function update(array $input, $task)
    {
        $task = $this->find($task);

        if (Updating::dispatch($input, $task) === false) {
            return false;
        }

        $task->fill(array_only($input, $task->getFillable()))->save();

        if ($input['type'] == 'frequency') {
            foreach ($task->frequencies as $frequency) {
                if (! in_array($frequency->interval, collect($input['frequencies'])->pluck('interval')->toArray())) {
                    $frequency->delete();
                }
            }
            foreach ($input['frequencies'] as $_frequency) {
                $frequency = $task->frequencies()->updateOrCreate(array_only($_frequency, ['task_id', 'label', 'interval']));

                $parameters = isset($_frequency['parameters']) ? $_frequency['parameters'] : [];
                foreach ($parameters as $_parameter) {
                    $frequency->parameters()->updateOrCreate($_parameter);
                }
            }
        }

        Updated::dispatch($task);

        return $task;
    }

    /**
     * Delete the given task.
     *
     * @param int|Task $id
     * @return bool
     */
    public function destroy($id)
    {
        $task = $this->find($id);

        if ($task) {
            Deleted::dispatch($task);

            $task->frequencies()->delete();

            $task->results()->delete();

            $task->delete();

            return true;
        }

        return false;
    }

    /**
     * Activate the given task.
     *
     * @param $input
     * @return int|Task
     */
    public function activate($input)
    {
        $task = $this->find($input['task_id']);

        $task->fill(['is_active' => true])->save();

        Activated::dispatch($task);

        return $task;
    }

    /**
     * Deactive the given task.
     *
     * @param $id
     * @return int|Task
     */
    public function deactivate($id)
    {
        $task = $this->find($id);

        $task->fill(['is_active' => false])->save();

        Deactivated::dispatch($task);

        return $task;
    }

    /**
     * Execute a given task.
     *
     * @param $id
     * @return int|Task
     */
    public function execute($id)
    {
        $task = $this->find($id);

        $start = microtime(true);

        Artisan::call($task->command);

        file_put_contents(storage_path($task->getMutexName()), Artisan::output());

        Executed::dispatch($task, $start);

        return $task;
    }
}

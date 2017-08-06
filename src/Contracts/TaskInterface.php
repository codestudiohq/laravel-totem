<?php

namespace Studio\Totem\Contracts;

interface TaskInterface
{
    /**
     * Returns Eloquent Builder
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder();

    /**
     * Returns a task by its primary key.
     *
     * @param  int|Task  $id
     * @return Task
     */
    public function find($id);

    /**
     * Checks if the given task is active or not
     *
     * @param  int|Task  $id
     * @return bool
     */
    public function isActive($id);

    /**
     * Returns all tasks.
     * @return Collection
     */
    public function findAll();

    /**
     * Returns all active tasks.
     * @return Collection
     */
    public function findAllActive();

    /**
     * Creates a new task with the given data.
     *
     * @param  array $input
     * @return Task
     */
    public function store(array $input);

    /**
     * Updates the given task with the given data.
     *
     * @param  array $input
     * @param  Task  $task
     * @return Task
     */
    public function update(array $input, $task);

    /**
     * Deletes the given task.
     *
     * @param  int|Task  $id
     * @return bool
     */
    public function destroy($id);
}

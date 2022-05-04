<?php

namespace Studio\Totem\Contracts;

interface TaskInterface
{
    /**
     * Returns Eloquent Builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function builder();

    /**
     * Returns a task by its primary key.
     *
     * @param  int|\Studio\Totem\Task  $id
     * @return \Studio\Totem\Task
     */
    public function find($id);

    /**
     * Returns all tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAll();

    /**
     * Returns all active tasks.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findAllActive();

    /**
     * Creates a new task with the given data.
     *
     * @param  array  $input
     * @return \Studio\Totem\Task
     */
    public function store(array $input);

    /**
     * Updates the given task with the given data.
     *
     * @param  array  $input
     * @param  \Studio\Totem\Task  $task
     * @return \Studio\Totem\Task
     */
    public function update(array $input, $task);

    /**
     * Deletes the given task.
     *
     * @param  int|\Studio\Totem\Task  $id
     * @return bool
     */
    public function destroy($id);

    /**
     * Executes the given task.
     *
     * @param  int|\Studio\Totem\Task  $id
     * @return bool
     */
    public function execute($id);
}

<?php

namespace Studio\Totem\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Studio\Totem\Task;

interface TaskInterface
{
    /**
     * Returns Eloquent Builder.
     *
     * @return Builder
     */
    public function builder(): Builder;

    /**
     * Returns a task by its primary key.
     *
     * @param  int|Task  $id
     * @return Task
     */
    public function find(Task|int $id);

    /**
     * Returns all tasks.
     *
     * @return Collection
     */
    public function findAll(): Collection;

    /**
     * Returns all active tasks.
     *
     * @return Collection
     */
    public function findAllActive(): Collection;

    /**
     * Creates a new task with the given data.
     *
     * @param  array  $input
     * @return Task|bool
     */
    public function store(array $input): Task|bool;

    /**
     * Updates the given task with the given data.
     *
     * @param  array  $input
     * @param  Task  $task
     * @return Task
     */
    public function update(array $input, Task $task): Task;

    /**
     * Deletes the given task.
     *
     * @param  int|Task  $id
     * @return bool
     */
    public function destroy(Task|int $id): bool;

    /**
     * Executes the given task.
     *
     * @param  int|Task  $id
     * @return Task
     */
    public function execute(Task|int $id): Task;
}

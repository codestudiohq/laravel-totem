<?php

namespace Studio\Totem\SqlSrv;

use Illuminate\Support\Arr;
use Studio\Totem\SqlSrv\Task;
use Studio\Totem\Events\Created;
use Studio\Totem\Events\Creating;
use Illuminate\Support\Facades\DB;
use Studio\Totem\Repositories\EloquentTaskRepository;

class SqlSrvEloquentTaskRepository extends EloquentTaskRepository
{
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
        DB::unprepared("SET IDENTITY_INSERT " . TOTEM_TABLE_PREFIX . "tasks ON");        
        $task->fill(Arr::only($input, $task->getFillable()))->save();
        DB::unprepared("SET IDENTITY_INSERT " . TOTEM_TABLE_PREFIX . "tasks OFF");
        Created::dispatch($task);

        return $task;
    }
}

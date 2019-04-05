<?php

namespace Studio\Totem;

use Illuminate\Support\Facades\DB;

class Result extends TotemModel
{
    protected $table = 'task_results';

    protected $fillable = [
        'duration',
        'result',
    ];

    protected $dates = [
        'ran_at',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function getLastRun()
    {
        return $this->select('ran_at')
            ->whereColumn('task_id', 'tasks.id')
            ->latest()
            ->limit(1)
            ->getQuery();
    }

    public function getAverageRunTime()
    {
        return $this->select(DB::raw('avg(duration)'))
            ->whereColumn('task_id', 'tasks.id')
            ->getQuery();
    }
}

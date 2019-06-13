<?php

namespace Studio\Totem;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

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

    /**
     * @return Builder
     */
    public function getLastRun() : Builder
    {
        return $this->select('ran_at')
            ->whereColumn('task_id', TOTEM_TABLE_PREFIX.'tasks.id')
            ->latest()
            ->limit(1)
            ->getQuery();
    }

    /**
     * @return Builder
     */
    public function getAverageRunTime() : Builder
    {
        return $this->select(DB::raw('avg(duration)'))
            ->whereColumn('task_id', TOTEM_TABLE_PREFIX.'tasks.id')
            ->getQuery();
    }
}

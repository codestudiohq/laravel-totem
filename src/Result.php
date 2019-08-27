<?php

namespace Studio\Totem;

class Result extends TotemModel
{
    protected $table = 'task_results';

    protected $fillable = [
        'duration',
        'result',
        'ran_at'
    ];

    protected $dates = [
        'ran_at',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

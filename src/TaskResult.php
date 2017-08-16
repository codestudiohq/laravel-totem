<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class TaskResult extends Model
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
}

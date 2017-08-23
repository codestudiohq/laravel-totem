<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table = 'task_frequencies';

    protected $fillable = [
        'label',
        'interval',
        'on',
        'at',
        'second_at',
        'start',
        'end',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

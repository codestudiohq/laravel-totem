<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;
use Studio\Totem\Traits\HasTablePrefix;

class Result extends Model
{
    use HasTablePrefix;

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

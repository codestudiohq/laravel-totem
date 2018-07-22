<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * @return BelongsTo
     */
    public function task() : BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}

<?php

namespace Studio\Totem;

use Studio\Totem\Traits\HasParameters;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Frequency extends TotemModel
{
    use HasParameters;

    protected $table = 'task_frequencies';

    protected $fillable = [
        'label',
        'interval',
    ];

    /**
     * @return BelongsTo
     */
    public function task() : ?BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}

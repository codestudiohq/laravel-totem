<?php

namespace Studio\Totem;

use Studio\Totem\Traits\HasParameters;
use Illuminate\Database\Eloquent\Model;
use Studio\Totem\Traits\HasTablePrefix;

class Frequency extends Model
{
    use HasParameters, HasTablePrefix;

    protected $table = 'task_frequencies';

    protected $fillable = [
        'label',
        'interval',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

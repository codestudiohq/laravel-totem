<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    protected $table = 'totem_task_frequencies';

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function parameters()
    {
        return $this->hasMany(Parameter::class);
    }
}

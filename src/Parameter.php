<?php

namespace Studio\Totem;

class Parameter extends TotemModel
{
    protected $table = 'frequency_parameters';

    protected $fillable = [
        'name',
        'value',
    ];

    public function task()
    {
        return $this->belongsTo(Frequency::class);
    }
}

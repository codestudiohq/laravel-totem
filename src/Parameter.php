<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
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

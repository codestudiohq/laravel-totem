<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;
use Studio\Totem\Traits\HasTablePrefix;

class Parameter extends Model
{
    use HasTablePrefix;

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

<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class TotemModel extends Model
{
    /**
     * @return string
     */
    public function getTable() : string
    {
        return config('totem.table_prefix').parent::getTable();
    }
}

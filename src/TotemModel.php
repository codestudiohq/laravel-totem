<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class TotemModel extends Model
{
    /**
     * @return mixed
     */
    public function getTable()
    {
        return config('totem.table_prefix').parent::getTable();
    }
}

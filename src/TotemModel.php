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
        if (str_contains(parent::getTable(), config('totem.table_prefix'))) {
            return parent::getTable();
        }

        return config('totem.table_prefix').parent::getTable();
    }
}

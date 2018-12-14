<?php

namespace Studio\Totem;

use Illuminate\Database\Eloquent\Model;

class TotemModel extends Model
{
    protected $connection = TOTEM_DATABASE_CONNECTION;

    /**
     * @return mixed
     */
    public function getTable()
    {
        if (str_contains(parent::getTable(), TOTEM_TABLE_PREFIX)) {
            return parent::getTable();
        }

        return TOTEM_TABLE_PREFIX.parent::getTable();
    }
}

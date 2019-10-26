<?php

namespace Studio\Totem;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TotemModel extends Model
{
    protected $connection = TOTEM_DATABASE_CONNECTION;

    /**
     * @return mixed
     */
    public function getTable()
    {
        if (Str::contains(parent::getTable(), TOTEM_TABLE_PREFIX)) {
            return parent::getTable();
        }

        return TOTEM_TABLE_PREFIX.parent::getTable();
    }
}

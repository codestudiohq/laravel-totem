<?php

namespace Studio\Totem\Traits;

trait HasTablePrefix
{
    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        return config('totem.table_prefix').parent::getTable();
    }
}

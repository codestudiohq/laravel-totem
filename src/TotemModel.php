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

    /**
     * Get the current connection name for the model. Override all TotemModel instances with the
     * specified Totem connection if present.
     *
     * @return string
     */
    public function getConnectionName()
    {
        $totem_connection_name = config('totem.database_connection', $this->connection);
        if (! $totem_connection_name) {
            // Catch if an empty name was passed in
            $totem_connection_name = $this->connection;
        }
        return $totem_connection_name;
    }
}

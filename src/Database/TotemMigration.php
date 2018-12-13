<?php

namespace Studio\Totem\Database;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

abstract class TotemMigration extends Migration
{
    /**
     * Get the migration connection name.
     *
     * @return string
     */
    public function getConnection()
    {
        $totem_connection_name = config('totem.database_connection', Schema::getConnection()->getName());
        if (! $totem_connection_name) {
            // Catch if an empty name was passed in
            $totem_connection_name = Schema::getConnection()->getName();
        }
        return $totem_connection_name;
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Studio\Totem\Database\TotemMigration;

class AlterTasksTableAddRunOnOneServerSupport extends TotemMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(TOTEM_DATABASE_CONNECTION)
            ->table(TOTEM_TABLE_PREFIX.'tasks', function (Blueprint $table) {
                $table->boolean('run_on_one_server')->default(false);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(TOTEM_DATABASE_CONNECTION)
            ->table(TOTEM_TABLE_PREFIX.'tasks', function (Blueprint $table) {
                $table->dropColumn('run_on_one_server');
            });
    }
}

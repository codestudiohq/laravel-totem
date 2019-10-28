<?php

use Illuminate\Database\Migrations\Migration;

class AlterTaskResultsTableChangeTypeRanAtFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE ' . config('totem.table_prefix') . 'task_results' . ' CHANGE `ran_at` `ran_at` TIMESTAMP NULL DEFAULT NULL;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statment('ALTER TABLE ' . config('totem.table_prefix') . 'task_results' . ' CHANGE `ran_at` `ran_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;');
    }
}

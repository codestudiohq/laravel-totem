<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTasksTableAddAutoCleanupNumAndTypeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('totem.table_prefix').'tasks', function (Blueprint $table) {
            $table->string('auto_cleanup_num')->default(0);
            $table->string('auto_cleanup_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('totem.table_prefix').'tasks', function (Blueprint $table) {
            $table->dropColumn('auto_cleanup_num');
        });

        Schema::table(config('totem.table_prefix').'tasks', function (Blueprint $table) {
            $table->dropColumn('auto_cleanup_type');
        });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTasksTableAddAutoCleanupNumAndTypeFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('totem.table_prefix') . 'task_results', function (Blueprint $table) {
            $table->index('task_id', 'task_id_idx');
            $table->index('ran_at', 'ran_at_idx');
            $table->foreign('task_id', 'task_id_fk')
                ->references('task_id')->on('tasks');
        });

        Schema::table(config('totem.table_prefix') . 'task_frequencies', function (Blueprint $table) {
            $table->index('task_id', 'task_id_idx');
            $table->foreign('task_id', 'task_id_fk')
                ->references('task_id')->on('tasks');
        });

        Schema::table(config('totem.table_prefix') . 'tasks', function (Blueprint $table) {
            $table->index('is_active', 'is_active_idx');
            $table->index('dont_overlap', 'dont_overlap_idx');
            $table->index('run_in_maintenance', 'run_in_maintenance_idx');
            $table->index('run_on_one_server', 'run_on_one_server_idx');
            $table->index('auto_cleanup_num', 'auto_cleanup_num_idx');
            $table->index('auto_cleanup_type', 'auto_cleanup_type_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('totem.table_prefix') . 'task_results', function (Blueprint $table) {
            $table->dropIndex('task_id_idx');
            $table->dropIndex('ran_at_idx');
            $table->dropForeign('task_id_fk');
        });

        Schema::table(config('totem.table_prefix') . 'task_frequencies', function (Blueprint $table) {
            $table->dropIndex('task_id_idx');
            $table->dropForeign('task_id_fk');
        });

        Schema::table(config('totem.table_prefix') . 'tasks', function (Blueprint $table) {
            $table->dropIndex('is_active_idx');
            $table->dropIndex('dont_overlap_idx');
            $table->dropIndex('run_in_maintenance_idx');
            $table->dropIndex('run_on_one_server_idx');
            $table->dropIndex('auto_cleanup_num_idx');
            $table->dropIndex('auto_cleanup_type_idx');
        });
    }
}

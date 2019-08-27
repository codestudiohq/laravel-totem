<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTasksTableChangeTypeParametersFileds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(config('totem.table_prefix') . 'tasks', function (Blueprint $table) {
            $table->text('parameters')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(config('totem.table_prefix') . 'tasks', function (Blueprint $table) {
            $table->string('parameters')->nullable()->change();
        });
    }
}

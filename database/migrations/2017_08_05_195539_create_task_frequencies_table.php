<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use \Studio\Totem\Database\TotemMigration;

class CreateTaskFrequenciesTable extends TotemMigration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection($this->getConnection())
            ->create(config('totem.table_prefix').'task_frequencies', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('task_id');
                $table->string('label');
                $table->string('interval');
                $table->timestamps();
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection($this->getConnection())
            ->dropIfExists(config('totem.table_prefix').'task_frequencies');
    }
}

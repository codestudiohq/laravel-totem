<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskFrequenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_frequencies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('task_id');
            $table->enum('frequency', [
                'everyMinute',
                'everyFiveMinutes',
                'everyTenMinutes',
                'everyThirtyMinutes',
                'hourly',
                'hourlyAt',
                'daily',
                'dailyAt',
                'twiceDaily',
                'weekly',
                'monthly',
                'monthlyOn',
                'quarterly',
                'yearly',
                'weekdays',
                'sundays',
                'mondays',
                'tuesdays',
                'wednesdays',
                'thursdays',
                'fridays',
                'saturdays',
            ]);
            $table->date('on')->nullable();
            $table->time('at')->nullable();
            $table->time('second_at')->nullable();
            $table->time('start')->nullable();
            $table->time('end')->nullable();
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
        Schema::dropIfExists('task_frequencies');
    }
}

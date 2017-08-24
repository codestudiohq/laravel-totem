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
            $table->string('label');
            $table->enum('interval', [
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
                'weeklyOn',
                'monthly',
                'twiceMonthly',
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
            $table->integer('on')->nullable();
            $table->integer('second_on')->nullable();
            $table->string('at')->nullable();
            $table->string('second_at')->nullable();
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

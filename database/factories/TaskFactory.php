<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Studio\Totem\Task;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'description'  => $this->faker->sentence,
            'command'      => 'Studio\Totem\Console\Commands\ListSchedule',
            'expression'   => '* * * * *',
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Studio\Totem\Task;

class TotemTaskFactory extends Factory
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

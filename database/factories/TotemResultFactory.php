<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Studio\Totem\Result;

class TotemResultFactory extends Factory
{
    protected $model = Result::class;

    public function definition()
    {
        return [
            'task_id'     => $this->faker->randomDigit,
            'ran_at'      => $this->faker->dateTimeBetween('-1 hour'),
            'duration'    => (string) $this->faker->randomFloat(11, 0, 8000000),
            'result'      => $this->faker->sentence,
            'created_at'  => $this->faker->dateTimeBetween('-1 year', '-6 months'),
            'updated_at'  => $this->faker->dateTimeBetween('-6 months'),
        ];
    }
}

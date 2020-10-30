<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Studio\Totem\User;

class TotemUserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        static $password;

        return [
            'name'           => $this->faker->name,
            'email'          => $this->faker->unique()->safeEmail,
            'password'       => $password ?: $password = bcrypt('secret'),
            'remember_token' => Str::random(10),
        ];
    }
}

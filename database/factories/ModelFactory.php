<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(Studio\Totem\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name'           => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'password'       => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Studio\Totem\Task::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'description'  => $faker->sentence,
        'command'      => 'Studio\Totem\Console\Commands\ListSchedule',
        'expression'   => '* * * * *',
    ];
});

$factory->define(Studio\Totem\Result::class, function (Faker\Generator $faker) {
    return [
        'task_id'     => $faker->randomDigit,
        'ran_at'      => $faker->dateTimeBetween('-1 hour'),
        'duration'    => (string) $faker->randomFloat(11, 0, 8000000),
        'result'      => $faker->sentence,
        'created_at'  => $faker->dateTimeBetween('-1 year', '-6 months'),
        'updated_at'  => $faker->dateTimeBetween('-6 months'),
    ];
});

<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Comment::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 4),
        'question_id' => $faker->numberBetween($min = 1, $max = 3000),
        'comment' => $faker->realText(),
        'created_at' => $faker->dateTimeBetween($startDate = '-20years', $endDate = '-15years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-10years', $endDate = '-5years'),
    ];
});

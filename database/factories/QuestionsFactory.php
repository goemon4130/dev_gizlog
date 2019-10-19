<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Question::class, function (Faker $faker) {
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = 4),
        'tag_category_id' => $faker->numberBetween($min = 1, $max = 4),
        'title' => $faker->realText(),
        'content' => $faker->realText(1000),
        'created_at' => $faker->dateTimeBetween($startDate = '-20years', $endDate = '-15years'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-10years', $endDate = '-5years'),
    ];
});

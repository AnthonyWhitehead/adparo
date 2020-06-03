<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {

    $types = config('item.types');

    return [
        'type' => $types[rand(0, count($types) -1)],
        'title' => $faker->word,
        'description' => $faker->text,
        'acceptance_criteria' => $faker->text()
    ];
});

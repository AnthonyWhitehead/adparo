<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;
use Illuminate\Support\Arr;

$factory->define(Item::class, function (Faker $faker) {

    return [
        'type' => Arr::random(config('item.types')),
        'title' => $faker->word,
        'description' => $faker->text,
        'acceptance_criteria' => $faker->text()
    ];
});

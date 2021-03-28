<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => Str::ucfirst($faker->word) . ' ' . Str::ucfirst($faker->word),
        'email' => $faker->email,
        'website' => $faker->url,
    ];
});

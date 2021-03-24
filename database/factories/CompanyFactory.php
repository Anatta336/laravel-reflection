<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'email' => $faker->email,
        'logo' => ($faker->word) . '.png',
        'website' => $faker->url,
        /*
        $table->timestamps();
        */
    ];
});

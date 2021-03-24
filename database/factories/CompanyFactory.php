<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'logo' => ($faker->word) . '.png',
        'website' => $faker->url,
        /*
        $table->timestamps();
        */
    ];
});

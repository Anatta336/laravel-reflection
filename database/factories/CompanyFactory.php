<?php

use App\Company;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$factory->define(Company::class, function (Faker $faker) {
    // pick a random logo image to use
    $logos = Storage::files('public/logos');
    $logo = $logos[rand(0, count($logos) - 1)];

    // get the image path into the right form
    $logo = Str::after($logo, 'public/');
    
    return [
        'name' => Str::ucfirst($faker->word) . ' ' . Str::ucfirst($faker->word),
        'email' => $faker->email,
        'website' => $faker->url,
        'logo' => $logo,
    ];
});

<?php

use App\Company;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

$factory->define(Company::class, function (Faker $faker) {
    // find all available logo images
    $logos = array_filter(
        Storage::disk('public')->files('logos'),
        function ($path) {
            // exclude any file with a leading . such as .gitignore
            return !Str::contains($path, '/.');
        }
    );

    if (count($logos) > 0) {
        // pick a random logo to use
        $logo = $logos[rand(0, count($logos) - 1)];
    } else {
        // no available logo images
        $logo = '';
    }

    return [
        'name'    => Str::ucfirst($faker->word) . ' ' . Str::ucfirst($faker->word),
        'email'   => $faker->email,
        'website' => $faker->url,
        'logo'    => $logo,
    ];
});

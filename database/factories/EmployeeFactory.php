<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        // assign to a random company, or create a new one if none exist
        'company_id' => function() {
            $company = Company::all()->random() ?? factory(Company::class)->create();
            return $company->id;
        },
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});

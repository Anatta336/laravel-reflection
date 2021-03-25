<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'company_id' => function() {
            // some employees will have no company
            $hasCompany = rand(0, 5) >= 1;
            if (!$hasCompany) {
                return null;
            }
            
            // assign to a random company, or create a new one if none exist
            $company = Company::all()->random() ?? factory(Company::class)->create();
            return $company->id;
        },
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});

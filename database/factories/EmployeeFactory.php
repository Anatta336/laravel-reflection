<?php

use App\Company;
use Faker\Generator as Faker;

$factory->define(App\Employee::class, function (Faker $faker) {
    return [
        'company_id' => function () {
            // assign to a random company, or create a new one if none exist
            if (Company::all()->count() > 0) {
                $company = Company::all()->random();
            } else {
                $company = factory(Company::class)->create();
            }
            return $company->id;
        },
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
    ];
});

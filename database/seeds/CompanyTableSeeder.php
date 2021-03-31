<?php

use App\Company;
use Illuminate\Database\Seeder;

// Laravel seeders intentionally have no namespace
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Seeds the company table.
 *
 * @package Company
 */
class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class, 10)->create();
    }
}

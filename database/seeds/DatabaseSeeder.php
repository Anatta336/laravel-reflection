<?php

use Illuminate\Database\Seeder;

// Laravel seeders intentionally have no namespace
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Seeds the whole database.
 *
 * @package Database
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
    }
}

<?php

use App\Employee;
use Illuminate\Database\Seeder;

// Laravel seeders intentionally have no namespace
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace

/**
 * Seeder for the employees database table.
 *
 * @package Employee
 */
class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Employee::class, 250)->create();
    }
}

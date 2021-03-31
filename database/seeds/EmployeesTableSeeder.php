<?php

use App\Employee;
use Illuminate\Database\Seeder;

/**
 * Seeder for the employees database table.
 *
 * @package Employee
 */
// phpcs:disable
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
// phpcs:enable

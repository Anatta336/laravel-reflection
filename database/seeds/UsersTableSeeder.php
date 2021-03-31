<?php

use App\User;
use Illuminate\Database\Seeder;

/**
 * Seeder for the users database table.
 * Creates sample user accounts for use in testing.
 *
 * @package User
 */
// phpcs:disable
class UsersTableSeeder extends Seeder
{
    // phpcs:enable

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create an admin user with full rights
        $admin                    = new User();
        $admin->name              = 'Administrator';
        $admin->email             = 'admin@example.com';
        $admin->password          = password_hash('password', PASSWORD_DEFAULT);
        $admin->canEditCompany    = true;
        $admin->canDeleteCompany  = true;
        $admin->canCreateCompany  = true;
        $admin->canEditEmployee   = true;
        $admin->canDeleteEmployee = true;
        $admin->canCreateEmployee = true;
        $admin->save();

        // create a user with rights over employees, not companies
        $manager                    = new User();
        $manager->name              = 'Manager';
        $manager->email             = 'manager@example.com';
        $manager->password          = password_hash('password', PASSWORD_DEFAULT);
        $manager->canEditCompany    = false;
        $manager->canDeleteCompany  = false;
        $manager->canCreateCompany  = false;
        $manager->canEditEmployee   = true;
        $manager->canDeleteEmployee = true;
        $manager->canCreateEmployee = true;
        $manager->save();

        // create another user with no special rights
        $accountant                    = new User();
        $accountant->name              = 'Accountant';
        $accountant->email             = 'accountant@example.com';
        $accountant->password          = password_hash('password', PASSWORD_DEFAULT);
        $accountant->canEditCompany    = false;
        $accountant->canDeleteCompany  = false;
        $accountant->canCreateCompany  = false;
        $accountant->canEditEmployee   = false;
        $accountant->canDeleteEmployee = false;
        $accountant->canCreateEmployee = false;
        $accountant->save();
    }
}

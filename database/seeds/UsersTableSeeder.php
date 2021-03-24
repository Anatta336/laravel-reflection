<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create a single admin user
        $admin = new User();
        $admin->name = 'Administrator';
        $admin->email = 'admin@example.com';
        $admin->password = password_hash('password', PASSWORD_DEFAULT);
        $admin->save();
    }
}

<?php

namespace Tests\Feature;

use App\Employee;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_with_rights_can_create_new_employee()
    {
        $user = factory('App\User')->create([
            'canCreateEmployee' => true,
        ]);
        $this->actingAs($user);

        $response = $this->post('/employee', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => null,
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]);

        $response->assertStatus(200);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('employees', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974',
        ]);
    }

    /** @test */
    public function user_without_rights_can_not_create_new_employee()
    {
        $user = factory('App\User')->create([
            'canCreateEmployee' => false,
        ]);
        $this->actingAs($user);

        $response = $this->post('/employee', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => null,
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('employees', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974',
        ]);
    }

    /** @test */
    public function can_not_create_new_employee_without_name()
    {
        $user = factory('App\User')->create([
            'canCreateEmployee' => true,
        ]);
        $this->actingAs($user);

        $response = $this->post('/employee', [
            'first_name' => '',
            'last_name' => '',
            'company_id' => null,
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name']);
        $this->assertDatabaseMissing('employees', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974',
        ]);
    }
}

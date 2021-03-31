<?php

namespace Tests\Feature;

use App\Employee;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Feature tests for manipulating Employees.
 * 
 * @package Employee
 * 
 * @SuppressWarnings(CamelCaseMethodName)
 * @SuppressWarnings(TooManyPublicMethods)
 */
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

        $response = $this->post(route('employee.store', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => null,
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]));
        
        // after redirects, end up at success
        $this->followRedirects($response)->assertSuccessful();

        // no errors
        $response->assertSessionHasNoErrors();

        // created employee is in the database
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

        $response = $this->post(route('employee.store', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => null,
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]));

        $this->followRedirects($response)->assertForbidden();
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

        $response = $this->post(route('employee.store', [
            'first_name' => '',
            'last_name' => '',
            'company_id' => null,
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]));
        
        $response->assertSessionHasErrors(['first_name', 'last_name']);
        $this->assertDatabaseMissing('employees', [
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974',
        ]);
    }

    /** @test */
    public function can_create_employee_of_company()
    {
        $company = factory('App\Company')->create();
        $user = factory('App\User')->create([
            'canCreateEmployee' => true,
        ]);
        $this->actingAs($user);

        $response = $this->post(route('employee.store', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => "{$company->id}",
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]));

        $response->assertSessionHasNoErrors();

        $this->followRedirects($response)->assertSuccessful();

        $this->assertDatabaseHas('employees', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => "{$company->id}",
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974',
        ]);
    }

    /** @test */
    public function can_not_create_employee_of_missing_company()
    {
        $user = factory('App\User')->create([
            'canCreateEmployee' => true,
        ]);
        $this->actingAs($user);

        $response = $this->post(route('employee.store', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'company_id' => '1',
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974'
        ]));

        $response->assertSessionHasErrors(['company_id']);
        $this->assertDatabaseMissing('employees', [
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'janesmith@example.com',
            'phone' => '(+44) 01334 555 974',
        ]);
    }

    /** @test */
    public function can_delete_employee()
    {
        // act as a user with destroy rights
        $user = factory('App\User')->create([
            'canDeleteEmployee' => true,
        ]);
        $this->actingAs($user);

        // create some employees (not using User's rights)
        $employees = factory('App\Employee', 5)->create();
        $toRemove = $employees[2];

        // check they're definitely in the database
        $this->assertDatabaseHas('employees', [
            'id' => $toRemove->id,
        ]);
        
        // delete one of the employees
        $response = $this->delete(route('employee.destroy', ['employee' => $toRemove]));
        
        $response->assertSessionHasNoErrors();

        // check the employee is now gone
        $this->assertDatabaseMissing('employees', [
            'id' => $toRemove->id,
        ]);
    }

    /** @test */
    public function without_right_can_not_delete_employee()
    {
        // act as a user with destroy rights
        $user = factory('App\User')->create([
            'canDeleteEmployee' => false,
        ]);
        $this->actingAs($user);

        // create some employees (not using User's rights)
        $employees = factory('App\Employee', 5)->create();
        $toRemove = $employees[2];

        // check they're definitely in the database
        $this->assertDatabaseHas('employees', [
            'id' => $toRemove->id,
        ]);
        
        // attempt to delete one of the employees
        $response = $this->delete(route('employee.destroy', ['employee' => $toRemove]));
        
        // forbidden status
        $response->assertForbidden();

        // employee is still in database
        $this->assertDatabaseHas('employees', [
            'id' => $toRemove->id,
        ]);
    }

    /** @test */
    public function user_can_view_employee()
    {
        // user with no special rights
        $user = factory('App\User')->create();
        $this->actingAs($user);

        // create employees
        $employees = factory('App\Employee', 5)->create();
        $toView = $employees[1];

        // check target is in database
        $this->assertDatabaseHas('employees', [
            'id' => $toView->id,
        ]);

        // attempt to view employee
        $response = $this->get(route('employee.show', ['employee' => $toView]));

        // response should be a success with no errors
        $response->assertSuccessful();
        $response->assertSessionHasNoErrors();
        
        $response->assertViewHas('employee', $toView);
    }

    /** @test */
    public function guest_can_not_view_employee()
    {
        // create employees
        $employees = factory('App\Employee', 5)->create();
        $toView = $employees[1];

        // check target is in database
        $this->assertDatabaseHas('employees', [
            'id' => $toView->id,
        ]);

        // attempt to view employee
        $response = $this->get(route('employee.show', ['employee' => $toView]));

        // guest should be forbidden from viewing an employee
        $response->assertForbidden();
    }

    /** @test */
    public function user_can_list_employees()
    {
        // user with no special rights
        $user = factory('App\User')->create();
        $this->actingAs($user);

        // create employees
        factory('App\Employee', 5)->create();

        // attempt to view list of employees
        $response = $this->get(route('employee.index'));

        // response should be a success with no errors
        $response->assertSuccessful();
        $response->assertSessionHasNoErrors();
    }

    /** @test */
    public function guest_can_not_list_employees()
    {
        // create employees
        factory('App\Employee', 5)->create();

        // attempt to view list of employees
        $response = $this->get(route('employee.index'));

        // guest should be forbidden
        $response->assertForbidden();
    }
}

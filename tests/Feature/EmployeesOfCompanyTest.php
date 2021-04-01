<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

// phpcs:disable PEAR.NamingConventions.ValidFunctionName.ScopeNotCamelCaps
// phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

/**
 * Feature tests for manipulating Employees.
 *
 * @package Employee
 *
 * @SuppressWarnings(CamelCaseMethodName)
 * @SuppressWarnings(TooManyPublicMethods)
 */
class EmployeesOfCompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function user_can_list_employees_of_company()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // create companies
        $companies     = factory(Company::class, 2)->create();
        $targetCompany = $companies[0];
        $otherCompany  = $companies[1];

        /**
         * Employees that are assigned to target company.
         *
         * @var Collection $targetEmployees
         */
        $targetEmployees = factory(Employee::class, 10)->create([
            'company_id' => $targetCompany->id,
        ]);

        // create other employees
        factory(Employee::class, 20)->create([
            'company_id' => $otherCompany->id,
        ]);

        // request index of employees for target company
        $response = $this->get(route('employeesOfCompany.index', ['company' => $targetCompany]));

        // response should be success with no errors
        $response->assertSuccessful();
        $response->assertSessionHasNoErrors();

        /**
         * Employees present in the returned view.
         * Due to pagination, this will be a maximum of 10 employees.
         *
         * @var Collection $responseEmployees
         */
        $responseEmployees = $response->viewData('employees');

        // all employees listed in response are members of target group
        $this->assertTrue(
            $responseEmployees->every(
                function ($employeeInResponse) use ($targetEmployees) {
                    return !!$targetEmployees->firstWhere('id', $employeeInResponse->id);
                }
            )
        );

        // all members of the target group are listed in the response
        $this->assertTrue(
            $targetEmployees->every(
                function ($employeeInTarget) use ($responseEmployees) {
                    return !!$responseEmployees->firstWhere('id', $employeeInTarget->id);
                }
            )
        );
    }

    /**
     * @test
     *
     * @return void
     */
    public function guest_can_not_list_employees_of_company()
    {
        // create companies
        $companies     = factory(Company::class, 2)->create();
        $targetCompany = $companies[0];
        $otherCompany  = $companies[1];


        // create employees for target company
        factory(Employee::class, 10)->create([
            'company_id' => $targetCompany->id,
        ]);

        // create other employees
        factory(Employee::class, 20)->create([
            'company_id' => $otherCompany->id,
        ]);

        // request index of employees for target company
        $response = $this->get(route('employeesOfCompany.index', ['company' => $targetCompany]));

        // response should be forbidden
        $response->assertForbidden();
    }
}

<?php

namespace Tests\Feature;

use App\Company;
use App\Employee;
use App\User;
use Faker\Factory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
class CompanyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function user_can_list_companies()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->get(route('company.index'));

        // after redirects, end up at success
        $this->followRedirects($response)->assertSuccessful();

        // no errors
        $response->assertSessionHasNoErrors();
    }

    /**
     * @test
     *
     * @return void
     */
    public function guest_can_not_list_companies()
    {
        $response = $this->get(route('company.index'));

        // after redirects, end up at forbidden
        $this->followRedirects($response)->assertForbidden();
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_can_view_company()
    {
        // all users have the right to view
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // create companies
        $companies = factory(Company::class, 5)->create();
        $company   = $companies[3];

        // check the target company was created
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
        ]);

        // have user request company details
        $response = $this->get(route('company.show', ['company' => $company]));

        // should receive successful response with no errors, and with the requested company
        $response->assertSuccessful();
        $response->assertSessionHasNoErrors();
        $response->assertViewHas('company', $company);
    }

    /**
     * @test
     *
     * @return void
     */
    public function guest_can_not_view_company()
    {
        // create companies
        $companies = factory(Company::class, 5)->create();
        $company   = $companies[3];

        // check the target company was created
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
        ]);

        // have guest request company details
        $response = $this->get(route('company.show', ['company' => $company]));

        // should be forbidden from accessing
        $response->assertForbidden();
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_with_rights_can_create_company()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        // create a fake image 300px square, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        $company = Company::first();

        // the file should have been uploaded (into a faked drive)
        Storage::disk('public')->assertExists($company->logo);

        $responseEnd = $this->followRedirects($response);
        $responseEnd->assertSuccessful();
        $responseEnd->assertSessionHasNoErrors();
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_without_rights_can_not_create_company()
    {
        // act as user without creation permissions
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // create a fake image 300px square, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        // there should be no file stored
        $this->assertEmpty(Storage::disk('public')->files('logos'));

        // the user should reach a forbidden error
        $responseEnd = $this->followRedirects($response);
        $responseEnd->assertForbidden();
    }
}

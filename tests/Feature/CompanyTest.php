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

        // the file should have been uploaded (into the faked drive)
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

    /**
     * @test
     *
     * @return void
     */
    public function creating_company_requires_logo()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
        ]);

        // response should have a validation error about the logo
        $response->assertSessionHasErrors(['logo-file']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function creating_company_requires_logo_dimensions_above_100()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        // create a fake image 50px square, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 50, 50)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        // no company should be created
        $this->assertDatabaseMissing('companies', [
            'name' => 'Test Company',
        ]);

        // no logo file should be stored
        $this->assertEmpty(Storage::disk('public')->files('logos'));

        // validation error should be reported
        $response->assertSessionHasErrors(['logo-file']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function creating_company_requires_logo_width_above_100()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        // create a fake image 50px width, 300px height, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 50, 300)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        // no company should be created
        $this->assertDatabaseMissing('companies', [
            'name' => 'Test Company',
        ]);

        // no logo file should be stored
        $this->assertEmpty(Storage::disk('public')->files('logos'));

        // validation error should be reported
        $response->assertSessionHasErrors(['logo-file']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function creating_company_requires_logo_height_above_100()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        // create a fake image 300px width, 50px height, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 50)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        // no company should be created
        $this->assertDatabaseMissing('companies', [
            'name' => 'Test Company',
        ]);

        // no logo file should be stored
        $this->assertEmpty(Storage::disk('public')->files('logos'));

        // validation error should be reported
        $response->assertSessionHasErrors(['logo-file']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function creating_company_requires_logo_file_size_reasonable()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        // create a fake image 300px square, 100MiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(100 * 1024);

        // use a fake version of the public drive
        Storage::fake('public');

        // send post request to create a company
        $response = $this->post(route('company.store'), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        // no company should be created
        $this->assertDatabaseMissing('companies', [
            'name' => 'Test Company',
        ]);

        // no logo file should be stored
        $this->assertEmpty(Storage::disk('public')->files('logos'));

        // validation error should be reported
        $response->assertSessionHasErrors(['logo-file']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_with_rights_can_edit_company()
    {
        // act as user with edit permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
        ]);
        $this->actingAs($user);

        // create the company that will be updated
        $company = factory(Company::class)->create();

        // create a fake image 300px square, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send patch request to update a company
        $response = $this->patch(route('company.update', ['company' => $company]), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        $company = Company::first();

        // the company should have been updated
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
        ]);

        // the file should have been uploaded (into the faked drive)
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
    public function user_without_rights_can_not_edit_company()
    {
        // act as user without permissions
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // create the company that will be updated
        factory(Company::class)->create();
        $originalCompany = Company::first();

        // create a fake image 300px square, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send patch request to update a company
        $response = $this->patch(route('company.update', ['company' => $originalCompany]), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);


        // the company should be unchanged in the database
        $this->assertDatabaseHas('companies', [
            'name' => $originalCompany->name,
            'website' => $originalCompany->website,
            'email' => $originalCompany->email,
            'logo' => $originalCompany->logo,
        ]);

        // another way to check the company is unchanged
        $this->assertEquals($originalCompany, Company::first());

        // attempt to update should be forbidden
        $response->assertForbidden();
    }

    /**
     * @test
     *
     * @return void
     */
    public function changing_logo_deletes_old_file()
    {
        // act as user with edit permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
        ]);
        $this->actingAs($user);

        // create the company that will be updated
        $company = factory(Company::class)->create();

        // use a fake version of the public drive
        Storage::fake('public');

        // create a fake image and use it as company's logo
        $pathOne = $company->storeLogo(
            UploadedFile::fake()->image('logoOne.png', 300, 300)->size(128)
        );
        $company->save();

        // check that the image has been stored in the filesystem
        Storage::disk('public')->assertExists($pathOne);

        // create a second fake image
        $logoTwo = UploadedFile::fake()->image('logoTwo.png', 600, 300)->size(256);

        // send patch request to update a company, setting the new logo
        $response = $this->patch(route('company.update', ['company' => $company]), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $logoTwo,
        ]);

        $company = Company::first();

        // the new logo should now exist in the filesystem
        Storage::disk('public')->assertExists($company->logo);

        // the old log will no longer exist in the filesystem
        Storage::disk('public')->assertMissing($pathOne);

        // response should be successful with no errors
        $responseEnd = $this->followRedirects($response);
        $responseEnd->assertSuccessful();
        $responseEnd->assertSessionHasNoErrors();
    }

    /**
     * @test
     *
     * @return void
     */
    public function changing_logo_does_not_delete_sample_logo()
    {
        // act as user with edit permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
        ]);
        $this->actingAs($user);

        // use a fake version of the public drive
        Storage::fake('public');

        $sampleLogo   = UploadedFile::fake()->image('logo.png', 600, 300)->size(256);
        $pathOfSample = Storage::disk('public')
            ->putFileAs('logos/samples', $sampleLogo, 'sample-logo.png', 'public');

        // create a company using sample logo
        $company = factory(Company::class)->create([
            'logo' => $pathOfSample,
        ]);

        // check that the sample logo is in the filesystem
        Storage::disk('public')->assertExists($pathOfSample);

        // create a replacement logo image
        $newLogo = UploadedFile::fake()->image('logo.png', 600, 300)->size(256);

        // send patch request to update a company, setting the new logo
        $response = $this->patch(route('company.update', ['company' => $company]), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $newLogo,
        ]);

        $company = Company::first();

        // both the new logo and old sample logo should exist in the filesystem
        Storage::disk('public')->assertExists($company->logo);
        Storage::disk('public')->assertExists($pathOfSample);

        // response should be successful with no errors
        $responseEnd = $this->followRedirects($response);
        $responseEnd->assertSuccessful();
        $responseEnd->assertSessionHasNoErrors();
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_update_company_without_changing_logo()
    {
        // act as user with edit permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
        ]);
        $this->actingAs($user);

        // use a fake version of the public drive
        Storage::fake('public');

        $sampleLogo   = UploadedFile::fake()->image('logo.png', 600, 300)->size(256);
        $pathOfSample = Storage::disk('public')
            ->putFileAs('logos/samples', $sampleLogo, 'sample-logo.png', 'public');

        // create a company using sample logo
        $company = factory(Company::class)->create([
            'logo' => $pathOfSample,
        ]);

        // check that the sample logo is in the filesystem
        Storage::disk('public')->assertExists($pathOfSample);

        // send patch request to update a company, without changing logo
        $response = $this->patch(route('company.update', ['company' => $company]), [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
        ]);

        // database has updated company details, with old logo
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo' => $pathOfSample,
        ]);

        // old logo should still exist in the filesystem
        Storage::disk('public')->assertExists($pathOfSample);

        // response should be successful with no errors
        $responseEnd = $this->followRedirects($response);
        $responseEnd->assertSuccessful();
        $responseEnd->assertSessionHasNoErrors();
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_not_create_company_without_name()
    {
        // act as user with creation permission
        $user = factory(User::class)->create([
            'canCreateCompany' => true,
        ]);
        $this->actingAs($user);

        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(128);
        Storage::fake('public');

        // send post request to create a company without a name
        $response = $this->post(route('company.store'), [
            'name' => '',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
            'logo-file' => $file,
        ]);

        // company was not created
        $this->assertDatabaseMissing('companies', [
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
        ]);

        // produces a validation error for the name
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_not_edit_company_to_have_no_name()
    {
        // act as user with edit permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
        ]);
        $this->actingAs($user);

        // create the company that will be updated
        $company         = factory(Company::class)->create();
        $originalName    = $company->name;
        $originalWebsite = $company->website;
        $originalEmail   = $company->email;

        // send patch request to update the company to have no name
        $response = $this->patch(route('company.update', ['company' => $company]), [
            'name' => '',
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
        ]);

        // the updated company isn't in the database
        $this->assertDatabaseMissing('companies', [
            'website' => 'https://www.example.com',
            'email' => 'contact@example.com',
        ]);

        // the original company is still in the database
        $this->assertDatabaseHas('companies', [
            'name' => $originalName,
            'website' => $originalWebsite,
            'email' => $originalEmail,
        ]);

        // expect validation error on name
        $response->assertSessionHasErrors(['name']);
    }

    /**
     * @test
     *
     * @return void
     */
    public function can_partially_update_company()
    {
        // act as user with edit permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
        ]);
        $this->actingAs($user);

        // create the company that will be updated
        $company         = factory(Company::class)->create();
        $originalWebsite = $company->website;
        $originalEmail   = $company->email;

        // create a fake image 300px square, 128KiB in size
        $file = UploadedFile::fake()->image('logo.png', 300, 300)->size(128);

        // use a fake version of the public drive
        Storage::fake('public');

        // send patch request to update a company
        $response = $this->patch(route('company.update', ['company' => $company]), [
            'name' => 'Test Company',
            'logo-file' => $file,
        ]);

        // the company should have been partially updated
        $this->assertDatabaseHas('companies', [
            'name' => 'Test Company',
            'website' => $originalWebsite,
            'email' => $originalEmail,
        ]);

        // the file should have been uploaded (into the faked drive)
        $company = Company::first();
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
    public function user_with_rights_can_delete_company()
    {
        // act as user with delete permission
        $user = factory(User::class)->create([
            'canDeleteCompany' => true,
        ]);
        $this->actingAs($user);

        // create the company that will be deleted
        $company    = factory(Company::class)->create();
        $originalId = $company->id;

        // check the company exists before attempting to delete
        $this->assertDatabaseHas('companies', [
            'id' => $originalId,
        ]);

        // send delete request
        $response = $this->delete(route('company.destroy', ['company' => $company]));

        // request should be successful with no errors
        $response->assertSessionHasNoErrors();
        $this->followRedirects($response)->assertSuccessful();

        // company should be removed from database
        $this->assertDatabaseMissing('companies', [
            'id' => $originalId,
        ]);
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_without_rights_can_not_delete_company()
    {
        // act as user without delete permission
        $user = factory(User::class)->create([
            'canEditCompany' => true,
            'canDeleteEmployee' => true,
        ]);
        $this->actingAs($user);

        // create the company that will be deleted
        $company    = factory(Company::class)->create();
        $originalId = $company->id;

        // check the company exists before attempting to delete
        $this->assertDatabaseHas('companies', [
            'id' => $originalId,
        ]);

        // send delete request
        $response = $this->delete(route('company.destroy', ['company' => $company]));

        // request should be forbidden
        $response->assertForbidden();

        // company should still be in the database
        $this->assertDatabaseHas('companies', [
            'id' => $originalId,
        ]);
    }
}

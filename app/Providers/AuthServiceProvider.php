<?php

namespace App\Providers;

use App\Company;
use App\Policies\CompanyPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        Company::class => CompanyPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //TODO: get rid of these
        // Gate::define('create-company', function ($user) {
        //     return $user != null && $user->canCreateCompany;
        // });
        // Gate::define('edit-company', function ($user) {
        //     return $user != null && $user->canEditCompany;
        // });
        // Gate::define('delete-company', function ($user) {
        //     return $user != null && $user->canDeleteCompany;
        // });

        // Gate::define('create-employee', function ($user) {
        //     return $user != null && $user->canCreateEmployee;
        // });
        // Gate::define('edit-employee', function ($user) {
        //     return $user != null && $user->canEditEmployee;
        // });
        // Gate::define('delete-employee', function ($user) {
        //     return $user != null && $user->canDeleteEmployee;
        // });
    }
}

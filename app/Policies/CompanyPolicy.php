<?php

namespace App\Policies;

use App\User;
use App\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Authorization for viewing and manipulating companies.
 *
 * @package Company
 */
class CompanyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the company.
     *
     * @return bool
     */
    public function view()
    {
        // any logged in user can view companies
        return true;
    }

    /**
     * Determine whether the user can create companies.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->canCreateCompany;
    }

    /**
     * Determine whether the user can update a company.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $user->canEditCompany;
    }

    /**
     * Determine whether the user can delete a company.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->canDeleteCompany;
    }

    /**
     * Determine whether the user can restore a company.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function restore(User $user)
    {
        return $user->canCreateCompany;
    }

    /**
     * Determine whether the user can permanently delete a company.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->canDeleteCompany;
    }
}

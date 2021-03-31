<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Determines if a given user can perform various actions on Employees.
 *
 * @package Employee
 */
class EmployeePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the employee.
     *
     * @return bool
     */
    public function view()
    {
        // any logged in user can view employees
        return true;
    }

    /**
     * Determine whether the user can create employees.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function create(User $user)
    {
        return $user->canCreateEmployee;
    }

    /**
     * Determine whether the user can update the employee.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function update(User $user)
    {
        return $user->canEditEmployee;
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function delete(User $user)
    {
        return $user->canDeleteEmployee;
    }

    /**
     * Determine whether the user can restore the employee.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function restore(User $user)
    {
        return $user->canCreateEmployee;
    }

    /**
     * Determine whether the user can permanently delete the employee.
     *
     * @param \App\User $user
     *
     * @return bool
     */
    public function forceDelete(User $user)
    {
        return $user->canDeleteEmployee;
    }
}

<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any companies.
     *
     * @param  \App\Models\Employee  $user
     * @return mixed
     */
    public function viewAny(Employee $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the company.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function view(Employee $user, Company $company)
    {
        return true;
    }

    /**
     * Determine whether the user can create companies.
     *
     * @param  \App\Models\Employee  $user
     * @return mixed
     */
    public function create(Employee $user)
    {
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can update the company.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function update(Employee $user, Company $company)
    {
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function delete(Employee $user, Company $company)
    {
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can restore the company.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function restore(Employee $user, Company $company)
    {
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can permanently delete the company.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Company  $company
     * @return mixed
     */
    public function forceDelete(Employee $user, Company $company)
    {
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }
}

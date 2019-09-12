<?php

namespace App\Policies;

use App\Models\Employee;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any employees.
     *
     * @param  \App\Models\Employee  $user
     * @return mixed
     */
    public function viewAny(Employee $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the employee.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function view(Employee $user, Employee $employee)
    {
        return true;
    }

    /**
     * Determine whether the user can create employees.
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
     * Determine whether the user can update the employee.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function update(Employee $user, Employee $employee)
    {
        return self::isMyProfileOrAdmin( $user, $employee);
    }

    /**
     * Determine whether the user can delete the employee.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function delete(Employee $user, Employee $employee)
    {
        return self::isMyProfileOrAdmin( $user, $employee);
    }

    /**
     * Determine whether the user can restore the employee.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function restore(Employee $user, Employee $employee)
    {
        return self::isMyProfileOrAdmin( $user, $employee);
    }

    /**
     * Determine whether the user can permanently delete the employee.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Employee  $employee
     * @return mixed
     */
    public function forceDelete(Employee $user, Employee $employee)
    {
        return self::isMyProfileOrAdmin( $user, $employee);
    }

    //check if  user is admin, or if user is the employee
    private function isMyProfileOrAdmin(Employee $user, Employee $employee){
        if( $user->id === $employee->id){
            return true;
        }
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }
}

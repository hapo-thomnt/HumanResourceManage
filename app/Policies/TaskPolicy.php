<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;
    
    /**
     * Determine whether the user can view any tasks.
     *
     * @param  \App\Models\Employee  $user
     * @return mixed
     */
    public function viewAny(Employee $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function view(Employee $user, Task $task)
    {
        return true;
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\Models\Employee  $user
     * @return mixed
     */
    public function create(Employee $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(Employee $user, Task $task)
    {
        return self::isMyTaskOrAdmin( $user, $task);
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function delete(Employee $user, Task $task)
    {
        return self::isMyTaskOrAdmin( $user, $task);
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function restore(Employee $user, Task $task)
    {
        return self::isMyTaskOrAdmin( $user, $task);
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param  \App\Models\Employee  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function forceDelete(Employee $user, Task $task)
    {
        return self::isMyTaskOrAdmin( $user, $task);
    }

    //check if  user is admin, or if user own the task
    private function isMyTaskOrAdmin(Employee $user, Task $task){
        if( $user->id === $task->employee_id){
            return true;
        }
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }
}

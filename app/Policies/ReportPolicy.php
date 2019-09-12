<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any reports.
     *
     * @param \App\Models\Employee $user
     * @return mixed
     */
    public function viewAny(Employee $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the report.
     *
     * @param \App\Models\Employee $user
     * @param \App\Report $report
     * @return mixed
     */
    public function view(Employee $user, Report $report)
    {
        return true;
    }

    /**
     * Determine whether the user can create reports.
     *
     * @param \App\Models\Employee $user
     * @return mixed
     */
    public function create(Employee $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param \App\Models\Employee $user
     * @param \App\Report $report
     * @return mixed
     */
    public function update(Employee $user, Report $report)
    {
        return self::isMyReportOrAdmin( $user, $report);
    }

    /**
     * Determine whether the user can delete the report.
     *
     * @param \App\Models\Employee $user
     * @param \App\Report $report
     * @return mixed
     */
    public function delete(Employee $user, Report $report)
    {
        return self::isMyReportOrAdmin( $user, $report);
    }

    /**
     * Determine whether the user can restore the report.
     *
     * @param \App\Models\Employee $user
     * @param \App\Report $report
     * @return mixed
     */
    public function restore(Employee $user, Report $report)
    {
        return self::isMyReportOrAdmin( $user, $report);
    }

    /**
     * Determine whether the user can permanently delete the report.
     *
     * @param \App\Models\Employee $user
     * @param \App\Report $report
     * @return mixed
     */
    public function forceDelete(Employee $user, Report $report)
    {
        return self::isMyReportOrAdmin( $user, $report);
    }

    //check if  user is admin, or if user own the report
    private function isMyReportOrAdmin(Employee $user, Report $report){
        if( $user->id === $report->employee_id){
            return true;
        }
        if ($user->role === config('app.employee_role.admin')) {
            return true;
        }
        return false;
    }
}

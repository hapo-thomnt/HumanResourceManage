<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Project;
use App\Models\Report;
use App\Models\Task;
use App\Policies\CompanyPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\ReportPolicy;
use App\Policies\TaskPolicy;
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
        Report::class => ReportPolicy::class,
        Employee::class => EmployeePolicy::class,
        Task::class => TaskPolicy::class,
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

        Gate::define('project-viewAny', function ($user) {
            if ($user instanceof Employee || $user instanceof Customer) {
                return true;
            }
            return false;
        });
        Gate::define('project-create', function ($user) {
            //only an employee admin can create project

            if ($user instanceof Employee) {

                if ($user->role === config('app.employee_role.admin')) {
                    return true;
                }
                return false;
            }
            return false;
        });

        Gate::define('project-update', function ($user) {
            //only an employee admin can create project

            if ($user instanceof Employee) {
                if ($user->role === config('app.employee_role.admin')) {
                    return true;
                }
                return false;
            }

            return false;
        });

        Gate::define('project-delete', function ($user) {
            //only an employee admin can delete project
            if ($user instanceof Employee) {

                if ($user->role === config('app.employee_role.admin')) {
                    return true;
                }
                return false;
            }
            return false;
        });

        Gate::define('project-edit-assign', function ($user, $project) {
            //only an employee admin can create project
            if (!$user instanceof Employee) {
                return false;
            }
            //admin or project leader can assign member for project
            if ($user->role === config('app.employee_role.admin')) {
                return true;
            }
            foreach ($project->employees as $employee) {
                if($employee->id === $user->id && $employee->role ===config('app.project_role.leader')){
                    return true;
                }
            }
            return false;
        });
        Gate::define('project-view-assign', function ($user) {
            //every employee can see assign information of a project
            if ($user instanceof Employee) {
                return true;
            }
            return false;
        });
        Gate::define('customer-create', function ($user) {
            //only an employee admin can create customer

            if ($user instanceof Employee) {

                if ($user->role === config('app.employee_role.admin')) {
                    return true;
                }
                return false;
            }
            return false;
        });

        Gate::define('customer-update', function ($user,$customer) {
            // employee admin can update customer

            if ($user instanceof Employee) {
                if ($user->role === config('app.employee_role.admin')) {
                    return true;
                }
                return false;
            }
            if ($user instanceof Customer) {
                if ($user->id === $customer->id) {
                    return true;
                }
                return false;
            }

            return false;
        });

        Gate::define('customer-delete', function ($user) {
            //only an employee admin can delete customer
            if ($user instanceof Employee) {

                if ($user->role === config('app.employee_role.admin')) {
                    return true;
                }
                return false;
            }
            return false;
        });

        Gate::define('customer-viewAny', function ($user) {
            if ($user instanceof Employee || $user instanceof Customer) {
                return true;
            }
            return false;
        });

    }
}

<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-profile', function ($user) {
            return true;
        });
        Gate::define('edit-project', function ($user, $project) {
            //when user is super admin, he can do any thing
            if ($user->role === config('app.employee_role.admin')) {
                return true;
            }
            //if user is leader of project
            foreach ($project->employees as $employee) {
                if ($user->id === $employee->id) {
                    return true;
                }
            }
            return false;
        });
        Gate::define('create-project', function ($user) {
            if ($user->role === config('app.employee_role.admin')) {
                return true;
            }
            return false;
        });
        Gate::define('delete-project', function ($user) {
            if ($user->role === config('app.employee_role.admin')) {
                return true;
            }
            return false;
        });
        Gate::define('update-assign-project', function ($user, $project) {
            //when user is super admin, he can do any thing
            if ($user->role === config('app.employee_role.admin')) {
                return true;
            }
            //if user is leader of project
            foreach ($project->employees as $employee) {
                if ($user->id === $employee->id) {
                    return true;
                }
            }
            return false;
        });
    }
}

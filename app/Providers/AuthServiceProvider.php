<?php

namespace App\Providers;

use App\Models\SuperAdmin\School;
use App\Models\User;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        auth()->shouldUse('schooladmin');
        $this->registerPolicies();

        Gate::define('can_add_course', function() {
            return auth('schooladmin')->user()->editCoursePermission->add == 1 ? true : false;
        });

        Gate::define('can_edit_course', function() {
            return auth('schooladmin')->user()->editCoursePermission->edit == 1 ? true : false;
        });

        Gate::define('can_delete_course', function() {
            return auth('schooladmin')->user()->editCoursePermission->delete == 1 ? true : false;
        });
    }
}
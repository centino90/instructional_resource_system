<?php

namespace App\Providers;

use App\Models\Role;
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
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('superadmin-view', function (User $user) {
        //     return $user->role_id == Role::SUPER_ADMIN;
        // });
        // Gate::define('admin-view', function (User $user) {
        //     return $user->role_id == Role::ADMIN;
        // });
        // Gate::define('secretary-view', function (User $user) {
        //     return $user->role_id == Role::SECRETARY;
        // });
        // Gate::define('teacher-view', function (User $user) {
        //     return $user->role_id == Role::TEACHER;
        // });
    }
}
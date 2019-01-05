<?php

namespace App\Providers;

use Laravel\Passport\Passport;
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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        //Gates defination for user role.
        Gate::define('isSuperAdmin', function($user){
            return $user->type === 'superadmin';
        });
        Gate::define('isAdmin', function($user){
            return $user->type === 'admin';
        });
        Gate::define('isUser', function($user){
            return $user->type === 'user';
        });
    }
}

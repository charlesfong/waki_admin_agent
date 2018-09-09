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

        $this->registerPostPolicies();
    }

    public function registerPostPolicies()
    {
        //-- MPC --//
        Gate::define('add-mpc', function ($user) {
            return $user->hasAccess(['add-mpc']);
        });
        Gate::define('browse-mpc', function ($user) {
            return $user->hasAccess(['browse-mpc']);
        });
        Gate::define('find-mpc', function ($user) {
            return $user->hasAccess(['find-mpc']);
        });
        Gate::define('edit-mpc', function ($user) {
            return $user->hasAccess(['edit-mpc']);
        });
        Gate::define('delete-mpc', function ($user) {
            return $user->hasAccess(['delete-mpc']);
        });
        Gate::define('all-branch-mpc', function ($user) {
            return $user->hasAccess(['all-branch-mpc']);
        });
        Gate::define('all-country-mpc', function ($user) {
            return $user->hasAccess(['all-country-mpc']);
        });

        //-- DATA UNDANGAN --//
        Gate::define('add-data-undangan', function ($user) {
            return $user->hasAccess(['add-data-undangan']);
        });
        Gate::define('browse-data-undangan', function ($user) {
            return $user->hasAccess(['browse-data-undangan']);
        });
        Gate::define('find-data-undangan', function ($user) {
            return $user->hasAccess(['find-data-undangan']);
        });
        Gate::define('edit-data-undangan', function ($user) {
            return $user->hasAccess(['edit-data-undangan']);
        });
        Gate::define('delete-data-undangan', function ($user) {
            return $user->hasAccess(['delete-data-undangan']);
        });
        Gate::define('all-branch-data-undangan', function ($user) {
            return $user->hasAccess(['all-branch-data-undangan']);
        });
        Gate::define('all-country-data-undangan', function ($user) {
            return $user->hasAccess(['all-country-data-undangan']);
        });

        //-- DATA OUTSITE --//
        Gate::define('add-data-outsite', function ($user) {
            return $user->hasAccess(['add-data-outsite']);
        });
        Gate::define('browse-data-outsite', function ($user) {
            return $user->hasAccess(['browse-data-outsite']);
        });
        Gate::define('find-data-outsite', function ($user) {
            return $user->hasAccess(['find-data-outsite']);
        });
        Gate::define('edit-data-outsite', function ($user) {
            return $user->hasAccess(['edit-data-outsite']);
        });
        Gate::define('delete-data-outsite', function ($user) {
            return $user->hasAccess(['delete-data-outsite']);
        });
        Gate::define('all-branch-data-outsite', function ($user) {
            return $user->hasAccess(['all-branch-data-outsite']);
        });
        Gate::define('all-country-data-outsite', function ($user) {
            return $user->hasAccess(['all-country-data-outsite']);
        });

        //-- DATA THERAPY --//
        Gate::define('add-data-therapy', function ($user) {
            return $user->hasAccess(['add-data-therapy']);
        });
        Gate::define('browse-data-therapy', function ($user) {
            return $user->hasAccess(['browse-data-therapy']);
        });
        Gate::define('find-data-therapy', function ($user) {
            return $user->hasAccess(['find-data-therapy']);
        });
        Gate::define('edit-data-therapy', function ($user) {
            return $user->hasAccess(['edit-data-therapy']);
        });
        Gate::define('delete-data-therapy', function ($user) {
            return $user->hasAccess(['delete-data-therapy']);
        });
        Gate::define('all-branch-data-therapy', function ($user) {
            return $user->hasAccess(['all-branch-data-therapy']);
        });
        Gate::define('all-country-data-therapy', function ($user) {
            return $user->hasAccess(['all-country-data-therapy']);
        });

        //-- TYPE CUST --//
        Gate::define('add-type-cust', function ($user) {
            return $user->hasAccess(['add-type-cust']);
        });
        Gate::define('browse-type-cust', function ($user) {
            return $user->hasAccess(['browse-type-cust']);
        });
        Gate::define('edit-type-cust', function ($user) {
            return $user->hasAccess(['edit-type-cust']);
        });
        Gate::define('delete-type-cust', function ($user) {
            return $user->hasAccess(['delete-type-cust']);
        });

        //-- CSO --//
        Gate::define('add-cso', function ($user) {
            return $user->hasAccess(['add-cso']);
        });
        Gate::define('browse-cso', function ($user) {
            return $user->hasAccess(['browse-cso']);
        });
        Gate::define('edit-cso', function ($user) {
            return $user->hasAccess(['edit-cso']);
        });
        Gate::define('delete-cso', function ($user) {
            return $user->hasAccess(['delete-cso']);
        });
        Gate::define('all-branch-cso', function ($user) {
            return $user->hasAccess(['all-branch-cso']);
        });
        Gate::define('all-country-cso', function ($user) {
            return $user->hasAccess(['all-country-cso']);
        });

        //-- BRANCH --//
        Gate::define('add-branch', function ($user) {
            return $user->hasAccess(['add-branch']);
        });
        Gate::define('browse-branch', function ($user) {
            return $user->hasAccess(['browse-branch']);
        });
        Gate::define('edit-branch', function ($user) {
            return $user->hasAccess(['edit-branch']);
        });
        Gate::define('delete-branch', function ($user) {
            return $user->hasAccess(['delete-branch']);
        });
        Gate::define('all-country-branch', function ($user) {
            return $user->hasAccess(['all-country-branch']);
        });

        //-- USER --//
        Gate::define('add-user', function ($user) {
            return $user->hasAccess(['add-user']);
        });
        Gate::define('browse-user', function ($user) {
            return $user->hasAccess(['browse-user']);
        });
        Gate::define('edit-user', function ($user) {
            return $user->hasAccess(['edit-user']);
        });
        Gate::define('delete-user', function ($user) {
            return $user->hasAccess(['delete-user']);
        });
        Gate::define('all-branch-user', function ($user) {
            return $user->hasAccess(['all-branch-user']);
        });
        Gate::define('all-country-user', function ($user) {
            return $user->hasAccess(['all-country-user']);
        });
    }
}

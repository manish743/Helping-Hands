<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\EmployeeDetail;
use App\Models\Job;
use App\Policies\ClientPolicy;
use App\Policies\ClientUserPolicy;
use App\Policies\JobPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        EmployeeDetail::class=>ClientPolicy::class,
        Job::class=>JobPolicy::class,
        User::class=>ClientUserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

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

        // === 여기에 'admin' 권한 Gate를 정의합니다. ===
        Gate::define('admin', function ($user) {
            // 사용자의 level이 10 이상일 때만 'admin' 권한을 부여합니다.
            return $user->level >= 10;
        });

        Gate::define('partner', function ($user) {
            return $user->level >= 3 && $user->level <= 9;
        });
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Gate;    

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // .env의 GRAPHQL_URI 값을 Config에 설정 (선택 사항, 직접 사용하는 대신)
        Config::set('app.graphql_uri', env('GRAPHQL_URI', 'http://127.0.0.1:4000/graphql'));

        // 모든 뷰에 GraphQL URI를 공유
        view()->share('graphqlUri', Config::get('app.graphql_uri'));

        AbstractPaginator::defaultView('pagination::bootstrap-4'); 

        // ✅ 'admin' 권한 정의
        Gate::define('admin', function ($user) {
            // 사용자 모델에 is_admin 속성이 있다고 가정
            return $user->is_admin ?? false;
        });
    }
}
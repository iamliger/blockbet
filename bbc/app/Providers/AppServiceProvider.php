<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Pagination\AbstractPaginator;

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
    }
}
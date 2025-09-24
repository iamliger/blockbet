<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 사용자가 로그인했는지 확인
        if(!Auth::check()){
            return redirect('/login');// 로그인하지 않았다면 로그인 페이지로 리디렉션
        }

        // 로그인한 사용자의 level이 10 미만이면 접근 거부
        // admin 계정의 level을 10으로 설정했음을 가정
        if($request->user()->level < 10){
            return redirect('/')->with('alert-error', '관리자 권한이 없습니다.');
        }

        return $next($request);
    }
}

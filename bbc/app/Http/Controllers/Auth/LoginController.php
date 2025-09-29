<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/'; // <-- 이 줄은 주석 처리하거나 제거합니다.

    /**
     * Get the post login redirect path based on user level.
     *
     * @return string
     */
    protected function redirectTo()
    {
        $user = auth()->user(); // 현재 로그인한 사용자 객체 가져오기

        if ($user->level >= 10) {
            // 레벨 10 (슈퍼관리자)는 /admin 대시보드로 이동
            return '/admin';
        } elseif ($user->level >= 3 && $user->level <= 9) {
            // 레벨 3~9 (파트너)는 /partner/dashboard로 이동
            return '/partner/dashboard';
        } elseif ($user->level == 2) {
            // 레벨 1~2 (사용자/보조사용자)는 일반 홈페이지로 이동 (또는 /mypage 등)
            return '/partner'; // 또는 '/'
        } else {
            // 레벨 0 (승인대기/이용불가)인 경우 로그인 후 강제 로그아웃 또는 특정 페이지로 리디렉션
            // 현재 요구사항 "레벨0은 절대 이용못하고 승인을 기다려야 한다."에 따라 로그인 자체를 막는 것이 좋지만,
            // redirectTo()는 이미 로그인 성공 후 호출되므로, 여기서 로그아웃 처리
            Auth::logout();
            return '/login'; // 로그인 페이지로 돌려보내고, 로그인 페이지에 메시지 표시 로직 필요
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
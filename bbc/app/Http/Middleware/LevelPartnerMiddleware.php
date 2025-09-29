<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class LevelPartnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int       $minLevel 최소 레벨
     * @param  int|null  $maxLevel 최대 레벨 (null이면 minLevel과 동일)
     * @return mixed
     */
    public function handle($request, Closure $next, $minLevel, $maxLevel = null)
    {
        if (!Auth::check()) {
            return redirect('/login')->with('error', '로그인이 필요합니다.');
        }

        $user = $request->user();
        $maxLevel = $maxLevel ?? $minLevel; // maxLevel이 없으면 minLevel과 동일

        // 사용자의 레벨이 허용된 범위 안에 있는지 확인
        if ($user->level < $minLevel || $user->level > $maxLevel) {
            // 관리자도 특정 파트너 레벨 페이지에 접근할 수 없도록 엄격하게 검증
            // 단, 슈퍼관리자(level 10)는 모든 파트너 페이지를 관리 목적으로 접근할 수 있도록 예외 처리
            if ($user->level >= 10) { // 슈퍼관리자는 모든 파트너 페이지 접근 가능하도록
                return $next($request);
            }

            return redirect('/')->with('alert-error', "레벨 {$minLevel}~{$maxLevel} 권한이 없습니다.");
        }

        return $next($request);
    }
}
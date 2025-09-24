<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User; // User 모델 추가
use App\Transfer; // Transfer 모델 추가
use App\Balance; // Balance 모델 추가
use App\Point; // Point 모델 추가

class AdminController extends Controller
{
    /**
     * 관리자 대시보드 메인 페이지
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalUsers = User::count();
        $pendingDeposits = Balance::where('type', 1)->where('status', 'R')->count();
        $pendingWithdrawals = Balance::where('type', -1)->where('status', 'R')->count();
        $totalTransfers = Transfer::count();

        return view('admin.dashboard', compact('totalUsers', 'pendingDeposits', 'pendingWithdrawals', 'totalTransfers'));
    }

    /**
     * 사용자 목록 관리
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function users(Request $request)
    {
        $users = User::paginate(30); // 모든 사용자 목록 페이지네이션
        return view('admin.users', compact('users'));
    }

    /**
     * 토큰 전송 내역 관리 (transfers 테이블)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transfers(Request $request)
    {
        $transfers = Transfer::orderby('id', 'desc')->paginate(30); // 모든 전송 내역
        return view('admin.transfers', compact('transfers'));
    }

    /**
     * 입출금 내역 관리 (balances 테이블)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function balances(Request $request)
    {
        $balances = Balance::orderby('id', 'desc')->paginate(30); // 모든 입출금 내역
        return view('admin.balances', compact('balances'));
    }

    /**
     * 포인트 내역 관리 (points 테이블)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function points(Request $request)
    {
        $points = Point::orderby('id', 'desc')->paginate(30); // 모든 포인트 내역
        return view('admin.points', compact('points'));
    }

}

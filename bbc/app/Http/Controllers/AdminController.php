<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transfer;
use App\Balance;
use App\Point;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * 관리자 대시보드 메인 페이지 (GET /admin)
     * AdminController의 index() 메서드는 대시보드 전용으로 사용
     * @return \Illuminate\Http\Response
     */
    public function dashboard() // 이 메서드는 'admin.dashboard' 라우트에 매핑
    {
        $totalUsers = User::count();
        $pendingDeposits = Balance::where('type', 1)->where('status', 'R')->count();
        $pendingWithdrawals = Balance::where('type', -1)->where('status', 'R')->count();
        $totalTransfers = Transfer::count();
        $totalPoints = Point::sum('amount'); // 총 포인트 집계 (예시)

        return view('admin.dashboard', compact('totalUsers', 'pendingDeposits', 'pendingWithdrawals', 'totalTransfers', 'totalPoints'));
    }

    /**
     * 사용자 목록 관리 (GET /admin/users)
     * 이 메서드가 Route::resource의 index 액션에 매핑됩니다.
     * @return \Illuminate\Http\Response
     */
    public function index() // 이전: users()
    {
        $users = User::paginate(30);
        return view('admin.users.index', compact('users'));
    }

    /**
     * 새 사용자 생성 폼 표시 (GET /admin/users/create)
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $recommenders = User::where('level', '>=', 1)->get(['id', 'name']);
        return view('admin.users.create', compact('recommenders'));
    }

    /**
     * 새 사용자 저장 처리 (POST /admin/users)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string','min:3', 'max:255','unique:users'],
            'email' => ['required', 'string', 'email','min:8' ,'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'level' => ['required', 'integer', 'min:0', 'max:10'],
            'point' => ['required', 'numeric', 'min:0'],
            'recommander' => ['nullable','string','min:3','max:255','exists:users,name'],
            'country' => ['nullable', 'string', 'max:64'],
            'mobile' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/','max:64'],
            'address' => ['nullable', 'string', 'max:255'],
            'otex' => ['nullable', 'string', 'max:255'],
        ]);
        
        $recommanderUser = null;
        $store = '';
        $super = null;
        $hq = null;
        $dist = null;

        if ($request->filled('recommander')) {
            $recommanderUser = User::where('name', $request->recommander)->first();
            if ($recommanderUser) {
                $store = $recommanderUser->name;
                $super = $recommanderUser->super;
                if ($recommanderUser->level >= 9) {
                    $store = '';
                }

                if($recommanderUser->type == 3){
                    $hq = $recommanderUser->name;
                }else if($recommanderUser->type == 2){            
                    $hq = $recommanderUser->hq;
                    $dist = $recommanderUser->name;
                }else if($recommanderUser->type == 1){
                    $hq = $recommanderUser->hq;
                    $dist = $recommanderUser->dist;
                }
            }
        }

        User::create([
            'name' => strtolower($request->name),
            'email' => strtolower($request->email),
            'password' => Hash::make($request->password),
            'level' => $request->level,
            'point' => $request->point,
            'recommander' => $store,
            'store' => $store,
            'super' => $super,
            'hq' => $hq,
            'dist' => $dist,
            'country' => $request->country ?? 'Unknown',
            'mobile' => $request->mobile ?? 'N/A',
            'address' => $request->address ?? '',
            'otex' => $request->otex ?? null,
            'api_token' => Str::random(60),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', '새로운 사용자가 등록되었습니다.');
    }

    /**
     * 특정 사용자 상세 정보 표시 (GET /admin/users/{user})
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * 사용자 수정 폼 표시 (GET /admin/users/{user}/edit)
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $recommenders = User::where('level', '>=', 1)->get(['id', 'name']);
        return view('admin.users.edit', compact('user', 'recommenders'));
    }

    /**
     * 사용자 정보 업데이트 처리 (PUT/PATCH /admin/users/{user})
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'level' => 'required|integer|min:0|max:10',
            'point' => 'required|numeric|min:0',
            'address' => 'nullable|string|max:255',
            'recommander' => ['nullable','string','min:3','max:255','exists:users,name'],
            'store' => 'nullable|string|max:255',
            'odds' => 'required|numeric|min:0',
            'otex' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:64',
            'mobile' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/','max:64'],
            'super' => 'nullable|string|max:255',
            'hq' => 'nullable|string|max:255',
            'dist' => 'nullable|string|max:255',
        ]);

        $user->update($request->only([
            'name', 'email', 'level', 'point', 'address', 'recommander', 'store', 'odds', 'otex', 'country', 'mobile', 'super', 'hq', 'dist'
        ]));

        return redirect()->route('admin.users.show', $user->id)->with('success', '사용자 정보가 업데이트되었습니다.');
    }

    /**
     * 사용자 삭제 처리 (DELETE /admin/users/{user})
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', '사용자 계정이 삭제되었습니다.');
    }

    /**
     * 토큰 전송 내역 관리 (GET /admin/transfers)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transfers(Request $request)
    {
        $transfers = Transfer::orderby('id', 'desc')->paginate(30);
        return view('admin.transfers', compact('transfers'));
    }

    /**
     * 입출금 내역 관리 (GET /admin/balances)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function balances(Request $request)
    {
        $balances = Balance::orderby('id', 'desc')->paginate(30);
        return view('admin.balances', compact('balances'));
    }

    /**
     * 포인트 내역 관리 (GET /admin/points)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function points(Request $request)
    {
        $points = Point::orderby('id', 'desc')->paginate(30);
        return view('admin.points', compact('points'));
    }
}
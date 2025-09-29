<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Transfer;
use App\Balance;
use App\Point;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
use App\TotalAssetsHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection; // Collection 클래스 추가



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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query();
        $searchTerm = null; // <-- 이 줄을 추가하여 변수를 미리 초기화합니다.
        $recommanderName = null;

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where('name', 'like', '%' . $searchTerm . '%')
                ->orWhere('email', 'like', '%' . $searchTerm . '%');
        }

        if ($request->filled('search_recommander')) {
            $recommanderName = $request->input('search_recommander');
            $query->where(function ($q) use ($recommanderName) {
                $q->where('recommander', $recommanderName)
                    ->orWhere('store', $recommanderName);
            });
            // 뷰에 검색어를 전달하여 필터가 적용되었음을 표시할 수 있습니다.
            // $searchTerm = $recommanderName . ' 하위 멤버'; // 또는 다른 표시 방식
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users', 'searchTerm', 'recommanderName'));
    }

    /**
     * 새 사용자 생성 폼 표시 (GET /admin/users/create)
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // === 쿼리에 'level' 필드를 추가합니다. ===
        $recommenders = User::where('level', '>=', 1)->get(['id', 'name', 'level']); // <-- 'level' 추가

        $generatedWallet = $this->generateWalletAddress();
        $defaultAddress = $generatedWallet['address'] ?? '';
        $defaultPrivateKey = $generatedWallet['privateKey'] ?? '';

        return view('admin.users.create', compact('recommenders', 'defaultAddress', 'defaultPrivateKey'));
    }

    /**
     * 새 사용자 저장 처리 (POST /admin/users)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'min:8', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'level' => ['required', 'integer', 'min:0', 'max:10'],
            'point' => ['required', 'numeric', 'min:0'],
            'recommander' => ['nullable', 'string', 'min:3', 'max:255', 'exists:users,name'],
            'country' => ['nullable', 'string', 'max:64'],
            'mobile' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:64'],
            'address' => ['nullable', 'string', 'max:255'],
            'private_key' => ['required', 'string', 'max:255'],
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

                // if ($recommanderUser->type == 3) {
                //     $hq = $recommanderUser->name;
                // } else if ($recommanderUser->type == 2) {
                //     $hq = $recommanderUser->hq;
                //     $dist = $recommanderUser->name;
                // } else if ($recommanderUser->type == 1) {
                //     $hq = $recommanderUser->hq;
                //     $dist = $recommanderUser->dist;
                // }
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
            'privateKey' => $request->private_key,
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
            'recommander' => ['nullable', 'string', 'min:3', 'max:255', 'exists:users,name'],
            'store' => 'nullable|string|max:255',
            'odds' => 'required|numeric|min:0',
            'otex' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:64',
            'mobile' => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:64'],
            'super' => 'nullable|string|max:255',
            'hq' => 'nullable|string|max:255',
            'dist' => 'nullable|string|max:255',
        ]);

        $user->update($request->only([
            'name',
            'email',
            'level',
            'point',
            'address',
            'recommander',
            'store',
            'odds',
            'otex',
            'country',
            'mobile',
            'super',
            'hq',
            'dist'
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
     * 게임포인트 설정 페이지 (총자산 설정) 표시
     * GET /admin/settings/game-points
     * @return \Illuminate\Http\Response
     */
    public function showGamePointsSettings()
    {
        $totalAssets = Setting::get('total_assets', 0.00); // 총자산 설정 값을 가져오거나 기본값 0
        return view('admin.settings.game-points', compact('totalAssets'));
    }

    /**
     * 게임포인트 설정 (총자산) 업데이트
     * PUT /admin/settings/game-points
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateGamePointsSettings(Request $request)
    {
        $request->validate([
            'total_assets' => ['required', 'numeric', 'min:0'],
        ], [
            'total_assets.required' => '총자산은 필수로 입력해야 합니다.',
            'total_assets.numeric' => '총자산은 숫자로 입력해야 합니다.',
            'total_assets.min' => '총자산은 0 이상이어야 합니다.',
        ]);

        $cleanAmount = $this->cleanAndRoundAmount($request->total_assets); // 헬퍼 함수 사용
        Setting::set('total_assets', $cleanAmount);
        return redirect()->route('admin.settings.game-points.show')->with('success', '총자산 설정이 성공적으로 업데이트되었습니다.');
    }

    /**
     * 슈퍼관리자 포인트 지급 폼 표시
     * GET /admin/points/distribute
     * @return \Illuminate\Http\Response
     */
    public function showPointDistributeForm()
    {
        $users = User::orderBy('name')->get(['id', 'name']); // 모든 사용자 목록
        return view('admin.points.distribute', compact('users'));
    }

    /**
     * 슈퍼관리자 포인트 지급 처리
     * POST /admin/points/distribute
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function distributePoints(Request $request)
    {
        $request->validate([
            'target_user_id' => ['required', 'array', 'min:1'],
            'target_user_id.*' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ], [
            'target_user_id.required' => '지급 대상 회원을 선택해야 합니다.',
            'target_user_id.array' => '지급 대상은 배열 형태여야 합니다.',
            'target_user_id.min' => '지급 대상 회원을 최소 한 명 이상 선택해야 합니다.',
            'target_user_id.*.required' => '선택된 회원 ID는 필수입니다.',
            'target_user_id.*.exists' => '선택된 회원 ID가 존재하지 않습니다.',
            'amount.required' => '지급 금액은 필수로 입력해야 합니다.',
            'amount.numeric' => '지급 금액은 숫자로 입력해야 합니다.',
            'amount.min' => '지급 금액은 0.01 이상이어야 합니다.',
        ]);

        $amount = $this->cleanAndRoundAmount($request->amount);
        $adminUser = Auth::user();
        $targetUserIds = $request->target_user_id;
        $targetUsers = User::whereIn('id', $targetUserIds)->get();

        if ($targetUsers->isEmpty()) {
            return redirect()->back()->with('error', '지급 대상 회원을 찾을 수 없습니다.');
        }

        DB::transaction(function () use ($targetUsers, $amount, $adminUser) {
            $currentTotalAssets = (float) Setting::get('total_assets', 0.00);

            // 총자산 부족 여부 확인
            if ($currentTotalAssets < ($amount * $targetUsers->count())) { // 총 지급액이 총자산보다 많은지
                throw new \Exception("자본금 설정보다 많은 금액을 지출할 수 없습니다.");
            }

            foreach ($targetUsers as $targetUser) {
                // 1. 대상 사용자 포인트 증가
                $targetUser->increment('point', $amount);

                // 2. points 테이블에 지급 내역 기록
                Point::create([
                    'fromName' => $adminUser->name,
                    'toName' => $targetUser->name,
                    'bid' => 0,
                    'type' => 'admin_manual_deposit',
                    'game' => 'system',
                    'amount' => $amount,
                    'odds' => 0,
                    'result_odds' => 0,
                    'previous' => $targetUser->point - $amount,
                    'request' => $amount,
                    'result' => $targetUser->point,
                ]);
            }

            // 3. 총자산 차감 및 기록
            $newTotalAssets = $currentTotalAssets - ($amount * $targetUsers->count());
            Setting::set('total_assets', $newTotalAssets); // 총자산 업데이트

            TotalAssetsHistory::create([
                'type' => 'point_distribute',
                'amount' => - ($amount * $targetUsers->count()), // 차감은 음수
                'previous_total_assets' => $currentTotalAssets,
                'new_total_assets' => $newTotalAssets,
                'description' => $adminUser->name . ' 이(가) ' . $targetUsers->count() . ' 명에게 총 ' . number_format($amount * $targetUsers->count(), 2) . ' 포인트 지급',
                'user_id' => $adminUser->id,
            ]);
        });

        return redirect()->route('admin.points.distribute.form')->with('success', count($targetUserIds) . ' 명의 사용자에게 ' . number_format($amount, 2) . ' 포인트를 성공적으로 지급했습니다.');
    }

    /**
     * 파트너 하위 멤버 포인트 지급 폼 표시
     * GET /admin/partners/send-points
     * @return \Illuminate\Http\Response
     */
    public function showPartnerPointSendForm()
    {
        $partnerUser = Auth::user();

        // 레벨 3~9 파트너만 이 기능을 사용할 수 있도록 검증 (슈퍼관리자도 테스트 목적상 접근 허용)
        // 만약 level 10 슈퍼관리자도 이 페이지를 테스트해야 한다면, 조건을 조정
        if ($partnerUser->level < 3 || ($partnerUser->level > 9 && $partnerUser->level !== 10)) { // level 10은 허용
            return redirect()->route('admin.dashboard')->with('error', '이 기능은 레벨 3~9 파트너만 사용할 수 있습니다.');
        }

        // 자신의 하위 멤버만 조회 (recommander 또는 store가 자신인 사용자)
        $members = User::where('recommander', $partnerUser->name)
            ->orWhere('store', $partnerUser->name)
            ->where('id', '!=', $partnerUser->id) // 자신 제외
            ->orderBy('name')
            ->get(['id', 'name', 'level', 'point']);

        return view('admin.partners.send-points', compact('members'));
    }

    /**
     * 파트너 하위 멤버 포인트 지급 처리
     * POST /admin/partners/send-points
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendPartnerPointsToMember(Request $request)
    {
        $request->validate([
            'target_member_id' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        $partnerUser = Auth::user();
        $targetMember = User::find($request->target_member_id);
        $amount = $this->cleanAndRoundAmount($request->amount);

        // 레벨 9~3 파트너만 이 기능을 사용할 수 있도록 최종 검증
        if ($partnerUser->level < 3 || $partnerUser->level > 9) {
            return redirect()->back()->with('error', '당신은 하위 멤버에게 포인트를 지급할 권한이 없습니다 (레벨 3~9 파트너만 가능).');
        }

        if ($targetMember->level !== ($partnerUser->level - 1)) {
            return redirect()->back()->with('error', '지급 대상 멤버는 당신의 바로 아래 하위 레벨이어야 합니다.');
        }

        // 대상 멤버가 로그인한 사용자의 하위 멤버인지 철저히 검증
        if ($targetMember->recommander !== $partnerUser->name && $targetMember->store !== $partnerUser->name) {
            return redirect()->back()->with('error', '지급 대상은 당신의 하위 멤버여야 합니다.');
        }

        // 파트너가 지급할 충분한 포인트를 가지고 있는지 확인
        if ($partnerUser->point < $amount) {
            return redirect()->back()->with('error', '보유 포인트가 부족합니다.');
        }

        // 파트너가 지급할 충분한 포인트를 가지고 있는지 확인
        if ($partnerUser->point < $amount) {
            return redirect()->back()->with('error', '보유 포인트가 부족합니다.');
        }

        DB::transaction(function () use ($partnerUser, $targetMember, $amount) {
            // 1. 파트너(상위) 포인트 차감
            $partnerUser->decrement('point', $amount);

            // 2. 하위 멤버 포인트 증가
            $targetMember->increment('point', $amount);

            // 3. points 테이블에 지급 내역 기록
            Point::create([
                'fromName' => $partnerUser->name,
                'toName' => $targetMember->name,
                'bid' => 0,
                'type' => 'partner_transfer',
                'game' => 'system',
                'amount' => $amount,
                'odds' => 0,
                'result_odds' => 0,
                'previous' => $partnerUser->point + $amount,
                'request' => -$amount,
                'result' => $partnerUser->point,
            ]);
        });

        return redirect()->route('admin.partners.send-points.form')->with('success', $targetMember->name . ' 회원에게 ' . number_format($amount, 2) . ' 포인트를 성공적으로 지급했습니다.');
    }

    /**
     * 출금 요청 승인 페이지 표시
     * GET /admin/balances/approve-withdrawals
     * @return \Illuminate\Http\Response
     */
    public function showWithdrawalApprovals()
    {
        $currentUser = Auth::user();

        // 'R' (Requested) 상태의 출금 요청만 가져옴
        $withdrawalRequests = Balance::where('type', -1)
            ->where('status', 'R')
            ->orderBy('created_at', 'asc')
            ->get();

        $approvableRequests = collect(); // 승인 가능한 요청만 필터링

        foreach ($withdrawalRequests as $request) {
            $requester = User::where('name', $request->name)->first();
            if (!$requester) continue;

            // 요청자가 현재 로그인한 파트너의 하위 멤버인지 확인 (recommander, store, super, hq, dist 로직 필요)
            // 현재는 간단히 requester의 recommander 또는 store가 currentUser.name인지 확인
            $isSubordinate = ($requester->recommander === $currentUser->name || $requester->store === $currentUser->name);

            // 또는, 더 복잡한 계층 확인 로직 필요
            // 예: $isSubordinate = $this->isUserSubordinate($currentUser, $requester);

            // 관리자(level 10)는 모든 요청 승인 가능
            // 파트너(level 3~9)는 자신의 하위 멤버 요청만 승인 가능
            if ($currentUser->level >= 10 || ($currentUser->level >= 3 && $currentUser->level <= 9 && $isSubordinate)) {
                $approvableRequests->push($request);
            }
        }

        return view('admin.balances.approvals', compact('approvableRequests'));
    }

    /**
     * 출금 요청 승인 처리
     * POST /admin/balances/approve-withdrawal/{balance}
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function approveWithdrawal(Request $request, Balance $balance)
    {
        $currentUser = Auth::user(); // 승인하는 상위 라인
        $requester = User::where('name', $balance->name)->first(); // 출금 요청한 하위 레벨
        $withdrawalAmount = $balance->amount; // 출금 요청 금액은 이미 DB에 숫자 형태로 있음

        // 1. 유효성 및 권한 검사
        if (!$requester || $balance->type !== -1 || $balance->status !== 'R') {
            return redirect()->back()->with('error', '유효하지 않은 출금 요청입니다.');
        }

        // 관리자(level 10)는 모든 요청 승인 가능
        // 파트너(level 3~9)는 자신의 하위 멤버 요청만 승인 가능
        $isSubordinate = ($requester->recommander === $currentUser->name || $requester->store === $currentUser->name);
        if ($currentUser->level < 10 && !($currentUser->level >= 3 && $currentUser->level <= 9 && $isSubordinate)) {
            return redirect()->back()->with('error', '이 출금 요청을 승인할 권한이 없습니다.');
        }

        // 2. 포인트 잔액 확인 (요청자 잔액 확인)
        if ($requester->point < $withdrawalAmount) {
            return redirect()->back()->with('error', '요청자의 포인트가 부족하여 승인할 수 없습니다.');
        }

        // 3. 총자산 잔액 확인 (출금 시 총자산도 차감되므로)
        $currentTotalAssets = (float) Setting::get('total_assets', 0.00);
        if ($currentTotalAssets < $withdrawalAmount) { // 총자산 부족 여부 확인
            return redirect()->back()->with('error', '시스템 총자본금이 부족하여 출금을 승인할 수 없습니다. 관리자에게 문의하세요.');
        }

        // 3. 트랜잭션 처리 (포인트 이동 및 상태 변경)
        DB::transaction(function () use ($currentUser, $requester, $balance, $withdrawalAmount, $currentTotalAssets) {
            // 하위 레벨 (요청자) 포인트 차감
            $requester->decrement('point', $withdrawalAmount);

            // 상위 라인 (승인자) 포인트 증가 (승인 커미션 또는 이익)
            $currentUser->increment('point', $withdrawalAmount);

            // Balance 테이블 상태 업데이트
            $balance->status = 'S';
            $balance->operator = $currentUser->name;
            $balance->save();

            // points 테이블에 포인트 이동 내역 기록
            Point::create([
                'fromName' => $requester->name,
                'toName' => $currentUser->name,
                'bid' => 0,
                'type' => 'withdrawal_approval',
                'game' => 'system',
                'amount' => $withdrawalAmount,
                'odds' => 0,
                'result_odds' => 0,
                'previous' => $requester->point + $withdrawalAmount,
                'request' => -$withdrawalAmount,
                'result' => $requester->point,
            ]);

            // 총자산 차감 및 기록
            $newTotalAssets = $currentTotalAssets - $withdrawalAmount;
            Setting::set('total_assets', $newTotalAssets);

            TotalAssetsHistory::create([
                'type' => 'withdrawal_process',
                'amount' => -$withdrawalAmount, // 차감은 음수
                'previous_total_assets' => $currentTotalAssets,
                'new_total_assets' => $newTotalAssets,
                'description' => $currentUser->name . ' 이(가) ' . $requester->name . ' 의 ' . number_format($withdrawalAmount, 2) . ' 출금 요청 승인 및 총자산 차감',
                'user_id' => $currentUser->id,
            ]);
        });

        return redirect()->route('admin.balances.approvals.show')->with('success', $requester->name . ' 님의 출금 요청을 승인하고 포인트 이동을 완료했습니다.');
    }


    /**
     * 토큰 전송 내역 관리 (GET /admin/transfers)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transfers(Request $request)
    {
        $transfers = Transfer::orderby('id', 'desc')->paginate(10);
        return view('admin.transfers', compact('transfers'));
    }

    /**
     * 입출금 내역 관리 (GET /admin/balances)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function balances(Request $request)
    {
        $balances = Balance::orderby('id', 'desc')->paginate(10);
        return view('admin.balances', compact('balances'));
    }

    /**
     * 포인트 내역 관리 (GET /admin/points)
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function points(Request $request)
    {
        $points = Point::orderby('id', 'desc')->paginate(10);
        return view('admin.points', compact('points'));
    }

    /**
     * 사용자 검색 (Select2 Ajax용)
     * GET /admin/users/search?q={검색어}
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchUsers(Request $request)
    {
        $search = $request->query('q');
        $users = User::where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%')
            ->limit(10) // 검색 결과는 10개로 제한
            ->get(['id', 'name', 'email', 'level']); // 필요한 필드만 가져오기

        // Select2가 기대하는 형식으로 데이터 변환
        $formattedUsers = $users->map(function ($user) {
            // `getLevelName()` 메서드는 User 모델에 정의되어 있어야 합니다.
            $levelName = $user->getLevelName();
            return ['id' => $user->id, 'text' => $user->name . ' (Email: ' . $user->email . ', 레벨: ' . $levelName . ')'];
        });

        return response()->json(['results' => $formattedUsers]);
    }

    private function cleanAndRoundAmount(string $amountString): float
    {
        $cleanAmount = str_replace(',', '', $amountString);
        $decimals = config('app.amount_decimals');

        // 반올림 처리
        if ($decimals === 0) {
            return round((float) $cleanAmount); // 정수로 반올림
        } else {
            return round((float) $cleanAmount, $decimals); // 소수점 자리수에 맞춰 반올림
        }
    }

    /**
     * 자본금 관리 (추가/회수) 폼 표시
     * GET /admin/settings/capital-manage
     * @return \Illuminate\Http\Response
     */
    public function showCapitalManageForm()
    {
        $currentTotalAssets = (float) Setting::get('total_assets', 0.00);
        $history = TotalAssetsHistory::orderBy('created_at', 'desc')->paginate(20); // 자본금 변경 내역
        return view('admin.settings.capital-manage', compact('currentTotalAssets', 'history'));
    }

    /**
     * 자본금 추가/회수 처리
     * POST /admin/settings/capital-manage
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function manageCapital(Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01'], // 최소 0.01로 변경
            'operation_type' => ['required', 'in:add,withdraw'],
        ], [
            'amount.required' => '금액은 필수로 입력해야 합니다.',
            'amount.numeric' => '금액은 숫자로 입력해야 합니다.',
            'amount.min' => '금액은 0.01 이상이어야 합니다.', // 메시지 추가
            'operation_type.required' => '작업 유형을 선택해야 합니다.',
            'operation_type.in' => '유효하지 않은 작업 유형입니다.',
        ]);

        $amount = $this->cleanAndRoundAmount($request->amount);
        $operationType = $request->operation_type;
        $adminUser = Auth::user();

        Log::channel('custom_debug')->info('DEBUG (Server): manageCapital received request.', ['amount' => $request->amount, 'operation_type' => $request->operation_type]);

        DB::transaction(function () use ($amount, $operationType, $adminUser) {
            $currentTotalAssets = (float) Setting::get('total_assets', 0.00);
            $newTotalAssets = $currentTotalAssets;
            $historyType = '';
            $description = '';

            if ($operationType === 'add') {
                $newTotalAssets = $currentTotalAssets + $amount;
                $historyType = 'capital_add';
                $description = $adminUser->name . ' 이(가) ' . number_format($amount, 2) . ' 자본금 추가';
            } elseif ($operationType === 'withdraw') {
                if ($currentTotalAssets < $amount) {
                    throw new \Exception("회수하려는 금액이 현재 총자본금보다 많습니다.");
                }
                $newTotalAssets = $currentTotalAssets - $amount;
                $historyType = 'capital_withdraw';
                $description = $adminUser->name . ' 이(가) ' . number_format($amount, 2) . ' 자본금 회수';
            }

            Setting::set('total_assets', $newTotalAssets);

            TotalAssetsHistory::create([
                'type' => $historyType,
                'amount' => ($operationType === 'add' ? $amount : -$amount),
                'previous_total_assets' => $currentTotalAssets,
                'new_total_assets' => $newTotalAssets,
                'description' => $description,
                'user_id' => $adminUser->id,
            ]);
        });

        return redirect()->route('admin.settings.capital-manage.show')->with('success', '자본금 관리가 완료되었습니다.');
    }

    private function generateWalletAddress(): ?array
    {
        $walletApiUrl = env('WALLET_API_URL');
        if (!$walletApiUrl) {
            Log::channel('custom_debug')->error("WALLET_API_URL 환경 변수가 설정되지 않았습니다."); // <-- 커스텀 채널 사용
            return null;
        }

        try {
            $response = Http::get($walletApiUrl);
            if ($response->successful()) {
                $data = $response->json();
                if (($data['success'] ?? false) && ($data['address'] ?? null) && ($data['privateKey'] ?? null)) {
                    Log::channel('custom_debug')->info("지갑 API 응답 성공: ", ['address' => $data['address']]); // <-- 커스텀 채널 사용
                    return [
                        'address' => $data['address'],
                        'privateKey' => $data['privateKey'],
                    ];
                }
            }
            Log::channel('custom_debug')->error("지갑 API 응답 실패: " . $response->body()); // <-- 커스텀 채널 사용
            return null;
        } catch (\Exception $e) {
            Log::channel('custom_debug')->error("지갑 API 호출 중 예외 발생: " . $e->getMessage()); // <-- 커스텀 채널 사용
            return null;
        }
    }

    /**
     * 사용자 계층 트리뷰 페이지 표시 (GET /admin/users/tree-view)
     * (PartnerController의 로직과 동일하게 수정)
     * @return \Illuminate\Http\Response
     */
    public function showUserTreeView()
    {
        $currentUser = Auth::user(); // 현재 로그인한 사용자 (트리의 루트가 됨)

        $allUsers = User::orderBy('name')->get(['id', 'name', 'email', 'level', 'recommander', 'store']);

        $tree = $this->buildHierarchyFromUser($currentUser, $allUsers);

        return view('admin.users.tree-view', compact('tree'));
    }

    /**
     * 특정 사용자를 시작점으로 하여 재귀적으로 하위 트리를 빌드하는 헬퍼 함수
     * (PartnerController의 로직과 동일하게 수정)
     *
     * @param User $rootUser 현재 트리의 루트가 될 사용자
     * @param Collection $allUsers 모든 사용자 모델 객체의 컬렉션
     * @return array
     */
    private function buildHierarchyFromUser(User $rootUser, Collection $allUsers): array
    {
        $lookupByName = $allUsers->keyBy('name');
        $rootNodeData = [
            'id' => $rootUser->id,
            'name' => $rootUser->name,
            'email' => $rootUser->email,
            'level' => $rootUser->level,
            'level_name' => $rootUser->getLevelName(),
            'recommander' => $rootUser->recommander,
            'store' => $rootUser->store,
            'children' => [],
        ];
        $this->populateChildren($rootNodeData['children'], $rootUser->name, $lookupByName);
        return $rootNodeData;
    }

    /**
     * 특정 부모 이름에 해당하는 자식 노드들을 찾고 재귀적으로 채워 넣는 함수
     * (PartnerController의 로직과 동일하게 수정)
     *
     * @param array $parentNodeChildren 현재 부모 노드의 'children' 배열에 대한 참조
     * @param string $parentName 현재 부모 노드의 이름
     * @param Collection $lookupByName 모든 사용자 맵
     */
    private function populateChildren(array &$parentNodeChildren, string $parentName, Collection $lookupByName)
    {
        $directChildren = $lookupByName->filter(function ($child) use ($parentName) {
            return ($child->recommander === $parentName) ||
                ($child->store === $parentName && $child->recommander !== $parentName);
        })->sortBy('name');

        foreach ($directChildren as $child) {
            $node = [
                'id' => $child->id,
                'name' => $child->name,
                'email' => $child->email,
                'level' => $child->level,
                'level_name' => $child->getLevelName(),
                'recommander' => $child->recommander,
                'store' => $child->store,
                'children' => [],
            ];
            $this->populateChildren($node['children'], $child->name, $lookupByName);
            $parentNodeChildren[] = $node;
        }
    }
}
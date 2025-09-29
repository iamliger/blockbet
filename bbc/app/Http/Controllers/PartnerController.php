<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Balance;
use App\Point;
use App\Setting; // 총자산 가져오기 위해 필요
use Illuminate\Support\Collection;

class PartnerController extends Controller
{
    /**
     * 파트너 대시보드 메인 페이지 표시
     * GET /partner/dashboard
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $partnerUser = Auth::user(); // 현재 로그인한 파트너 사용자

        // 파트너 정보 요약
        $myLevel = $partnerUser->level;
        $myLevelName = $partnerUser->getLevelName();
        $myPoint = $partnerUser->point;

        // 상위 파트너 정보 (추천인)
        $upperPartner = null;
        if ($partnerUser->recommander) {
            $upperPartner = User::where('name', $partnerUser->recommander)->first();
        }

        // 하위 멤버 통계 (직접적인 하위 멤버: recommander 또는 store가 자신인 경우)
        // 고객님의 규칙 "레벨 9 -> 레벨 2로 만들 수도 있고 ... 유연하다"를 반영
        $directSubordinates = User::where('recommander', $partnerUser->name)
            ->orWhere('store', $partnerUser->name)
            ->where('id', '!=', $partnerUser->id) // 자신 제외
            ->get();

        $totalSubordinates = $directSubordinates->count(); // 총 직접 하위 멤버 수
        $totalSubordinatePoints = $directSubordinates->sum('point'); // 하위 멤버 총 포인트

        // 자신에게 들어온 출금 승인 요청 목록 (간단한 버전)
        $mySubordinatesWithdrawalRequests = Balance::where('type', -1)
            ->where('status', 'R')
            ->whereIn('name', $directSubordinates->pluck('name')) // 하위 멤버 이름들로 필터링
            ->orderBy('created_at', 'asc')
            ->get();
        $pendingWithdrawalsForApproval = $mySubordinatesWithdrawalRequests->count();
        $sumPendingWithdrawalAmount = $mySubordinatesWithdrawalRequests->sum('amount');


        // 기타 정보
        $currentTotalAssets = (float) Setting::get('total_assets', 0.00); // 시스템 총자산

        return view('partner.dashboard', compact(
            'partnerUser',
            'myLevel',
            'myLevelName',
            'myPoint',
            'upperPartner',
            'totalSubordinates',
            'totalSubordinatePoints',
            'pendingWithdrawalsForApproval',
            'sumPendingWithdrawalAmount',
            'currentTotalAssets'
        ));
    }

    /**
     * 파트너용 사용자 계층 트리뷰 페이지 표시
     * GET /partner/users/tree-view
     * @return \Illuminate\Http\Response
     */
    public function showUserTreeView()
    {
        $currentUser = Auth::user(); // 현재 로그인한 파트너 사용자 (트리의 루트가 됨)

        // 모든 사용자를 한 번에 가져와 메모리에서 트리를 구성합니다.
        $allUsers = User::orderBy('name')->get(['id', 'name', 'email', 'level', 'recommander', 'store']);

        // 로그인한 파트너 사용자를 시작점으로 하위 트리만 빌드
        $tree = $this->buildHierarchyFromUser($currentUser, $allUsers);

        return view('admin.users.tree-view', compact('tree')); // AdminController와 동일한 뷰 재사용
    }

    /**
     * 특정 사용자를 시작점으로 하여 재귀적으로 하위 트리를 빌드하는 헬퍼 함수
     * (AdminController의 로직과 동일하나, 가독성 향상)
     *
     * @param User $rootUser 현재 트리의 루트가 될 사용자 (로그인한 사용자)
     * @param Collection $allUsers 모든 사용자 모델 객체의 컬렉션
     * @return array
     */
    private function buildHierarchyFromUser(User $rootUser, Collection $allUsers): array
    {
        // 모든 사용자를 'name'으로 인덱싱한 맵을 생성하여 빠르게 자식을 찾을 수 있도록 함
        $lookupByName = $allUsers->keyBy('name');

        $rootNodeData = [
            'id' => $rootUser->id,
            'name' => $rootUser->name,
            'email' => $rootUser->email,
            'level' => $rootUser->level,
            'level_name' => $rootUser->getLevelName(),
            'recommander' => $rootUser->recommander,
            'store' => $rootUser->store,
            'children' => [], // 자식 노드들을 저장할 배열
        ];

        // 재귀 함수를 호출하여 루트 노드의 자식들을 채움
        $this->populateChildren($rootNodeData['children'], $rootUser->name, $lookupByName);

        return $rootNodeData; // 완성된 루트 노드 반환
    }

    /**
     * 특정 부모 이름에 해당하는 자식 노드들을 찾고 재귀적으로 채워 넣는 함수
     * (AdminController의 로직과 동일하나, 가독성 향상 및 중복 추가 오류 수정)
     *
     * @param array $parentNodeChildren 현재 부모 노드의 'children' 배열에 대한 참조
     * @param string $parentName 현재 부모 노드의 이름
     * @param Collection $lookupByName 모든 사용자 맵
     */
    private function populateChildren(array &$parentNodeChildren, string $parentName, Collection $lookupByName)
    {
        // 현재 $parentName을 'recommander' 또는 'store'로 가진 직접적인 자식들을 찾음
        // 고객님의 규칙: 레벨 9 -> 레벨 2 가능 (직접 recommander/store 관계)
        $directChildren = $lookupByName->filter(function ($child) use ($parentName) {
            // 자식의 recommander가 현재 사용자이거나,
            // 자식의 store가 현재 사용자이면서 recommander가 현재 사용자가 아닌 경우 (중복 방지)
            return ($child->recommander === $parentName) ||
                ($child->store === $parentName && $child->recommander !== $parentName);
        })->sortBy('name'); // 이름 순으로 정렬

        foreach ($directChildren as $child) {
            $node = [
                'id' => $child->id,
                'name' => $child->name,
                'email' => $child->email,
                'level' => $child->level,
                'level_name' => $child->getLevelName(),
                'recommander' => $child->recommander,
                'store' => $child->store,
                'children' => [], // 자식 노드들을 저장할 배열
            ];
            // 자식의 children 배열에 대한 참조를 넘겨 재귀 호출
            $this->populateChildren($node['children'], $child->name, $lookupByName);
            $parentNodeChildren[] = $node; // 완성된 노드를 부모의 children 배열에 추가 (여기서만 추가)
        }
    }

    public function usersIndex(Request $request)
    {
        $partnerUser = Auth::user(); // 현재 로그인한 파트너
        $query = User::query();
        $searchTerm = null;

        // 자신의 하위 멤버만 조회 (recommander 또는 store가 자신인 사용자)
        $query->where(function ($q) use ($partnerUser) {
            $q->where('recommander', $partnerUser->name)
                ->orWhere('store', $partnerUser->name);
        })->where('id', '!=', $partnerUser->id); // 자신 제외

        // 검색어 필터링 (옵션)
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $searchTerm . '%');
            });
        }

        $users = $query->paginate(30);

        return view('admin.users.index', compact('users', 'searchTerm')); // admin 뷰 재사용
    }
}
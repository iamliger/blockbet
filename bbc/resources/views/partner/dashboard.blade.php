{{-- resources/views/partner/dashboard.blade.php --}}
@extends('adminlte::page') {{-- AdminLTE 레이아웃 상속 --}}

@section('title', '파트너 대시보드') {{-- 페이지 제목 --}}

@section('content_header') {{-- AdminLTE의 콘텐츠 헤더 슬롯 --}}
    <h1 class="m-0 text-dark">파트너 대시보드</h1>
    <p class="m-0 text-dark">안녕하세요, {{ $partnerUser->name }} 님 ({{ $myLevelName }})!</p>
@stop

@section('content') {{-- AdminLTE의 메인 콘텐츠 슬롯 --}}
    <div class="row">
        {{-- 내 레벨 및 포인트 정보 카드 --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-primary"> {{-- AdminLTE 기본 색상 --}}
                <div class="inner">
                    <h3>{{ $myLevel }} ({{ $myLevelName }})</h3>
                    <p>내 레벨</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="#" class="small-box-footer">포인트: {{ number_format($myPoint, config('app.amount_decimals')) }}</a>
            </div>
        </div>

        {{-- 상위 파트너 정보 카드 --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-success">
                <div class="inner">
                    <h3>{{ $upperPartner->name ?? '없음' }}</h3>
                    <p>상위 파트너</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <a href="#" class="small-box-footer">레벨: {{ $upperPartner->level ?? 'N/A' }}</a>
            </div>
        </div>

        {{-- 총 하위 멤버 수 카드 --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    <h3>{{ $totalSubordinates }} 명</h3>
                    <p>내 하위 멤버 수</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users.index', ['search_recommander' => $partnerUser->name]) }}" class="small-box-footer">상세 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- 하위 멤버 총 포인트 카드 --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>{{ number_format($totalSubordinatePoints, config('app.amount_decimals')) }}</h3>
                    <p>하위 멤버 총 보유 포인트</p>
                </div>
                <div class="icon">
                    <i class="fas fa-coins"></i>
                </div>
                <a href="#" class="small-box-footer">통계 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- 출금 승인 요청 카드 (자신에게 들어온) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3>{{ $pendingWithdrawalsForApproval }} 건</h3>
                    <p>대기 중인 출금 요청</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <a href="{{ route('admin.balances.approvals.show') }}" class="small-box-footer">자세히 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- 시스템 총자산 (참고용, 관리자와 동일) --}}
        <div class="col-lg-3 col-6">
            <div class="small-box bg-gradient-secondary">
                <div class="inner">
                    <h3>{{ number_format($currentTotalAssets, config('app.amount_decimals')) }}</h3>
                    <p>시스템 총자산 (참고)</p>
                </div>
                <div class="icon">
                    <i class="fas fa-globe"></i>
                </div>
                <a href="#" class="small-box-footer">시스템 현황 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

    </div> {{-- .row --}}

    <h2 class="mt-5 text-dark">파트너 기능</h2>
    <div class="list-group">
        <a href="{{ route('admin.partners.send-points.form') }}" class="list-group-item list-group-item-action">하위 멤버 포인트 지급</a>
        <a href="{{ route('admin.balances.approvals.show') }}" class="list-group-item list-group-item-action">출금 요청 승인</a>
        {{-- 기타 파트너 기능 --}}
    </div>
@stop

{{-- AdminLTE의 추가적인 JS/CSS 섹션 (필요 시) --}}
@section('css')
    @parent
    {{-- 파트너 대시보드 전용 CSS 추가 가능 --}}
@stop

@section('js')
    @parent
    {{-- 파트너 대시보드 전용 JS 추가 가능 --}}
@stop
{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page') {{-- AdminLTE의 기본 페이지 레이아웃 직접 상속 --}}

@section('title', '관리자 대시보드') {{-- 페이지 제목 --}}

@section('content_header') {{-- AdminLTE의 콘텐츠 헤더 슬롯 --}}
    <h1 class="m-0 text-dark">관리자 대시보드</h1>
@stop

@section('content') {{-- AdminLTE의 메인 콘텐츠 슬롯 --}}
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalUsers }}</h3>
                    <p>총 사용자 수</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('admin.users') }}" class="small-box-footer">자세히 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $pendingDeposits }}</h3>
                    <p>대기 중인 입금</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-check-alt"></i>
                </div>
                <a href="{{ route('admin.balances') }}" class="small-box-footer">자세히 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $pendingWithdrawals }}</h3>
                    <p>대기 중인 출금</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
                <a href="{{ route('admin.balances') }}" class="small-box-footer">자세히 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalTransfers }}</h3>
                    <p>총 전송 수</p>
                </div>
                <div class="icon">
                    <i class="fas fa-exchange-alt"></i>
                </div>
                <a href="{{ route('admin.transfers') }}" class="small-box-footer">자세히 보기 <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div> {{-- .row --}}

    {{-- 빠른 링크 섹션 제거 요청 반영 --}}
@stop

{{-- AdminLTE의 추가적인 JS/CSS 섹션 (필요 시) --}}
@section('css')
    {{-- 여기에 관리자 전용 CSS 추가 가능 (AdminLTE 기본 위에 덮어쓰기) --}}
@stop

@section('js')
    {{-- 여기에 관리자 전용 JS 추가 가능 --}}
@stop
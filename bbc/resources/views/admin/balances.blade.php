{{-- resources/views/admin/balances.blade.php --}}
@extends('admin.layouts.master') {{-- AdminLTE 레이아웃 상속 --}}

@section('title', '입출금 내역') {{-- 페이지 제목 추가 --}}

@section('content_header')
    <h1 class="m-0 text-dark">입출금 내역</h1>
@stop

@section('admin_content') {{-- AdminLTE 레이아웃의 슬롯 사용 --}}
<div class="card"> {{-- AdminLTE 카드 컴포넌트 사용 --}}
    <div class="card-header">
        <h3 class="card-title">등록된 입출금 목록</h3>
        <div class="card-tools">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>유저 이름</th>
                        <th>타입</th>
                        <th>금액</th>
                        <th>지갑 주소</th>
                        <th>거래 ID (tid)</th>
                        <th>상태</th>
                        <th>날짜</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($balances as $balance)
                    <tr>
                        <td>{{ $balance->id }}</td>
                        <td>{{ $balance->name }}</td>
                        <td>{{ $balance->type == 1 ? '입금' : '출금' }}</td>
                        <td>{{ number_format($balance->amount, 2) }}</td>
                        <td>{{ $balance->address }}</td>
                        <td>{{ $balance->tid }}</td>
                        <td>{{ $balance->status }}</td>
                        <td>{{ $balance->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $balances->links('vendor.pagination.adminlte') }}
    </div>
</div>
@endsection
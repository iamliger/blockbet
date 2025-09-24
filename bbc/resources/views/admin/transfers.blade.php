{{-- resources/views/admin/transfers.blade.php --}}
@extends('adminlte::page')

@section('title', '토큰 전송 내역')

@section('content_header')
    <h1 class="m-0 text-dark">토큰 전송 내역</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">등록된 토큰 전송 목록</h3>
            <div class="card-tools">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped admin-table"> {{-- admin-table 클래스 추가 --}}
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>보낸 사람</th>
                            <th>보낸 주소</th>
                            <th>받는 사람</th>
                            <th>받는 주소</th>
                            <th>금액</th>
                            <th>거래 ID (tid)</th>
                            <th>상태</th>
                            <th>담당자</th>
                            <th>날짜</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transfers as $transfer)
                        <tr>
                            <td>{{ $transfer->id }}</td>
                            <td>{{ $transfer->fromName }}</td>
                            <td>{{ $transfer->fromAddress }}</td>
                            <td>{{ $transfer->toName }}</td>
                            <td>{{ $transfer->toAddress }}</td>
                            <td>{{ number_format($transfer->amount, 2) }}</td>
                            <td>{{ $transfer->tid }}</td>
                            <td>
                                @if($transfer->status == 'R') 요청됨
                                @elseif($transfer->status == 'S') 처리 중
                                @elseif($transfer->status == 'F') 완료됨
                                @elseif($transfer->status == 'C') 취소됨
                                @else 알 수 없음
                                @endif
                            </td>
                            <td>{{ $transfer->operator }}</td>
                            <td>{{ $transfer->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $transfers->links('vendor.pagination.adminlte') }} {{-- AdminLTE 페이징 뷰 사용 --}}
        </div>
    </div>
@stop
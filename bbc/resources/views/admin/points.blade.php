{{-- resources/views/admin/points.blade.php --}}
@extends('admin.layouts.master') {{-- AdminLTE 레이아웃 상속 --}}

@section('title', '포인트 내역') {{-- 페이지 제목 추가 --}}

@section('content_header')
    <h1 class="m-0 text-dark">포인트 내역</h1>
@stop

@section('admin_content') {{-- AdminLTE 레이아웃의 슬롯 사용 --}}
<div class="card"> {{-- AdminLTE 카드 컴포넌트 사용 --}}
    <div class="card-header">
        <h3 class="card-title">등록된 포인트 목록</h3>
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
                        <th>보낸 사람</th>
                        <th>받은 사람</th>
                        <th>베팅 ID</th>
                        <th>타입</th>
                        <th>게임</th>
                        <th>금액</th>
                        <th>배당률</th>
                        <th>요청 포인트</th>
                        <th>처리 날짜</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($points as $point)
                    <tr>
                        <td>{{ $point->id }}</td>
                        <td>{{ $point->fromName }}</td>
                        <td>{{ $point->toName }}</td>
                        <td>{{ $point->bid }}</td>
                        <td>{{ $point->type }}</td>
                        <td>{{ $point->game }}</td>
                        <td>{{ number_format($point->amount, 2) }}</td>
                        <td>{{ $point->odds }}</td>
                        <td>{{ number_format($point->request, 2) }}</td>
                        <td>{{ $point->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $points->links('vendor.pagination.adminlte') }}
    </div>
</div>
@endsection
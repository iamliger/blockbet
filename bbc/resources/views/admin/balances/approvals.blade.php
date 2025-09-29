{{-- resources/views/admin/balances/approvals.blade.php --}}
@extends('admin.layouts.master')

@section('title', '출금 요청 승인')

@section('content_header')
    <h1 class="m-0 text-dark">출금 요청 승인</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">승인 대기 중인 출금 요청 목록</h3>
            <div class="card-tools">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-nowrap">요청 ID</th>
                            <th class="text-nowrap">요청자 이름</th>
                            <th class="text-nowrap">요청 금액</th>
                            <th class="text-nowrap">요청자 주소</th>
                            <th class="text-nowrap">요청 시간</th>
                            <th class="text-nowrap">상태</th>
                            <th class="text-nowrap">액션</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($approvableRequests as $request)
                        <tr>
                            <td>{{ $request->id }}</td>
                            <td>{{ $request->name }}</td>
                            <td>{{ number_format($request->amount, 2) }}</td>
                            <td>{{ Str::limit($request->address, 15, '...') }}</td>
                            <td>{{ $request->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $request->status }} (요청됨)</td>
                            <td class="text-nowrap">
                                <form action="{{ route('admin.balances.approvals.approve', $request->id) }}" method="POST" onsubmit="return confirm('이 출금 요청을 승인하시겠습니까?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">승인</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">승인 대기 중인 출금 요청이 없습니다.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{-- 페이징 필요 시 $approvableRequests->links('vendor.pagination.adminlte') --}}
        </div>
    </div>
@stop
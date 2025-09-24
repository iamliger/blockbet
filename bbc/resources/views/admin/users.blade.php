{{-- resources/views/admin/users.blade.php --}}
@extends('admin.layouts.master')

@section('title', '사용자 관리') {{-- 페이지 제목 --}}

@section('content_header')
    <h1 class="m-0 text-dark">사용자 관리</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">등록된 사용자 목록</h3>
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
                            <th>이름</th>
                            <th>이메일</th>
                            <th>레벨</th>
                            <th>추천인</th>
                            <th>스토어</th>
                            <th>포인트</th>
                            <th>지갑 주소</th>
                            <th>가입일</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->level }}</td>
                            <td>{{ $user->recommander }}</td>
                            <td>{{ $user->store }}</td>
                            <td>{{ number_format($user->point, 2) }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->links('vendor.pagination.adminlte') }} {{-- AdminLTE 스타일 페이징 --}}
        </div>
    </div>
@stop
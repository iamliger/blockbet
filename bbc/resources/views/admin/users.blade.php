{{-- resources/views/admin/users.blade.php --}}
@extends('admin.layouts.master')

@section('title', '사용자 관리')

@section('content_header')
    <h1 class="m-0 text-dark">사용자 관리</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">등록된 사용자 목록</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm mr-2"><i class="fas fa-plus-circle"></i> 회원 추가</a> {{-- 회원 추가 버튼 --}}
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover text-nowrap"> {{-- table-hover 클래스 추가 --}}
                    <thead>
                        <tr>
                            <th class="text-nowrap">ID</th>
                            <th class="text-nowrap">이름</th>
                            <th class="text-nowrap">이메일</th>
                            <th class="text-nowrap">레벨</th>
                            <th class="text-nowrap">추천인</th>
                            <th class="text-nowrap">스토어</th>
                            <th class="text-nowrap">포인트</th>
                            <th class="text-nowrap text-center">지갑 주소</th> {{-- 중앙 정렬 --}}
                            <th class="text-nowrap">가입일</th>
                            <th class="text-nowrap text-center">액션</th> {{-- 중앙 정렬 --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="align-middle"> {{-- 행 전체 수직 중앙 정렬 --}}
                            <td class="text-nowrap">{{ $user->id }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="text-dark">{{ $user->name }}</a> {{-- 클릭 시 상세 보기 --}}
                            </td>
                            <td class="text-nowrap">{{ $user->email }}</td>
                            <td class="text-nowrap">{{ $user->level }}</td>
                            <td class="text-nowrap">{{ $user->recommander }}</td>
                            <td class="text-nowrap">{{ $user->store }}</td>
                            <td class="text-nowrap">{{ number_format($user->point, 2) }}</td>
                            {{-- 지갑 주소 표시 및 복사 기능 --}}
                            <td class="text-nowrap text-center"> {{-- 중앙 정렬 --}}
                                @if($user->address)
                                    <span title="{{ $user->address }}"
                                          onclick="copyToClipboard(this, '{{ $user->address }}')"
                                          style="cursor: pointer; text-decoration: underline;">
                                        {{ Str::limit($user->address, 15, '...') }}
                                    </span>
                                @else
                                    -
                                @endif
                            </td>
                            {{-- 가입일 형식 변경 --}}
                            <td class="text-nowrap">{{ $user->created_at->format('Y-m-d') }}</td>
                            {{-- 상세 보기/수정 버튼 --}}
                            <td class="text-nowrap text-center"> {{-- 중앙 정렬 --}}
                                <div class="btn-group"> {{-- 버튼 그룹으로 묶기 --}}
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">상세 보기</a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">수정</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->links('vendor.pagination.adminlte') }}
        </div>
    </div>
@stop

{{-- JavaScript 섹션에 복사 함수 추가 (이전과 동일) --}}
@section('js')
    @parent
    <script>
        function copyToClipboard(element, textToCopy) {
            navigator.clipboard.writeText(textToCopy).then(function() {
                element.style.color = 'green';
                element.textContent = 'Copied!';
                setTimeout(() => {
                    element.style.color = '';
                    element.textContent = textToCopy.substring(0, 15) + '...';
                }, 500);
            }).catch(function(err) {
                console.error('클립보드 복사 실패:', err);
                alert('클립보드 복사 실패!');
            });
        }
    </script>
@stop
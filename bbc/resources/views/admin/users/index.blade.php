{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layouts.master')

@section('title', '회원 목록')

@section('content_header')
    <h1 class="m-0 text-dark">회원 목록</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">등록된 사용자 목록</h3>
            <div class="card-tools">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm mr-2"><i class="fas fa-plus"></i> 회원 추가</a> {{-- <-- 회원 추가 버튼 --}}
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body p-0">
            {{-- === 회원 검색 필드 추가 시작 === --}}
            <div class="p-3">
                <form action="{{ route('admin.users.index') }}" method="GET" class="form-inline">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="이름 또는 이메일 검색" value="{{ $searchTerm ?? '' }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-info"><i class="fas fa-search"></i> 검색</button>
                            @if(isset($searchTerm) && $searchTerm) {{-- 검색어가 있을 때만 초기화 버튼 표시 --}}
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-1"><i class="fas fa-redo"></i> 초기화</a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            {{-- === 회원 검색 필드 추가 끝 === --}}
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-nowrap">
                    <thead>
                        <tr>
                            <th class="text-nowrap">ID 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('id') }}"></i>
                                @endif
                            </th>
                            <th class="text-nowrap">이름 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('name') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">이메일 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('email') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">레벨 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('level') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">추천인 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('recommander') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">스토어 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('store') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">포인트 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('point') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">지갑 주소 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('address') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">가입일 
                                @if(config('app.show_tooltips'))
                                <i class="fas fa-question-circle text-muted ml-1" data-toggle="tooltip" title="{{ App\User::getColumnComment('created_at') }}"></i>
                                @endif                            
                            </th>
                            <th class="text-nowrap">액션</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="text-nowrap">
                                <a href="#" onclick="showUserActions(event, '{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="text-nowrap">{{ $user->name }}</td>
                            <td class="text-nowrap">
                                <a href="#" onclick="showUserActions(event, '{{ $user->id }}', '{{ $user->name }}', '{{ $user->email }}')">
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td class="text-nowrap">{{ $user->level }}</td>
                            <td class="text-nowrap">{{ $user->recommander }}</td>
                            <td class="text-nowrap">{{ $user->store }}</td>
                            <td class="text-nowrap">{{ number_format($user->point, config('app.amount_decimals')) }}</td>
                            <td class="text-nowrap">
                                <span title="{{ $user->address }}"
                                      onclick="copyToClipboard(this, '{{ $user->address }}')"
                                      style="cursor: pointer; text-decoration: underline;">
                                    {{ Str::limit($user->address, 15, '...') }}
                                </span>
                            </td>
                            <td class="text-nowrap">{{ $user->created_at->format('Y-m-d') }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">상세 보기</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning">수정</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->appends(['search' => $searchTerm ?? '', 'search_recommander' => $recommanderName ?? ''])->links('vendor.pagination.adminlte') }}
        </div>
    </div>
    @stop

    @section('js')
        @parent
        <script>
            // AdminLTE의 jQuery와 Bootstrap 툴팁 플러그인이 로드된 후 실행
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            function copyToClipboard(element, textToCopy) {
                navigator.clipboard.writeText(textToCopy).then(function() {
                    element.style.color = 'green';
                    element.textContent = 'Copied!';
                    setTimeout(() => {
                        element.style.color = '';
                        element.textContent = textToCopy.substring(0, 15) + '...';
                    }, 1500);
                }).catch(function(err) {
                    console.error('클립보드 복사 실패:', err);
                    alert('클립보드 복사 실패!');
                });
            }

            function showUserActions(event, userId, userName, userEmail) {
                event.preventDefault(); // 기본 링크 동작 방지

                Swal.fire({
                    title: `${userName} (${userEmail})`,
                    html: `
                        <p>어떤 작업을 수행하시겠습니까?</p>
                        <button id="msgBtn" class="swal2-styled swal2-confirm" style="background-color:#007bff; color:#fff;">메시지 보내기</button>
                        <button id="pointBtn" class="swal2-styled swal2-confirm" style="background-color:#28a745; color:#fff;">포인트 지급</button>
                        <button id="detailBtn" class="swal2-styled swal2-confirm" style="background-color:#17a2b8; color:#fff;">상세 정보</button>
                    `,
                    showCancelButton: true,
                    showConfirmButton: false, // 기본 확인 버튼 숨김
                    cancelButtonText: '닫기',
                    didOpen: () => {
                        document.getElementById('msgBtn').addEventListener('click', () => {
                            Swal.close();
                            alert(`'${userName}' 에게 메시지 보내기 기능 구현 필요`);
                            // 실제 메시지 전송 모달 또는 페이지로 이동하는 로직
                        });
                        document.getElementById('pointBtn').addEventListener('click', () => {
                            Swal.close();
                            alert(`'${userName}' 에게 포인트 지급 기능 구현 필요`);
                            // 실제 포인트 지급 폼으로 이동 (예: admin/partners/send-points?target_member_id=${userId})
                        });
                        document.getElementById('detailBtn').addEventListener('click', () => {
                            Swal.close();
                            window.location.href = `/admin/users/${userId}`; // 상세 정보 페이지로 이동
                        });
                    }
                });
            }
        </script>
    @stop
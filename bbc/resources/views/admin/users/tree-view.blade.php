{{-- resources/views/admin/users/tree-view.blade.php --}}
@extends('admin.layouts.master')

@section('title', '회원 트리구조 보기')

@section('content_header')
    <h1 class="m-0 text-dark">회원 트리구조 보기</h1>
@stop

@section('admin_content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">전체 회원 계층 구조 (기준: {{ Auth::user()->name }} 님)</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-sm btn-outline-primary" id="expandAllBtn">모두 펼치기</button>
                <button type="button" class="btn btn-sm btn-outline-secondary ml-1" id="collapseAllBtn">모두 접기</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm ml-2"><i class="fas fa-arrow-left"></i> 대시보드로 돌아가기</a>
            </div>
        </div>
        <div class="card-body">
            <div class="user-tree-container">
                @if(!empty($tree)) {{-- $tree는 단일 루트 노드 배열이므로 empty 체크 --}}
                    <ul class="user-tree">
                        @include('admin.users.partials.tree-node', ['node' => $tree]) {{-- <-- $tree 자체를 루트 노드로 전달 --}}
                    </ul>
                @else
                    <p>현재 사용자({{ Auth::user()->name }})는 하위 멤버가 없거나, 계층 구조에 포함되어 있지 않습니다.</p>
                    <p>로그인한 사용자의 'recommander' 또는 'store' 필드가 다른 사용자의 'name' 필드와 일치하는 하위 멤버를 찾지 못했습니다.</p>
                @endif
            </div>
        </div>
    </div>
@stop

@section('js')
    @parent
    <script>
        $(document).ready(function() {
            // 접기/펴기 토글 기능
            $('.user-tree-toggle').on('click', function() {
                $(this).closest('li').find('ul:first').toggle('fast');
                $(this).find('i').toggleClass('fa-caret-right fa-caret-down');
            });

            // 모두 펼치기/접기 버튼 기능
            $('#expandAllBtn').on('click', function() {
                $('.user-tree').find('ul').show('fast');
                $('.user-tree-toggle i').removeClass('fa-caret-right').addClass('fa-caret-down');
            });

            $('#collapseAllBtn').on('click', function() {
                $('.user-tree').find('ul').hide('fast');
                $('.user-tree-toggle i').removeClass('fa-caret-down').addClass('fa-caret-right');
            });

            // 페이지 로드 시 기본적으로 접혀 있도록
            $('.user-tree > li > ul').hide();
            $('.user-tree > li > .user-tree-toggle i').removeClass('fa-caret-down').addClass('fa-caret-right');
        });

        // 사용자 액션 팝업 함수 (트리뷰용)
        function showUserTreeActions(event, userId, userName, userEmail, userLevel) {
            event.preventDefault(); // 기본 링크 동작 방지 (혹시 모를 경우)
            event.stopPropagation(); // 이벤트 버블링 방지 (부모 토글 기능과 충돌 방지)

            let buttonsHtml = `
                <button id="detailBtn" class="swal2-styled swal2-confirm" style="background-color:#17a2b8; color:#fff;">회원 상세 정보</button>
                <button id="editBtn" class="swal2-styled swal2-confirm" style="background-color:#ffc107; color:#fff;">회원 수정</button>
            `;

            // 특정 레벨 (슈퍼관리자)일 경우만 '포인트 지급' 버튼 추가 (예시)
            // if (userLevel == 10) { // 슈퍼관리자 (admin) 일 경우
                buttonsHtml += `<button id="pointDistributeBtn" class="swal2-styled swal2-confirm" style="background-color:#28a745; color:#fff;">포인트 지급</button>`;
            // }

            Swal.fire({
                title: `${userName} (레벨: ${userLevel})`,
                html: `
                    <p>${userName} 님 (${userEmail})에 대한 작업을 선택하세요.</p>
                    ${buttonsHtml}
                `,
                showCancelButton: true,
                showConfirmButton: false, // 기본 확인 버튼 숨김
                cancelButtonText: '닫기',
                didOpen: () => {
                    document.getElementById('detailBtn').addEventListener('click', () => {
                        Swal.close();
                        window.location.href = `/admin/users/${userId}`; // 상세 정보 페이지로 이동
                    });
                    document.getElementById('editBtn').addEventListener('click', () => {
                        Swal.close();
                        window.location.href = `/admin/users/${userId}/edit`; // 수정 페이지로 이동
                    });
                    // 포인트 지급 버튼 이벤트
                    const pointDistributeBtn = document.getElementById('pointDistributeBtn');
                    if (pointDistributeBtn) {
                        pointDistributeBtn.addEventListener('click', () => {
                            Swal.close();
                            // 실제 포인트 지급 폼으로 이동 (예: admin/points/distribute?target_user_id=${userId})
                            window.location.href = `/admin/points/distribute?target_user_id=${userId}`;
                        });
                    }
                }
            });
        }
    </script>
@stop

@section('css')
    @parent
    <style>
        .user-tree ul {
            list-style-type: none;
            padding-left: 20px;
            margin-left: 10px;
            border-left: 1px solid #ccc;
        }
        .user-tree li {
            margin: 5px 0;
            position: relative;
        }
        .user-tree li::before {
            content: "";
            position: absolute;
            left: -10px;
            top: 15px;
            width: 10px;
            height: 0;
            border-top: 1px solid #ccc;
        }
        .user-tree li:first-child::before {
            top: 15px;
        }
        .user-tree-toggle {
            cursor: pointer;
            margin-right: 5px;
            color: #007bff;
        }
        .user-info {
            display: inline-block;
            padding: 3px 8px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            color: #495057;
            white-space: nowrap; /* 내용이 길어도 줄 바꿈 방지 */
        }
        .user-info .email-tag {
            font-size: 0.8em;
            color: #6c757d;
            margin-left: 5px;
        }
        .user-info .level-tag {
            font-size: 0.8em;
            background-color: #6c757d;
            color: white;
            padding: 2px 5px;
            border-radius: 3px;
            margin-left: 5px;
        }
    </style>
@stop
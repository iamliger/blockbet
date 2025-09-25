{{-- resources/views/admin/layouts/master.blade.php --}}
@extends('adminlte::page') {{-- AdminLTE의 기본 페이지 레이아웃을 상속 --}}

@section('title', 'BLOCK BET 관리자') {{-- 페이지 제목 --}}

@section('content_header') {{-- AdminLTE의 콘텐츠 헤더 슬롯 --}}
    <h1 class="m-0 text-dark">관리자 대시보드</h1>
@stop

@section('content') {{-- AdminLTE의 메인 콘텐츠 슬롯 --}}
    @yield('admin_content') {{-- 실제 관리자 뷰 파일들이 삽입될 슬롯 --}}
@stop

@section('footer') {{-- AdminLTE의 푸터 슬롯 (선택 사항) --}}
    <div class="text-right">
        Copyright &copy; {{ date('Y') }} BLOCKBET All Rights Reserved.
    </div>
@stop

{{-- AdminLTE의 추가적인 JS/CSS 섹션 (필요 시) --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    @parent {{-- AdminLTE 기본 JS를 유지 --}}
    @if(config('app.show_tooltips')) {{-- 툴팁 설정이 true일 때만 JS 로드 --}}
    <script>
        $(function () {
            // AdminLTE의 jQuery와 Bootstrap 툴팁 플러그인이 로드된 후 실행
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @endif
@stop

{{-- === 여기에 로그아웃 폼을 추가합니다 === --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
{{-- === 로그아웃 폼 추가 끝 === --}}
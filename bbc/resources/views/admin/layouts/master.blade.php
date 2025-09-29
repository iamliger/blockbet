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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    @parent {{-- AdminLTE 기본 JS를 유지 --}}
    {{-- Select2 JS 로드 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- SweetAlert2 JS 로드 (선택 사항) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(config('app.show_tooltips')) {{-- 툴팁 설정이 true일 때만 JS 로드 --}}
    <script>
        $(function () {
            // AdminLTE의 jQuery와 Bootstrap 툴팁 플러그인이 로드된 후 실행
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @endif

    <script>
        window.APP_AMOUNT_DECIMALS = {{ config('app.amount_decimals') }};
        // 숫자 입력 자동 콤마 포맷팅 함수 (수정)
        function formatNumberInput(input, blur = false) {
            let value = input.value.replace(/[^0-9.]/g, ''); // 숫자와 소수점만 남기기
            let parts = value.split('.');
            let integerPart = parts[0];
            let decimalPart = parts.length > 1 ? parts[1] : '';

            // 소수점 자리수 제한
            const decimals = window.APP_AMOUNT_DECIMALS; // .env 설정에서 가져옴

            if (decimalPart.length > decimals) {
                decimalPart = decimalPart.substring(0, decimals);
            }

            integerPart = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ','); // 3자리 콤마

            let formattedValue = integerPart;
            if (decimals > 0) {
                if (parts.length > 1) {
                    formattedValue += '.' + decimalPart;
                } else if (blur) {
                    formattedValue += '.' + '0'.repeat(decimals); // blur 시 .00 추가
                }
            } else { // 정수만 허용하는 경우
                formattedValue = integerPart;
            }
            
            input.value = formattedValue;
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.logout-link').forEach(function(el) {
                el.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('logout-form').submit();
                });
            });

            // brand-link 동적 리디렉션
            const brandLink = document.querySelector('.brand-link');
            const userLevel = {{ Auth::check() ? Auth::user()->level : 0 }}; // 로그인 안 했으면 0

            let redirectUrl = '/'; // 기본적으로 일반 사용자 홈

            if (userLevel >= 10) {
                redirectUrl = '{{ route('admin.dashboard') }}';
            } else if (userLevel >= 3 && userLevel <= 9) {
                redirectUrl = '{{ route('partner.dashboard') }}';
            } else if (userLevel >= 1 && userLevel <= 2) {
                redirectUrl = '/mypage'; // 보조사용자/사용자
            }
            // level 0은 로그인 시 리디렉션되므로 여기서는 고려하지 않음

            if (brandLink) {
                brandLink.setAttribute('href', redirectUrl);
            }
        });
    </script>
@stop

{{-- === 여기에 로그아웃 폼을 추가합니다 === --}}
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
{{-- === 로그아웃 폼 추가 끝 === --}}
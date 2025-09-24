{{-- resources/views/layouts/admin_layout.blade.php --}}
<!DOCTYPE html>
<html lang="ko"> {{-- 한글 전용 --}}
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>BLOCK BET 관리자</title>

	<!-- Font Awesome for Icons (아이콘 사용을 위해 추가) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40JuKmWvdfyBqfKx2l+Hh4tPNY+S0VpB6yT6z/sQvM8e9S0+N5t+kC5x5j4A7b7bQ4Yg5V5V5Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
	<!-- Google Fonts: Noto Sans KR -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:300,400,500,600,700&display=swap">
	
    <!-- Custom Admin CSS -->
    <link rel="stylesheet" href="{{ asset('/css/admin.css') }}" type="text/css"> {{-- admin.css 로드 --}}

	<!-- JS -->
	<script src="{{asset('/js/jquery-3.4.1.min.js')}}"></script>
	{{-- common.js는 alertPop, confirmPop 등 필요한 경우만 포함 --}}
	<script src="{{asset('/js/common.js')}}"></script> 

    @stack('head_scripts')
</head>
<body>
<!-- 전체 컨테이너 -->
<div class="admin-wrapper">
    <div class="admin-sidebar">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}"><img src="{{asset("/img/favicon.png")}}" alt="BLOCK BET Logo"></a>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"><i class="fas fa-tachometer-alt"></i> 관리자 대시보드</a></li>
            <li><a href="{{ route('admin.users') }}" class="{{ Request::routeIs('admin.users') ? 'active' : '' }}"><i class="fas fa-users"></i> 사용자 관리</a></li>
            <li><a href="{{ route('admin.transfers') }}" class="{{ Request::routeIs('admin.transfers') ? 'active' : '' }}"><i class="fas fa-exchange-alt"></i> 토큰 전송 내역</a></li>
            <li><a href="{{ route('admin.balances') }}" class="{{ Request::routeIs('admin.balances') ? 'active' : '' }}"><i class="fas fa-wallet"></i> 입출금 내역</a></li>
            <li><a href="{{ route('admin.points') }}" class="{{ Request::routeIs('admin.points') ? 'active' : '' }}"><i class="fas fa-money-check-alt"></i> 포인트 내역</a></li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i> 로그아웃</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    <div class="admin-main-content">
        <div class="admin-header">
            <h1 class="header-title">관리자 대시보드</h1> {{-- 헤더 타이틀 --}}
            <div class="user-info">
                <span>안녕하세요, <span class="user-name">{{ Auth::user()->name }}</span> 님!</span>
            </div>
        </div>
        @yield('content')
    </div>
</div>

<script>
// 어드민 전용 JavaScript (alertPop, confirmPop 등이 common.js에 있다면 이 함수들은 여기서 사용 가능)
function logout() {
    confirmPop('icon-ask', '로그아웃 하시겠습니까?', '로그아웃', '취소', function() {
        document.getElementById('logout-form').submit();
    });
}

// alertPop과 confirmPop이 common.js에 정의되어 있지 않거나 충돌한다면 여기에 직접 정의할 수 있습니다.
// 예시:
function alertPop(icon, message, callback) {
    alert(message); // 단순 alert로 대체
    if(callback) callback();
}
function confirmPop(icon, message, confirmText, cancelText, confirmCallback) {
    if(confirm(message)) {
        confirmCallback();
    }
}
</script>

@stack('scripts')
</body>
</html>
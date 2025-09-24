<nav class="menu">
	<button type="button" class="menuBtn" onclick="toggleMenu(this)"><span></span></button>
	<ul>
		<li><a href="/">@lang('INTRODUCTION')</a></li>
		<li><a href="/game/oddEven40">@lang('BLOCK BET')</a></li>
		@auth
		<li>		
			<button type="button" onclick="logout()">@lang('LOGOUT')</button>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>		
		</li>

		@if(Auth::user()->level > 0)
			<li><a href="/partner">@lang('PARTNER')</a></li>
			<li><a href="/transfer">@lang('TRANSFER HISTORY')</a></li>
		@endif 
		@else
		<li><a href="/login">@lang('LOGIN')</a></li>
		<li><a href="/register">@lang('SIGN UP')</a></li>
		@endauth
		<li><a href="javascript:void goMyPage()">@lang('MY PAGE')</a></li>
		<li><a href="javascript:void goMyTrade()">@lang('Deposit') / @lang('Withdrawal')</a></li>
		
	</ul>
	<div class="lang">
		<select onchange="javascript:void locale(this)">
			<option value="en">English</option>
			<option value="zh" @if(App::getLocale() === 'zh') selected @endif>中文</option>
			<option value="ko" @if(App::getLocale() === 'ko') selected @endif>한국어</option>
			<option value="ja" @if(App::getLocale() === 'ja') selected @endif>日本語</option>
			<!--option value="ru">русский</option-->
			<option value="vn" @if(App::getLocale() === 'vn') selected @endif>Tiếng Việt</option>
			<option value="my" @if(App::getLocale() === 'my') selected @endif>ไทย</option>
			<option value="bn" @if(App::getLocale() === 'bn') selected @endif>বাংলা</option>
		</select>
	</div>
	@auth
	<a href="/guide" class="guidePageBtn">@lang('Game Guide')</a>
	@endauth
</nav>




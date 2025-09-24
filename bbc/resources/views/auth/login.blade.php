@extends('layouts.app')

@section('body')

<div class="subWrap">

		<!-- 로그인 -->
		<div class="innerWrap loginWrap">
			<div class="loginBox">
				<p class="title effect-fadeDown">LOGIN</p>

				<form class="loginForm effect-fadeUp" method="POST" action="{{ route('login') }}">

                        @csrf
					<input type="text" name="email" class="id" placeholder="Email" value="{{ old('email') }}" required autocomplete="email" autofocus>
					@error('email')
						<span class="invalid-feedback" role="alert">
							<strong>{{ $message }}</strong>
						</span>
					@enderror
					<input type="password" class="pw" placeholder="Password" name="password" required autocomplete="current-password">

					<div class="btnArea">
						<button type="submit" class="loginBtn">LOGIN</button>
					</div>
				</form>

				<div class="flex find effect-fadeUp">
					<a href="find.html">@lang('Find ID/PW')</a>
					<a href="/register">@lang('Sign Up')</a>
				</div>
			</div>
		</div>

	</div> <!-- subWrap -->

@endsection

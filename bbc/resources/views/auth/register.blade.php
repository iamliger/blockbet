@extends('layouts.app')

@section('body')

<div class="subWrap">


    <!-- signup -->
    <div class="innerWrap signupWrap">
        <p class="subTitle effect-fadeDown">@lang('SIGN UP')</p>

        <form class="basicForm effect-fadeUp" method="POST" action="{{ route('register') }}">
            @csrf
            <label>
                <select class="countryName" name="country" required>
                    <option data-code="" value="">Select Country</option>
                    <option data-code="+1" value="USA" @if(App::getLocale() === 'en') selected @endif>USA</option>
                    <option data-code="+86" value="China" @if(App::getLocale() === 'zh') selected @endif>China</option>
                    <option data-code="+82" value="Rep. of Korea" @if(App::getLocale() === 'ko') selected @endif>Rep. of Korea</option>
                    <option data-code="+81" value="Japan" @if(App::getLocale() === 'ja') selected @endif>Japan</option>
                    <!--option data-code="" value="ru">русский</option-->
                    <option data-code="+84" value="Vietnam" @if(App::getLocale() === 'vn') selected @endif>Vietnam</option>
                    <option data-code="+60" value="Malaysia" @if(App::getLocale() === 'my') selected @endif>Malaysia</option>
                    <option data-code="+880" value="Bangladesh" @if(App::getLocale() === 'bn') selected @endif>Bangladesh</option>
                </select>
                @error('country')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
            <label>
                <input type="text" name="email" placeholder="@lang('Email address (must be entered correctly. We are not responsible for the disadvantages of different information.)')" required value="{{old('email')}}"
                    autocomplete="email" />
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
            <label>
                <input type="text" name="name" placeholder="@lang('User ID')" required value="{{old('name')}}"
                    autocomplete="name" />
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
            <label>
                <input type="password" placeholder="@lang('Password input (English numeral mix)')" name="password" required autocomplete="new-password" />
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
            <label>
                <input type="password" placeholder="@lang('Password again')" id="password-confirm" name="password_confirmation"
                    autocomplete="new-password" required />
            </label>

            <label>
				<div style="display:flex;">
					<input type="text" class="countryCode" value="" disabled style="width:60px;margin-right:5px;" />
					<input type="tel" class="phone" placeholder="@lang('Enter mobile phone number (Please enter the correct information). If the information is different, we will not be responsible for the damage.')" name="mobile"  value="{{old('mobile')}}" required />
				</div>
                @error('mobile')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>

			<!--
            <label>
                <input type="text" placeholder="input your Bank Name " name="swift" value="{{old('swift')}}" required />
                @error('swift')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
            <label>
                <input type="text" placeholder="input user Bank Account Number" name="iban" value="{{old('iban')}}" required />
                @error('iban')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
            <label>
                <input type="text" placeholder="Input Bank Account" name="account" value="{{old('account')}}" required />
                @error('account')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>
			 -->

            <label>
                <input type="text" name="recommander" placeholder="@lang('Recommended ID input (If there is no recommender, you cannot sign up)')" value="{{old('recommander')}}" autocomplete="name" />
                @error('recommander')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </label>

            <div class="btnArea" style="margin-top:2em">
                <button type="button" class="btn brown" onclick="otexSignUp()">@lang('SIGN UP')</button>
            </div>

        </form>

    </div>

</div> <!-- subWrap -->


@endsection

@push('scripts')
<script>
    const otexSignUp = () => {
        const email = $('[name=email]').val();
        const username = $('[name=name]').val();
        const password = $('[name=password]').val();
        const phoneNumber = $('[name=country] option:selected').attr('data-code') + $('[name=mobile]').val()

        signUp(email, username, password, phoneNumber).then(() => {
            $('form').submit();
        });

        return false;
    }

    function check() {
        // if the verification number is incorrect.
        //	alertPop('icon-error', 'The verification number is incorrect.');
    }

	// set phone country code
	function setCountryCode() {
		var code = $('.countryName option:selected').attr('data-code');
		$('.countryCode').val(code);
	}

	$(function() {
		$('.countryName').on('change', setCountryCode);
		setCountryCode();
	});


</script>
@endpush

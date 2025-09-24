@extends('layouts.app')

@section('body')


	<div class="subWrap">

		<!-- signup -->
		<div class="innerWrap signupWrap">
			<p class="subTitle effect-fadeDown">@lang('MY PAGE')</p>

			<!-- tab menu -->
			<div class="tabMenu tab2 effect-fadeUp">
				<button type="button" class="tab current" onclick="selectTab(this, 1)">@lang('Basic Information')</button>
				<button type="button" class="tab" onclick="selectTab(this, 2)">@lang('Favorite Wallets')</button>
			</div>

			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<!-- tabbody 1 -->
			<form class="basicForm tabBody tabBody1" onsubmit="check1();return false;">

				<label>
					<p class="text">@lang('Country')</p>
					<p class="value">{{Auth::user()->country}}</p>
				</label>
				<label class="">
					<p class="text">@lang('Email')</p>
					<p class="value">{{Auth::user()->email}}</p>
				</label>

				<label class="">
					<p class="text">@lang('Nickname')</p>
					<p class="value">{{Auth::user()->name}}</p>
				</label>


				<label class="editable">
					<p class="text">@lang('Password')</p>
					<input type="password" required />
				</label>
				<label class="editable">
					<p class="text">@lang('Password Confirmed')</p>
					<input type="password" required />
				</label>	
			
				<label>
					<p class="text">@lang('My Level')</p>
					<p class="value">{{Auth::user()->level}}</p>
				</label>
				@if(Auth::user()->point > 0)
				<label>
					<p class="text">@lang('My Point')</p>
					<p class="value">{{Auth::user()->point}}</p>
				</label>
				@endif

				<!-- 
				<label>
					<p class="text">@lang('Bank')</p>
					<p class="value">{{Auth::user()->swift}}</p>
				</label>
				<label>
					<p class="text">@lang('Account Number')</p>
					<p class="value">{{Auth::user()->iban}}</p>
				</label>

				<label>
					<p class="text">@lang('Account')</p>
					<p class="value">{{Auth::user()->account}}</p>
				</label>
				 -->

				<label>
					<p class="text">@lang('BBT Address')</p>
					<p class="value">0x{{Auth::user()->address}}</p>
				</label>

				<label>
					<p class="text">@lang('OTEX Address')</p>
					<p class="value">0x{{Auth::user()->otex}}</p>
				</label>
				
				<div class="btnArea" style="margin-top:2em">
					<button type="submit" class="btn blue">@lang('Save Changes')</button>
				</div>

			</form> <!-- tabbody 1 -->


			<!-- tabbody 2 -->
			<form class="basicForm tabBody tabBody2" style="display:none" method="POST" action="{{ route('favorite.register') }}">
                @csrf
				
				<div class="addRow">
					<div class="wrap">
						<select name="cointype" class="coin" required>
							<option value="">Select Coin</option>
							<option value="BBT">BBT</option>							
						</select>
                        
						<label class="editable">
							<input name="note" type="text" class="alias"  value="{{old('note')}}" placeholder="Alias" required/>
                            
						</label>
					</div>
					<label class="editable">
						<input type="text" name="address" class="address" id="bbc" value="{{old('address')}}" placeholder="Wallet address" required/>
                                        
                                    
					</label>
					<div class="btnArea">
						<button type="submit" class="btn blue addBtn">+ Add</button>
					</div>
				</div>
				
				<table class="walletList">
					<tbody>
                        @foreach($list as $wallet)
						<tr>
							<td>{{$wallet->cointype}}</td>
							<td><p class="address">{{$wallet->address}}</p></td>
							<td><p class="alias">{{$wallet->note}}</p></td>
							<td><button type="button" class="removeBtn" onclick="delAddress('{{route('favorite.delete',['id'=>$wallet->id])}}')">Delete</button></td>
						</tr>
                        @endforeach
					</tbody>
				</table>

			</form> <!-- tabbody 2 -->

		</div>

	</div> <!-- subWrap -->

<form name="deleteFrm" method="post">
@csrf
</form>

@endsection

@push('scripts')

<script src="{{asset('/js/wallet-address-validator.min.js')}}"></script>
	<script>

		function selectTab(btn, num) {
			$(btn).addClass('current').siblings().removeClass('current');
			$('.tabBody').not('.tabBody'+num).hide();
			$('.tabBody'+num).show();
		}

		function verify() {
			var phone = $('.phone').val();
			if($.trim(phone) == '') {
				alertPop('icon-error', 'Please enter your mobile number.');
				return false;
			}
			alertPop('icon-check', phone +'<br><br>Verification number sent to your mobile number.<br>There may be a delay depending on the network conditions.');
			$('.verifyLabel').show();
		}


		function check1() {
			// if the verification number is incorrect.
			alertPop('icon-error', 'The verification number is incorrect.');
		}

		function delAddress(src) {
			confirmPop('icon-ask', 'Are you sure you want to delete?', 'Delete', 'Cancel', function() {
				// delete..
                deleteFrm.action = src;
                deleteFrm.submit(); 
			});
		}

		function check2() {
			var coinType = $('.addRow .coin').val();
			var address = $('.addRow .address').val();
			// KISC == ETH, BBC == ETH
			coinType = coinType == 'KISC' || 'BBT' ? 'ETH' : coinType;
			var valid = WAValidator.validate(address, coinType);
			if(!valid) {
				alertPop('icon-error', 'The address you entered is not a valid address.');
				return false;
			}
			// add..
		}


		// url에 주소가 포함되어 있으면 자주쓰는 주소 등록
		$(function() {
			selectTab(this, 1)
			var address = getURLParam('address');
			if(address) {
				$('.tabMenu .tab').eq(1).trigger('click');
				$('.addRow .address').val(address);
				$('.addRow .alias').focus();
			}
		});


	</script>

@endpush
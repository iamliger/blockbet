@extends('layouts.app')

@section('body')

	<!-- favorite address popup -->
	<div class="favoritePop">
		<div class="pop">
			<p class="title">Favorite Wallet Address</p>
			<ul>
				<!-- 스크립트로 채워짐 -->
			</ul>
			<div class="btnArea">
				<button type="button" class="closeBtn" onclick="closeFavorite()">CLOSE</button>
			</div>
		</div>
	</div>
	<div class="subWrap">

		<!-- signup -->
		<div class="innerWrap inoutWrap">
			<p class="subTitle effect-fadeDown">@lang('Deposit') &amp; @lang('Withdrawal')</p>

			<!-- my account -->
			<div class="accountBox effect-fadeUp">
				<p class="text">@lang("Current BBT Balance")</p>
				<div class="bbc">
					<p class="money"></p>
					<p class="unit">BBT</p>
				</div>
				<div class="usd">
					<p class="money"></p>
					<p class="unit">USD</p>
				</div>
				<p class="small">@lang('1BBT = 0.1 USD')</p>
			</div>


			<!-- tab menu -->
			<div class="tabMenu tab2 effect-fadeUp">
				<button type="button" class="tab current" onclick="selectTab(this, 1)">@lang('Deposit')</button>
				<button type="button" class="tab" onclick="selectTab(this, 2)">@lang('Withdrawal')</button>
			</div>


			<!-- tabbody 1 -->
			<div class="tabBody tabBody1 effect-fadeUp">
				<!-- visa -->
				<form action="{{Route('deposit')}}" method="post">
					@csrf
					<div class="inoutBox">
						<p class="big">@lang('My BBT Address.')</p>
						@auth
						<p class="address">0x{{Auth::user()->address}}</p>
						@else
						<p class="address"></p>
						@endauth
						<p class="small brown">* @lang('Please check your address carefully')</p>
						<div class="btnArea left">
							<button type="button" class="btn black" onclick="copyAddress(this)">@lang('Copy Address')</button>
						</div>
						<!--
						<div class="inputRow output half">

							<input type="number" class="amountInput deposit" name="amount" placeholder="@lang('Enter amount for deposit')"/>
							<p class="toExchange">
								<span>=</span>
								<span class="num"></span>
								<span>USD</span>
							</p>
							<button type="submit" class="btn brown" >@lang("Deposit")</button>
						</div>
						 -->

                    </div>
                </form>
                <!--div class="inoutBox">
                    <p class="big">블록벳토큰(BBC) 충전 주소</p>

                    <p class="small brown">* 블록벳 토큰으로 충전하면  변환없이 충전완료 됩니다.</p>
                    <div class="btnArea left">
                        <button type="button" class="btn black" onclick="showQR(this)">QR Code</button>
                        <button type="button" class="btn black" onclick="copyAddress(this)">Copy Address</button>
                    </div>
                </div-->
            </div>


            <!-- tabbody 2 -->
            <div class="tabBody tabBody2 effect-fadeUp" style="display:none">
            <!-- bbc
				<div class="inoutBox">
					<p class="big">@lang('My BBT Address.')</p>
					@auth
                <p class="address">0x{{Auth::user()->address}}</p>
					@else
                <p class="address"></p>
@endauth
                    <form action="{{Route('withdraw')}}" method="post" onsubmit="return frmWithdraw(this)">
					@csrf
                    <div class="inputRow output">
                        <input type="number" class="amountInput" name="amount" id="withdraw_amount" placeholder="@lang('Enter amount for withdraw')"/>
						<button type="submit" class="btn brown">@lang('Withdrawal')</button>
					</div>
					</form>
				</div>
				-->

                <!-- OTEX -->
                <div class="inoutBox">
                    <p class="big">@lang('OTEX my BBT Address.')</p>
                    <p id="otex-address" class="address"></p>
                    <p class="big" style="margin-top:10px;">@lang('Transmission quantity input to OTEX.')</p>
                    <form action="{{Route('withdraw.otex')}}" method="post" onsubmit="return frmWithdrawToOtex(this)">
                        @csrf
                        <input type="hidden" name="" value="">
                        <div class="inputRow output">
                            <input type="number" class="amountInput" name="otex_amount" id="withdraw_otex_amount"
                                   placeholder="@lang('Enter amount for withdraw')">
                            <button type="submit" class="btn brown">@lang('Withdrawal')</button>
                        </div>
                        <div class="btnArea flex between"
                             style="margin-top:20px;padding-top:20px;border-top:1px dashed #aaa;">
                            <p style="margin-bottom:10px;color:#e8bd71;">@lang('You can link OTEX and BBT addresses.')</p>
                            <button type="button" class="btn blue"
                                    onclick="showPopup()">@lang('Linking with OTEX')</button>
                        </div>
                    </form>
                </div>

                <!-- popup -->
                <div class="interLinkPop">
                    <div class="pop">
                        <p class="title">@lang('Linking OTEX and BBT addresses')</p>
                        <p class="text">@lang('BBT address of Otex-EX is automatically registered in Blockbet')</p>
                        <p class="text">@lang('Advantages: Secure withdrawal convenience with one click')</p>
                        <p class="text">@lang('Conditions: Install and sign up for PayBanC') (<a
                                    href="https://play.google.com/store/apps/details?id=io.bizblocks.kaiserbank"
                                    target="_blank">@lang('Google Play Store')</a>)</p>
                        <p class="text">
                            - @lang('After linking is complete, linking subscriptions are not created again.')</p>
                        <input name="otex-email" type="text" placeholder="@lang('Enter Otex EX email ID')">
                        <input name="otex-password" type="password" placeholder="@lang('Enter Otex EX password')">
                        <div class="btnArea">
                            <button type="button" class="btn blue"
                                    onclick="linkOtex()">@lang('Linking with OTEX')</button>
                            <button type="button" class="btn gray" onclick="closePopup()">@lang('Cancel')</button>
                        </div>
                    </div>
                </div>


                <!-- any address -->
                <div class="inoutBox">
                    <p class="big">@lang('BBT address to send.')</p>
                    <form action="{{Route('withdraw.user')}}" method="post" onsubmit="return frmWithdrawToUser(this)">
                        @csrf
                        <div class="inputRow output">
                            <input type="text" class="amountInput" name="name" value="{{old('name')}}">
                        </div>
                        <div class="inputRow output">
                            <input type="number" class="amountInput" name="user_amount" id="withdraw_user_amount"
                                   placeholder="@lang('Enter amount for withdraw')">
                            <button type="submit" class="btn brown">@lang('Withdrawal')</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- history -->
            <div class="inoutHistory effect-fadeUp">
                <p class="title">{{ __('History') }}</p> <!-- 수정 -->
                <div class="searchArea">
                    <div class="left">
                        <select>
                            <option>{{ __('All Type') }}</option> <!-- 수정 -->
                            <option>{{ __('Deposit') }}</option> <!-- 수정 -->
                            <option>{{ __('Withdrawal') }}</option> <!-- 수정 -->
                        </select>
                        <select>
                            <option>{{ __('All Coin') }}</option> <!-- 수정 -->
                            <option>BBT</option> <!-- 코인명은 고정일 수 있음 -->
                        </select>
                    </div>
                    <div class="right">
                        <button type="button" class="searchBtn" onclick=""></button>
                    </div>
                </div>
                <div class="tableWrap">
                    <table>
                        <thead>
                        <tr>
                            <th>{{ __('Type') }}</th> <!-- 수정 -->
                            <th>{{ __('tid') }}</th> <!-- tid는 고정일 수 있음 -->
                            <th>{{ __('Coin') }}</th> <!-- 수정 -->
                            <th>{{ __('Amount') }}</th> <!-- 수정 -->
                            <th>{{ __('Target') }}</th> <!-- 수정 -->
                            <th>{{ __('DateTime') }}</th> <!-- 수정 -->
                            <th>{{ __('Status') }}</th> <!-- 수정 -->
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($list as $item)
                            <tr>
                                @if($item->type === 1)
                                    <td class="blue">{{ __('Deposit') }}</td> <!-- 수정 -->
                                @elseif($item->type === -1)
                                    <td class="red">{{ __('Withdrawal') }}</td> <!-- 수정 -->
                                @else
                                    <td class="red"></td>
                                @endif
                                <td>{{$item->tid}}</td>
                                <td>BBT</td>
                                <td>
                                    @php
                                        $ll = explode(".",$item->amount);
                                        echo number_format($ll[0]);
                                        if(sizeof($ll) > 1){
                                            echo ".".$ll[1];
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @if($item->balance_type == 'user')
                                        {{$item->account}}
                                    @elseif($item->balance_type == 'otex')
                                        otex
                                    @else
                                    @endif
                                </td>
                                <td>{{$item->created_at}}</td>
                                <td>
                                    @if($item->status == 'R')
                                        {{ __('Requested') }} <!-- 수정 -->
                                    @elseif($item->status == 'F')
                                        {{ __('Completed') }} <!-- 수정 -->
                                    @elseif($item->status == 'W')
                                        {{ __('Processing') }} <!-- 수정 (W는 원래 Processing으로 보임) -->
                                    @elseif($item->status == 'C')
                                        {{ __('Cancelled') }} <!-- 수정 -->
                                    @else
                                        {{$item->status}} ({{ __('Ask for administrator') }}) <!-- 수정 -->
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{$list->links()}}
            </div>

        </div>

    </div> <!-- subWrap -->

@endsection

@push('scripts')

    <script src="{{asset('/js/qrcode.min.js')}}"></script>
    <script src="{{asset('/js/wallet-address-validator.min.js')}}"></script>
    <script src="{{asset('/js/wallet-address-validator.min.js')}}"></script>
    <script>
        function linkOtex() {
            const email = $("[name=otex-email]").val();
            const password = $("[name=otex-password]").val();
            const address = '0x{{Auth::user()->address}}';

            connectBetBBT(email, password, 'BBT', address)
                .then(({data}) => {
                    const {address} = data.connectBetBBT;
                    alertPop("icon-check", "@lang('It has been successfully linked.')", () => {
                        location.reload();
                    })
                })
                .catch(() => {
                    alertPop("icon-check", "@lang('Link failed.')");
                });
        }
        
        $(() => {
            getWalletForBetBBT('{{Auth::user()->email}}')
                .then(({data}) => {
                    $('#otex-address').text(data.getWalletForBetBBT.address);
                });
        });


        let original_balance = 0;
        $(function () {
            $(".amountInput").on("keypress keyup blur", function (event) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                if ((event.which < 48 || event.which > 57)) {
                    event.preventDefault();
                }
                if ($(this).hasClass('deposit')) $('.toExchange .num').text(numeral($(this).val()).format("0,0.0[0000000]"));
            });
        });

        function selectTab(btn, num) {
            $(btn).addClass('current').siblings().removeClass('current');
            $('.tabBody').not('.tabBody' + num).hide();
            $('.tabBody' + num).show();
        }

        // 변환하기
        function exchange(btn) {
            $(btn).parents('.inoutBox').find('.inputRow').css('display', 'flex').find('input').focus();
        }

        // QR
        function showQR(btn) {
            var address = $(btn).parents('.inoutBox').find('.address').text();
            var pop = '<div class="qrPop">\
							<div class="pop">\
								<div id="qr"></div>\
								<p class="address">' + address + '</p>\
								<button type="button" class="closeBtn" onclick="closeQR()">CLOSE</button>\
							</div>\
						</div>';
            $('body').append(pop);
            var qrCode = new QRCode(document.getElementById('qr'), {
                text: address,
                width: 180,
                height: 180
            });
            //qrCode.clear();
            qrCode.makeCode(address);
        }

        function closeQR() {
            $('.qrPop').remove();
        }

        // 주소복사
        function copyAddress(btn) {
            var address = $(btn).parents('.inoutBox').find('.address').text();
            var temp = $("<input style='position:absolute;top:-100%' />").val(address);
            temp.appendTo("body");
            temp.select();
            document.execCommand("copy");
            temp.remove();
            alertPop('icon-check', 'Address copied to clipboard.');
        }


        // 자주쓰는 주소 선택
        function openFavorite(btn) {

            var addressInput = $(btn).parents('.inoutBox').find('.addressInput');
            var pop = $('.favoritePop');
            var list = pop.find('ul').empty();

            _tempAddress.forEach(function (obj) {
                var li = $('<li>\
								<div class="row">\
									<p class="alias">' + obj.alias + '</p>\
									<button type="button">Select</button>\
								</div>\
								<p class="address">' + obj.address + '</p>\
							</li>');
                // set select button event
                li.find('button').on('click', function () {
                    var address = $(this).parents('li').find('.address').text();
                    addressInput.val(address);
                    closeFavorite();
                });
                list.append(li);
            });
            pop.css('display', 'flex');
        }

        function closeFavorite() {
            $('.favoritePop').hide();
        }


        function frmWithdraw(frm) {
            var amount = $("#withdraw_amount").val();

            if (original_balance < amount) {
                alertPop('icon-error', 'Not enough BBT');
                return false;
            }

            return true;
        }

        function frmWithdrawToOtex(frm) {
            var amount = $("#withdraw_otex_amount").val();

            if (original_balance < amount) {
                alertPop('icon-error', 'Not enough BBT');
                return false;
            }

            return true;
        }

        function frmWithdrawToUser(frm) {
            var amount = $("#withdraw_user_amount").val();

            if (original_balance < amount) {
                alertPop('icon-error', 'Not enough BBT');
                return false;
            }

            return true;
        }

        // withdraw
        function withdraw(btn) {
            var address = $(btn).parents('.inoutBox').find('.addressInput').val();
            var amount = $(btn).parents('.inoutBox').find('.amountInput').val();

            if (original_balance < amount) {
                alertPop('icon-error', 'Not enough BBT');
                return false;
            }
            if (address == '') {
                alertPop('icon-error', 'Please enter an address to deposit.');
                return false;
            }
            if (amount == '') {
                alertPop('icon-error', 'Please enter an amount to withdraw.');
                return false;
            }
            var msg = '<span style="width:100%;margin-bottom:1em;border-top:1px solid #777;"></span>\
					<span style="width:100%;font-size:0.9em;text-align:center">Address</span><br>\
					<span style="width:100%;font-size:0.9em;text-align:center;color:#2956af">' + address + '</span><br>\
					<span style="width:100%;font-size:0.9em;text-align:center">Amount</span><br>\
					<span style="width:100%;font-size:0.9em;text-align:center;color:#2956af">' + amount + '</span>\
					<span style="width:100%;margin:1em 0;border-top:1px solid #777;"></span>';
            confirmPop('icon-ask', msg + '<br><br>Please make sure the address and amount you entered are correct.<br>If you click withdrawal, it cannot be reversed.', 'Withdraw', 'Cancel', function () {
                // 잔액이 부족할 경우
                if (false) {
                    alertPop('icon-error', 'Not enough balance.');
                } else {
                    // 이후 전송 처리..

                    // 자주쓰는 주소 목록에 없는 주소일 경우 등록 여부 묻기
                    var arr = _tempAddress.filter(function (obj) {
                        return obj.address == address;
                    });
                    if (arr.length == 0) {
                        goFavorite(address);
                    }
                }
            });
        }

        // goto favorite
        function goFavorite(address) {
            confirmPop('icon-ask', address + '<br><br>Would you like to register this address as a favorite?', 'Register', 'Cancel', function () {
                location.href = 'mypage.html?address=' + address;
            });
        }

        // show popup
        function showPopup() {
            $('.interLinkPop').css('display', 'flex');
        }

        function closePopup() {
            $('.interLinkPop').hide();
        }

    </script>
    @auth
        <script>
            $(function () {
                function request() {

                    $.get('{{config("app.balance",'')}}/0x{{Auth::user()->address}}?t=' + (new Date()).getTime(), (data) => {
                        $('.bbc .money').text(numeral(data.balance).format("0,0.0[0000000]"));
                        $('.usd .money').text(numeral(data.balance).format("0,0.0[0000000]"));
                        original_balance = data.balance;
                    });
                    setTimeout(() => {
                        request()
                    }, 2000);
                }

                request();

            })
        </script>
    @endauth
@endpush

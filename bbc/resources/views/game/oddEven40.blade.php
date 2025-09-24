@extends('layouts.app')

@section('body')
<!-- 메인 컨텐츠 -->
	<div class="mainContent">


		<!-- topArea -->
		<div class="topArea">
			<!-- login -->
			<p class="userName">ID: @auth {{Auth::user()->name}} @else Guest @endauth </p>
			<!-- logout
			<a href="login.html"><p class="userName">LOGIN</p></a>
			-->

			<p class="gameSpeed">@lang('40 Seconds Game')</p>

			<a href="#none" class="otex">
				<p><img src="/img/icon_otex.svg"><span>Exchange</span></p>
			</a>
		</div>

		<!-- 왼쪽 또는 위쪽 영역 -->
		<section class="leftArea codeWrap">
			<p class="title"><span class="hasGuideBtn padding">@lang('HyperAiser RealTime Block')<button type="button" class="guideBtn" onclick="popGuide(0)">?</button></span></p>
			<div class="hashArea">
				<div class="head">
					<span class="th hasGuideBtn padding">@lang('Block Number') <button type="button" class="guideBtn" onclick="popGuide(1)">?</button></span>
					<span class="th hasGuideBtn padding">@lang('Block Hash') <button type="button" class="guideBtn" onclick="popGuide(2)">?</button></span>
					<span class="th hasGuideBtn padding">@lang('Hash Result') <button type="button" class="guideBtn" onclick="popGuide(3)">?</button></span>
				</div>
				<ul class="hashList">
					<!-- 임시 스크립트로 채워짐 -->
				</ul>
				<p class="rotateBlock"></p>
			</div>
		</section> <!-- leftArea -->


		<!-- 중앙 영역 -->
		<section class="centerArea">
			<!-- 게임 탭메뉴 -->
						@include('includes.gameTab40')

			<!-- 점수판 -->
			<div class="scoreBox">
				<div class="title">
					<p>@lang('ROLL UNDER TO WIN')</p>
					<p>@lang('PAYOUT')</p>
					<p>@lang('WIN CHANCE')</p>
				</div>
				<div class="score">
					<p><span class="score1">50</span></p>
					<p><span class="score2">1.95</span><b>x</b></p>
					<p><span class="score3">50</span><b>%</b></p>
				</div>
			</div>

			<!-- 게이지 -->
			<div id="gauge" class="gaugeInput">
				<div class="row">
					<p class="bg left"></p>
					<p class="bg right"></p>
					<p class="bar ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content ui-slider-disabled ui-state-disabled">
						<span tabindex="0" class="ui-slider-handle ui-corner-all ui-state-default">
							<b class="value"></b>
						</span>
					</p>
					<div class="text"><span>0</span><span>100</span></div>
				</div>
			</div>

			<!-- 결과값들 -->
			<div class="resultRow">
				<ul class="resultList">
					<!-- 스크립트로 채워짐 -->
				</ul>
			</div>

			<!-- 배팅 영역 -->
			<div class="bettingRow">
			<!-- Payout on Win -->
								<!-- 1st row -->
				<div class="row">
					<div class="col col1">
						<div class="box">
							<p class="title">@lang('Retained balance')</p>
							<div class="inputBox">
								<input type="tel" disabled id="inputMoney">
								<span class="unit">BBT</span>
							</div>
							<div class="inputBox">
								<input type="tel" disabled id="input_balance">
								<select class="unit" id="input_currency">
									<option value="USD">USD</option>
									<option value="KRW">KRW</option>
									<option value="CNY">CNY</option>
								</select>
							</div>
						</div>
						<div class="box">
							<p class="title">@lang('Bet amount')</p>
							<div class="inputBox hasClear">
								<input type="tel" id="amount">
								<span class="unit">BBT</span>
								<button type="button" class="clearBtn" onclick="clearAmountInput(this)"></button>
							</div>
							<div class="inputBox hasClear">
								<input type="tel" id="currency_balance">								
								<button type="button" class="clearBtn" onclick="clearCurrencyInput(this)"></button>
							</div>
						</div>
					</div>

					<div class="col col2 betBtn">
						<button type="button" onclick="javascript:void setAmount(10)">10 BBT</button>
						<button type="button" onclick="javascript:void setAmount(50)">50 BBT</button>
						<button type="button" onclick="javascript:void setAmount(100)">100 BBT</button>
						<button type="button" onclick="javascript:void setAmount(500)">500 BBT</button>
						<button type="button" onclick="javascript:void setAmount(1000)">1,000 BBT</button>
					</div>

					<div class="col col3">
						<div class="box">
							<p class="title">@lang('Betting Time Remains')</p>
							<div class="bettingTime">
								<div class="border">
									<p class="bar">10</p>
									<p class="bar">9</p>
									<p class="bar">8</p>
									<p class="bar">7</p>
									<p class="bar">6</p>
									<p class="bar">5</p>
									<p class="bar">4</p>
									<p class="bar">3</p>
									<p class="bar">2</p>
									<p class="bar">1</p>
									<p class="end">@lang('Betting Time Over!!')</p>
								</div>
							</div>
						</div>
						<div class="box">
							<p class="title">@lang('Payout on Win')</p>
							<div class="">
								<div class="inputBox" style="width:100%;">
									<input type="tel" disabled id="payout2win">
									<span class="unit">BBT</span>
								</div>
							</div>
						</div>
					</div>
				</div>


				<div class="btnArea">
					<button type="button" class="halfBtn blue" onclick="bet(3)">@lang('ODD BETTING')</button>
					<button type="button" class="halfBtn red" onclick="bet(2)">@lang('EVEN BETTING')</button>
				</div>
				
			</div>

			<!-- 히스토리 -->
			<div class="historyArea">
				<div class="btnArea">
					<button type="button" class="historyBtn" onclick="toggleHistory(this)">@lang('History')</button>
				</div>
				<div class="innerWrap">
					<!-- 바둑판 -->
					<div class="gridBox">
						<ul class="swiper-wrapper">
							<!-- 스크립트로 채워짐 -->
						</ul>
					</div>
					<!-- 우측영역 -->
					<div class="summaryBox">						
						<div class="row">
							<p class="left">@lang('Average of') <b class="red"></b></p>
							<p class="right"><span class="aveRed">0%</span></p>
						</div>
						<div class="row">
							<p class="left">@lang('Average of') <b class="blue"></b></p>
							<p class="right"><span class="aveBlue">0%</span></p>
						</div>
						<div class="row">
							<p class="left">@lang('Max Sequence of') <b class="red"></b></p>
							<p class="right"><span class="seqRed">0</span></p>
						</div>
						<div class="row">
							<p class="left">@lang('Max Sequence of') <b class="blue"></b></p>
							<p class="right"><span class="seqBlue">0</span></p>
						</div>
					</div>
				</div>
			</div>

		</section> <!-- centerArea -->


		<!-- 오른쪽 또는 하단 영역 -->
		<section class="rightArea">
			<!-- 탭메뉴 -->
			<div class="recordTab">
				<button type="button" class="tabBtn current" onclick="recordTab(this)">@lang('All Bet')</button>
				<button type="button" class="tabBtn" onclick="recordTab(this)">@lang('My Bet')</button>				
			</div>

			<!-- 제목줄 -->
			<div class="head">
				<div class="text">
					<p>@lang('Block No.')</p>
					<p>@lang('Player')</p>
					<p>@lang('Guess/Roll')</p>
					<p>@lang('Bet/Payout')</p>
					<p>@lang('Status')</p>
				</div>
				<div class="hasGuideBtn padding">@lang('Result')<button type="button" class="guideBtn" onclick="popGuide(8)">?</button></div>
			</div>

			<!-- 각 탭 내용 -->
			<div class="recordWrap">

				<!-- all bet -->
				<div class="record" id="allBet">					
				</div>

				<!-- My Bet -->
				<div class="record" id="myBet">					
				</div>


			</div>
		</section>


	</div> <!-- mainContent -->

	
@endsection

@push('scripts')
	
    <link rel="stylesheet" href="/css/jquery-ui.min.css" type="text/css">
<script>
		var result_url = '{{config("app.gameResult",'')}}';
	</script>
    <script src="/js/jquery-ui.min.js"></script>
    <script src="/js/common.js"></script>
	<script src="/js/game4.js"></script>
	<script src="/js/guide-data.js"></script>	
	<script>
		$(function(){
			$.get(result_url+'/oddeven40/init',(data)=>{
				for(let x = data.length-1;x>=0;x--){
					let block = data[x];
					addHash(block.blocknumber, block.blockhash, block.result);
					addGrid();
					$(window).trigger('resize');
				}				
			});

			function diceresult(){
			$.get('/api/oddeven40/result?t='+(new Date()).getTime(),(data)=>{
				if(data){
					$('#allBet').empty();
					for(let x in data){
						let bet = data[x];

						let pick = '@lang('ODD')';
						if(bet['pick']%2 == 0) pick="@lang('EVEN')";

						let color = "";
						let result='<p class="state"></p>';
						if(bet['status'] === 'L') color="purple"
						else if(bet['status'] === 'W') {
							color="green";
							result='<p class="state">@lang('Win')</p>';
						}
						let child = $(`<a href="#none" class="${color}">
							<p class="block">${bet['blockNumber']}</p>
							<p class="user">${bet['name']}</p>
							<p class="guess">${pick}&gt;${bet['result']}(${bet['rate']}x)</p>
							<p class="bet">${bet['amount']} <span class="plus">(+${bet['result_amount']})</span></p>
							${result}
						</a>`);

						$('#allBet').append(child);						
					}
				}
			});			

				setTimeout(()=>{diceresult()},2000);
			}
			diceresult();
		})
	</script>
	@auth
	<script>
	let original_balance = 0;
	let betting_percent = 0;
	let pick_rate = 1.95;
	let USD_KRW = 120;
	let BBC_USD = 0.1;
	let betting_enable = false;
	let api_token = '{{Auth::user()->api_token}}';

	function clearAmountInput(self){
		$('#amount').val(0);
		change_currencyBalance(0);
		update_payoutToWin(0);
	}

	function clearCurrencyInput(self){
		$('#currency_balance').val(0);
		$('#amount').val(0);
		update_payoutToWin(0);
	}

	$(function(){
		$('#amount').on('input',function(e){
			let dInput = this.value;
			change_currencyBalance(dInput);
			update_payoutToWin(dInput);
		}).change(()=>{
			let val = $('#amount').val() ?? 0;				
			change_currencyBalance(val);
		});

		$('#currency_balance').on('input',function(){
			let dInput = this.value;	
			let currency = $('#input_currency').val();
			let rate = BBC_USD;
			if(currency === 'KRW') rate = USD_KRW;

			val = parseFloat(numeral(dInput / rate).format("0.0[000]"));
			$("#amount").val(val);
			update_payoutToWin(val);
		});

		$('#input_currency').change(function(e){
				let currency = $('#input_currency').val();
				let rate = BBC_USD;
				if(currency === 'KRW') rate = USD_KRW;

		
				if(!isNaN(original_balance)){
					$('#input_balance').val(original_balance*rate);
					let val = $('#amount').val() ?? 0;				
					change_currencyBalance(val);
				}			
			
		});
	})	

	function update_payoutToWin(val){
		$('#payout2win').val(numeral(val*pick_rate).format("0,0.0[000]"));
	}

	function change_currencyBalance(val){
		let currency = $('#input_currency').val();
		let rate = BBC_USD;
		if(currency === 'KRW') rate = USD_KRW;
		
		if(!isNaN(val)){							

			$('#currency_balance').val(val*rate);
		}else{
			$('#currency_balance').val(0);
		}
	}

	function maxBalance(){
		$('#amount').val(original_balance);	
		change_currencyBalance(original_balance);
	}

	function bet(pick){		
		let amount = $('#amount').val();

		if(!betting_enable){
			alertPop('icon-error', 'Cannot bet in time.');
			return ;
		}

		if(isNaN(amount)){ 			
			return ;			
		}

		if(amount <= 0){ 			
			alertPop('icon-error', 'please input over 0 BBT');
			return ;			
		}
		
		let pickString = (pick === 2 ? 'Even':'Odd');
		if(!confirm(`really betting ${amount} at ${pickString}`)) return;
		

			if(original_balance < amount){
				alertPop('icon-error', 'Not enough BBT');
				return ;
			}

			if(amount*1e8%100 > 0){
				alertPop('icon-error', 'Cannot Betting 0.000001 Under');
				return ;
			}

			$.post("/api/betting",{api_token:api_token,game:'oddeven40',pick:pick,amount:amount,rate:1.95},(data)=>{
				alertPop('icon-error', data.message);
				
			});
		
	}

	$(function(){		
		 $("#amount").on("keypress keyup blur",function (event) {
            //this.value = this.value.replace(/[^0-9\.]/g,'');
     		$(this).val($(this).val().replace(/[^0-9\.]/g,''));
						
            if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }

			if($(this).val().length > 0 && !/^[0-9]+(\.[0-9]{0,3})?$/.test($(this).val())){
				event.preventDefault();
			}
        });

		function diceresult2(){
			$.get(`/api/oddeven40/myresult?api_token=${api_token}&t=`+(new Date()).getTime(),(data)=>{
				if(data){
					$('#myBet').empty();
					for(let x in data){
						let bet = data[x];
						let pick = '@lang('ODD')';
						if(bet['pick']%2 == 0) pick="@lang('EVEN')";

						let color = "";
						let result='<p class="state"></p>';
						if(bet['status'] === 'L') color="purple"
						else if(bet['status'] === 'W') {
							color="green";
							result='<p class="state">@lang('Win')</p>';
						}
						let child = $(`<a href="#none" class="${color}">
							<p class="block">${bet['blockNumber']}</p>
							<p class="user">${bet['name']}</p>
							<p class="guess">${pick}&gt;${bet['result']}(${bet['rate']}x)</p>
							<p class="bet">${bet['amount']} <span class="plus">(+${bet['result_amount']})</span></p>
							${result}
						</a>`);

						$('#myBet').append(child);						
					}
				}
			});			

				setTimeout(()=>{diceresult2()},2000);
			}
			diceresult2();
		let prevBlocked = -1;
		function request(){		
			
			$.get('{{config("app.balance",'')}}/0x{{Auth::user()->address}}?t='+(new Date()).getTime(),(data)=>{
				$('.totalMoney .money').text(numeral(data.balance).format("0,0.0[0000000]"));
				$('#inputMoney').val(numeral(data.balance).format("0,0.0[0000000]"));
				let ic = $('#input_currency').val();
				let rate = BBC_USD;
				if(ic === 'KRW'){
					rate = USD_KRW;										
				}				
				
				original_balance = data.balance;

				if(!isNaN(original_balance)){
					$('#input_balance').val(numeral(original_balance*rate).format("0,0.0[0000000]"));
				}
			});

			$.get('{{config("app.balance",'')}}/../block?t='+(new Date()).getTime(),(data)=>{
				let _blockNumber = data.blockNumber;
				let block = _blockNumber%15;
				let rate = 0;

				if(prevBlocked < 0){
					for(i=0;block > i ; i++){
						var bar = $('.bettingTime .bar').not(':hidden');
						bar.first().hide();
					}					
				}
				
				if(prevBlocked != block){					
					console.log('block',block);
					if(block >= 10){
						var bar = $('.bettingTime .bar').not(':hidden');
						bar.first().hide();
						betting_enable = false;
						bettingTimeout();
					}
					else if(block === 0) {		
						betting_enable = true;			
						$('.bettingRow .btnArea button').prop('disabled', false);
						$('.bettingTime .bar').not(':last-child').show();
						$('.bettingTime .bar').removeClass('red');
						var timeOver = $('.bettingTime .border .end');
						timeOver.css('display', 'none');
					}
					else{
						betting_enable = true;
						$('.bettingRow .btnArea button').prop('disabled', false);
						var bar = $('.bettingTime .bar').not(':hidden');
						bar.first().hide();
						var timeOver = $('.bettingTime .border .end');
						timeOver.css('display', 'none');
						if(bar.length <= 5) {
							bar.addClass('red');
						}
					}				

					prevBlocked = block;
				}
			});

			setTimeout(()=>{request()},2000);
		}

		request();
		
	})

	function setAmount(amount){		
		$('#amount').val(amount);
		change_currencyBalance(amount);
		update_payoutToWin(amount);
	}
	</script>
	@endauth
@endpush

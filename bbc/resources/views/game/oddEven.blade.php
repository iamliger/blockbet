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
						@include('includes.gameTab')

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
				<div class="inputCol">
					<div class="inputBox">
						<p class="title">@lang('Retained balance')</p>
						<input type="tel" disabled id="inputMoney">
						<span class="unit">BBT</span>
					</div>
				</div>				
				
				<!-- Bet amount -->
				<div class="inputCol">
					<div class="inputBox">
						<p class="title">@lang('Bet amount')</p>
						<input type="number" id="amount" placeholder="0.0" min="0">
						<span class="unit">BBT</span>
						<button type="button" class="clearBtn" onclick="clearInput(this)"></button>
					</div>
					<div class="btnArea">
						<div class="currency">
							<select id="currency">
								<option value="USD">USD</option>
								<option value="KRW">KRW</option>
							</select>
							<p class="money" id="currency_balance">0</p>
						</div>
						<button type="button" class="xBtn" onclick="javascript:void maxBalance()">MAX</button>
					</div>
				</div>

				<div class="btnArea">
					<button type="button" class="halfBtn blue" onclick="bet(3)">@lang('ODD BETTING')</button>
					<button type="button" class="halfBtn red" onclick="bet(2)">@lang("EVEN BETTING")</button>
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
						<p class="title">@lang('Game Statistics')</p>
						<div class="row">&nbsp;
						</div>
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
	<script src="/js/game.js"></script>
	<script src="/js/guide-data.js"></script>	
	<script>
		$(function(){
			function diceresult(){
			$.get('/api/oddeven/result?t='+(new Date()).getTime(),(data)=>{
				if(data){
					$('#allBet').empty();
					for(let x in data){
						let bet = data[x];
						let pick = '@lang('ODD')';
						if(bet['pick']%2 == 0) pick="@lang('EVEN')";
						let color = "";
						if(bet['status'] === 'L') color="purple"
						else if(bet['status'] === 'W') color="green"
						let child = $(`<a href="#none" class="${color}">
							<p class="block">${bet['blockNumber']}</p>
							<p class="user">${bet['name']}</p>
							<p class="guess">${pick}&gt;${bet['result']}(${bet['rate']}x)</p>
							<p class="bet">${bet['amount']} <span class="plus">(+${bet['result_amount']})</span></p>
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
	let USD_KRW = 120;
	let BBC_USD = 0.1;
	let api_token = '{{Auth::user()->api_token}}';

	$(function(){
		$('#amount').on('input',function(){
			let dInput = this.value;			
			
			change_currencyBalance(dInput);
		});

		$('#currency').change(function(e){
			let dInput = $('#amount').val();					
			change_currencyBalance(dInput);
		});
	})	

	function change_currencyBalance(val){
		let currency = $('#currency').val();
		let rate = BBC_USD;
		if(currency === 'KRW') rate = USD_KRW;

		if(!isNaN(val)){							
			$('#currency_balance').text(numeral(val*rate).format("0,0.0[0000000]"));
		}else{
			$('#currency_balance').text(0);
		}
	}

	function maxBalance(){
		$('#amount').val(original_balance);	
		change_currencyBalance(original_balance);
	}

	function bet(pick){		
		let amount = $('#amount').val();
		if(isNaN(amount)){ 			
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

			$.post("/api/betting",{api_token:api_token,game:'oddeven',pick:pick,amount:amount,rate:1.95},(data)=>{
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
        });

		function diceresult2(){
			$.get(`/api/oddeven/myresult?api_token=${api_token}&t=`+(new Date()).getTime(),(data)=>{
				if(data){
					$('#myBet').empty();
					for(let x in data){
						let bet = data[x];
						let pick = '@lang('ODD')';
						if(bet['pick']%2 == 0) pick="@lang('EVEN')";
						let color = "";
						if(bet['status'] === 'L') color="purple"
						else if(bet['status'] === 'W') color="green"
						let child = $(`<a href="#none" class="${color}">
							<p class="block">${bet['blockNumber']}</p>
							<p class="user">${bet['name']}</p>
							<p class="guess">${pick}&gt;${bet['result']}(${bet['rate']}x)</p>
							<p class="bet">${bet['amount']} <span class="plus">(+${bet['result_amount']})</span></p>
						</a>`);

						$('#myBet').append(child);						
					}
				}
			});			

				setTimeout(()=>{diceresult2()},2000);
			}
			diceresult2();

		function request(){		
			
			$.get('{{config("app.balance",'')}}/0x{{Auth::user()->address}}?t='+(new Date()).getTime(),(data)=>{
				$('.totalMoney .money').text(numeral(data.balance).format("0,0.0[0000000]"));
				$('#inputMoney').val(numeral(data.balance).format("0,0.0[0000000]"));
				original_balance = data.balance;
			});
			setTimeout(()=>{request()},2000);
		}

		request();
		
	})
	</script>
	@endauth
@endpush

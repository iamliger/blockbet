@extends('layouts.app')

@section('body')
	<div class="mainWrap">

		<div class="gameTitle">
			<img src="{{asset('/img/img_blockbet.png')}}" />
		</div>


		<div class="innerWrap">
		<div class="itemList">
				<div class="item">
					<p class="title effect-fadeUp">40" @lang('BLOCK UNDER')</p>
					<div class="img effect-fadeUp">
						<img src="{{asset('/img/img_token1.png')}}" />
					</div>
					<div class="btnArea effect-fadeUp">
						<a href="/game/under40">START <span>(40 seconds)</span></a>
						<!-- 
						<a href="/game/under">START <span>(10 seconds)</span></a>
						 -->
					</div>
					<div class="starBox effect-fadeUp">
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
					</div>
					<div class="desc effect-fadeUp">
						<p class="sTitle">Description</p>
						<p>
							@lang('The BLOCKUNDER game is simple and fast.')<br>
							@lang("It's a 10 second or 40 second game.")<br>
							@lang("The lower the number, the higher the dividend rate and the higher the number of choices, the more likely it is to win, so the dividend rate is reduced.")<br>
							@lang("It is a game that is very easy to understand, and it is a game that can be done more easily.")
						</p>
					</div>
				</div>
				<div class="item">
					<p class="title effect-fadeUp">40" @lang('ODD / EVEN')</p>
					<div class="img effect-fadeUp">
						<img src="{{asset('/img/img_token2.png')}}" />
					</div>
					<div class="btnArea effect-fadeUp">
						<a href="/game/oddEven40">START <span>(40 seconds)</span></a>
						<!-- 
						<a href="/game/oddEven">START <span>(10 seconds)</span></a>
						 -->
					</div>
					<div class="starBox">
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star"></span>
					</div>
					<div class="desc effect-fadeUp">
						<p class="sTitle">Description</p>
						<p>
							@lang("The ODD/EVEN game is simple and fast.")<br>
							@lang("It's a 10 second or 40 second game.")<br>
							@lang("Based on the number of the end digits of the results of the blockhesh values generated every 3 seconds in Hyper Aiser Blockchain, 1,3,5,7,9 is a very easy-to-understand game with a winning rate of 50:50 with ODD. 0,2,4,6,8 being EVEN, and is much easier to do.")
						</p>
					</div>
				</div>				
				<div class="item">
					<p class="title effect-fadeUp">40" @lang('UNDER / OVER')</p>
					<div class="img effect-fadeUp">
						<img src="{{asset('/img/img_token3.png')}}" />
					</div>
					<div class="btnArea effect-fadeUp">
						<a href="/game/underOver40">START <span>(40 seconds)</span></a>
						<!-- 
						<a href="/game/underOver">START <span>(10 seconds)</span></a>
						 -->
					</div>
					<div class="starBox">
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star on"></span>
						<span class="star"></span>
					</div>
					<div class="desc effect-fadeUp">
						<p class="sTitle">Description</p>
						<p>
							@lang("The UNDER/OVER game is simple and fast.")<br>
							@lang("It's a 10 second or 40 second game.")<br>
							@lang("UNDER 50 or less based on the number of results of 100 results of the blockhash value generated every 3 seconds in the Hyper Aiser Blockchain, over 50 is a very easy-to-understand game with an OVER winning rate of 50:50 and much easier to play.")
						</p>
					</div>
				</div>
			</div>			

			<div class="statistic">
				<p class="sTitle">Game Statistic</p>
				<ul class="flex around effect-fadeUp">
					<li>
						<p class="title">Transactions</p>
						<p class="value">
							<span class="num">34729103</span>
						</p>
					</li>
					<li>
						<p class="title">24 Hours Volume</p>
						<p class="value">
							<span class="num">55,816,520.21</span>
							<span class="unit">KRW</span>
						</p>
					</li>
					<li>
						<p class="title">All Time Volume</p>
						<p class="value">
							<span class="num">2,703,548,468,125.30</span>
							<span class="unit">KRW</span>
						</p>
					</li>
					<li>
						<p class="title">24 Hours Dividend</p>
						<p class="value">
							<span class="num">208,616.81</span>
							<span class="unit">KRW</span>
						</p>
					</li>
				</ul>
			</div>
		</div>




		<div class="middleRow">
			<div class="innerWrap">

				<!-- vidoe -->
				<div class="videoWrap">
					<p class="sTitle">Promotional Video</p>
					<video poster="../video/blockbet_engsub_1080p_poster.jpg" controls>
						<source src="../video/blockbet_engsub_1080p.mp4" type="video/mp4">
					</video>
				</div>

				<div class="flex between">
					<div class="img">
						<img src="{{asset('/img/img_main_01.jpg')}}" />
					</div>
					<div class="textBox effect-fadeLeft">
						<p class="sTitle">@lang("What is the OtexExchange?")</p>
						<p>
							@lang("Otex is a digital asset exchange, a global P2P, BPB and B2C exchange that is not centralized but de-centralized.")<br>
							@lang("At Otex, you can trade a lot of digital assets, unlisted coins and tokens such as Bitcoin, Ethereum, Light Coin, ERC20 Tokens easily and safely.")<br>
							@lang("Otex is a mixed name for OTC + DEX.")
						</p>
						<p class="sTitle">@lang("What is a blockbet?")</p>
						<p>
							@lang("It is a blockchain distributed DAPP social game platform that provides a safe and reliable borderless ecosystem.")<br>
							@lang("Our goal is to provide users with the best game experience and become a symbol and leader of the blockchain game industry.") <br>
							@lang("It is a game that works on HyperAiserChain's Dapp (a decentralized application, a service that works as a smart contract on the basis of the blockchain platform).")<br>
							@lang("Block Bet is a system that determines the outcome of a game by the Rsult value, which is the result of the blockhash number in the blockchain.<br>")
							@lang("This is a game that can be trusted by eliminating the risk of manipulation and forgery of game results.")
						</p>
					</div>
				</div>
				<div class="flex between">
					<div class="textBox effect-fadeRight">
						<p class="sTitle">@lang("Fast Coin (BBT) Trading for Games")</p>
						<p>
							@lang("Global P2P deals support USD, CNY, KRW, JPY, DBT, VND, PHP, MYR markets and more.")<br>
							@lang("Convenience and rapid coin purchase and coin sale due to the interworking with the OTEX Digital Asset Exchange.")
						</p>
						<p class="sTitle">@lang("Environment of trust")</p>
						<p>
							@lang("Blockbet are safe and transparent, and all Blockbet games are validated. We make every effort to protect personal privacy.")<br>
							@lang("Blockhash – ensures fairness in all games.")
						</p>
					</div>
					<div class="img">
						<img src="{{asset('/img/img_main_02.jpg')}}" />
					</div>
				</div>
			</div>
		</div>



		<!-- slider -->
		<div class="sliderWrap">
			<div class="innerWrap">
				<div class="sliderContainer">
					<ul class="swiper-wrapper">

						<!-- 1 -->
						<li class="swiper-slide">
							<div class="textBox">
								<p class="big">@lang("Cryptocurrency credit VISA card")</p>
								<p class="small">@lang("It charges to coin and it uses as coin.")</p>
								<br><br>
								<p class="huge">VISA Credit Card</p>
								<br><br>
								<p class="small">
									@lang("Now, after the game, we withdraw and use the visa card.")
									<br>
									@lang("cryptocurrency credit VISA cards can request withdrawal through Bitcoin(BTC) and Kaisercoin(KISC) and withdraw cash from ATM devices around the world, and can immediately execute payments at VISA member stores worldwide.")
									<br>
									@lang("It provides considerable convenience for both blockchain and cryptocurrency users around the world.")
								</p>
								<br>
								<p class="big">@lang("Meet more advanced services and systems")</p>
								<div class="btnArea">
									<a href="#none" class="btn linkBtn" target="_blank">@lang("Apply for service")</a>
								</div>
							</div>
							<div class="imgBox">
								<img src="{{asset('/img/img_main_03.png')}}"/>
							</div>
						</li>

						<!-- 2 -->
						<li class="swiper-slide">
							<div class="textBox">
								<p class="big">@lang("Blockbet bank staking")</p>
								<p class="small">@lang("You can earn a risk-free dividend for your Blockbet games simply by making a deposit.")</p>
								<br><br>
								<p class="huge">@lang("You can get a very high dividend")</p>
								<br><br>
								<p class="small">
									@lang("Dividend interest will be paid for any game on the Blockbet game platform, and even if you lose BBT, you will receive a very high dividend income if you deposit it. ")
									<br>
									@lang("There is no limit to deposits or withdrawals. Get a steady return of 4% per month.")
									<br>
									@lang("It doesn't matter if you win or lose the BBT. Even if you lose the BBT, you will receive a high dividend if you deposit the BBT.")
									<br>
									@lang("Profit dividends are selected from Bitcoin (BTC), Etherium (ETH), Kaiser coin (KISC), and Block Bettoken (BBT) to be received as an encryption currency.")
								</p>
								<br>
								<p class="big">@lang("Experience stable and solid high returns.")</p>
								<div class="btnArea">
									<a href="#none" class="btn linkBtn" target="_blank">@lang("Apply for service")</a>
								</div>
							</div>
							<div class="imgBox">
								<img src="../img/img_main_04.png"/>
							</div>
						</li>

						<!-- 3 -->
						<li class="swiper-slide">
							<div class="textBox">
								<p class="huge">@lang("Do you want to raise the betting limit?")</p>
								<p class="big">
									@lang("Fill in the energy")<br>
									@lang("My energy is KISC")
								</p>
								<br><br>
								<p class="small">
									@lang("Charge the energy!")
									<br>
									@lang("The limit of the game will be even higher.")
									<br>
									@lang("Enjoy dynamic games with unlimited betting.")
								</p>
								<br>
								<p class="big">KaiserCoin (KISC)</p>
								<div class="btnArea">
									<a href="#none" class="btn linkBtn" target="_blank">@lang("Apply for service")</a>
								</div>
							</div>
							<div class="imgBox">
								<img src="{{asset('/img/img_main_05.png')}}"/>
							</div>
						</li>

					</ul>
				</div>
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>



		<div class="middleRow partnerWrap">
			<div class="innerWrap">
			<p class="sTitle">@lang("Blockbet Partner")</p>
				<p class="big effect-fadeUp">@lang("If you want to link your game to the Blockbet game platform, please contact us at any time.")</p>
				<p class="small effect-fadeUp">@lang("If you want to open a transparent game that you can trust in the blockchain, contact me at any time.")</p>
            	<!--ul>
					<li><img src="{{asset('/img/partner_01.png')}}"/></li>
					<li><img src="{{asset('/img/partner_02.png')}}"/></li>
					<li><img src="{{asset('/img/partner_03.png')}}"/></li>
					<li><img src="{{asset('/img/partner_04.png')}}"/></li>
					<li><img src="{{asset('/img/partner_05.png')}}"/></li>
					<li><img src="{{asset('/img/partner_06.png')}}"/></li>
					<li><img src="{{asset('/img/partner_07.png')}}"/></li>
				</ul-->
			</div>
		</div>


		<div class="partnerWrap projectWrap">
			<div class="innerWrap">
				<p class="sTitle">@lang("Blockbet Project")</p>
				<p class="big effect-fadeUp">@lang("We will never stop.")</p>
				<p class="small effect-fadeUp">
					@lang("To reduce entry barriers to the blockbet, we offer a system that allows you to use games such as Bitcoin, Ethereum, and Kaiser Coins, and we also offer a fast and reliable gaming platform to help more game developers develop transparent and reliable games.")<br>
					@lang("We continue to improve and introduce new features and fun.")<br>
				</p>
			</div>
		</div>


	</div> <!-- mainWrap -->

@endsection

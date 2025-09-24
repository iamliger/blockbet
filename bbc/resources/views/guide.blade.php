@extends('layouts.app')

@section('body')

	<script src="/js/guide-text-image.js"></script>
	<script>
		// set value with user's language. ('en', 'ko', 'zh', 'ja', ...)
		var _lang = 'en';


		// tabmenu scroll
		function goToSection(ele) {
			var y = $(ele).offset().top - 70;
			$('html, body').animate({scrollTop: y+'px'}, 600);
		}

		// download popup
		function popDownload() {
			$('.downloadPop').css('display', 'flex');
		}
		function closeDownload() {
			$('.downloadPop').hide();
		}

		// change content : language
		function changeContent() {
			// change youtube
			$('.videoList button').each(function() {
				var id = $(this).attr('id');
				var url = '';
				if(id && /youtube\d{3}/.test(id)) {
					url = _guideYoutube[id] ? _guideYoutube[id][_lang] : null; // get link user's language from guide-text.js
					if(url === null) {
						url = '';
					} else if(url === undefined || url == '') {
						url = _guideYoutube[id]['en']; // if no link, set link to default language 'en'
					}
					$(this).attr('data-movie', url);
				}
			});
			// change text
			$('p, .mTitle').each(function() {
				var id = $(this).attr('id');
				var str = '';
				if(id && /text\d{4}/.test(id)) {
					str = _guideLang[id] ? _guideLang[id][_lang] : null; // get text user's language from guide-text.js
					if(str === null) {
						str = '';
					} else if(str === undefined || str == '') {
						str = _guideLang[id]['en']; // if no text, set text to default language 'en'
					}
					$(this).html(str);
				}
			});
			// change image
			$('.img img').each(function() {
				var id = $(this).attr('id');
				var src = '';
				if(id && /image\d{3}/.test(id)) {
					src = _guideImg[id] ? _guideImg[id][_lang] : null;
				}
				if(src === null) {
					src = '';
				} else if(src === undefined || src == '') {
					src = _guideImg[id]['en']; // if no img, set img to default image 'en'
				}
				$(this).attr('src', '/img/guide/'+ src);
			});
		}



		// after DOM loading
		$(document).ready(function() {

			// change content of language
            _lang = $('header .lang select').val();
			changeContent();


// temporary function. change language
$('header .lang select').on('change', function() {
	_lang = $(this).val();
	changeContent();
});

		});
	</script>



	<div class="subWrap">

		<div class="innerWrap guideWrap">
			<p class="subTitle" id="text0000">Guide</p>

			<!-- tab menu -->
			<div class="tabMenu tab2">
				<button type="button" class="tab" onclick="goToSection('.section_1')">Game Rule</button>
				<button type="button" class="tab" onclick="goToSection('.section_2')">BBT Deposit/Withdrawal</button>
			</div>


			<div class="box video">
				<p class="title" id="text0201">View explanatory video</p>
				<div class="videoList">
					<button type="button" onclick="openMovie(this)" id="youtube001" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0202">What is a block chain Game?</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube002" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0203">BlockHash Description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube003" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0204">UNDER Game Description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube004" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0205">ODD/EVEN Game description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube005" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0206">UNDER/OVER Game Description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube006" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0207">Betting Method Description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube007" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0208">Betting End Description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube008" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0209">Betting Status Description</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube009" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0210">BBT Deposit/Withdraw</span>
					</button>
					<button type="button" onclick="openMovie(this)" id="youtube010" data-movie="">
						<img src="/img/img_main_01.jpg" class="thumb">
						<span class="mTitle" id="text0211">Blockbet in the exchange<br>Easy Deposit/Withdraw Description</span>
					</button>
				</div>
			</div>




			<div class="box section_1">
				<p class="title" id="text0001">What is a block chain?</p>

				<p class="para" id="text0002">It is a distributed data storage technology that stores data in blocks, connects them in chains, and replicates them to many computers at the same time.  Also called public transaction books.</p>
				<p class="para" id="text0003">Instead of keeping transaction records on a centralized server, the transaction history is sent to all users who participate in the transaction, and every transaction is made available to all participants. They are not allowed to falsify or falsify data by sharing and comparing them.</p>

				<p class="para marginT title" id="text0005">What is the BlockBet Blockchain HashBetting Game? (BBT coin betting)</p>

				<p class="para" id="text0006">Blockbet was developed to provide transparency without manipulation or tampering with all game results and betting values and to provide anonymous games for personal information protection.</p>

				<p class="para marginT" id="text0007">There is no player who operates and manages games by playing real-time games with crypto-currency, such as betting and betting amount for all games from deposit and withdrawal. But, for the game guide, Only language-specific consultations exist.</p>

				<p class="para marginT" id="text0008">Deposit for game. The manager of the withdrawal light does not exist. Blockchain game is a decentralized game.</p>

				<p class="para dot" id="text0009">Transparency. - Blockchain game is the result of block hash values (no manipulation of the result value)</p>
				<p class="para dot" id="text0010">Personal Information Protection – Anonymous game where you play games with tokens based on a block chain</p>
				<p class="para dot" id="text0011">Global games. - Social betting games with global users in real time.</p>
				<p class="para dot" id="text0012">Open betting - Real-time betting status is disclosed to provide transparency (Check real-time in Block Explorer)</p>
				<p class="para dot" id="text0013">Tokens autonomy - Encrypted digital virtual assets that can be exchanged by anyone</p>
				<p class="para dot" id="text0014">Token trading – P2P (Person to Person) trading via digital virtual asset exchange</p>
				<p class="para dot" id="text0015">Conveniently buy (buy) BBT tokens on the P2P Digital Virtual Assets Exchange, sell (sold)</p>

				<p class="para marginT" id="text0016">Let me introduce you to the game of fast, transparent and secure privacy in line with the changes and trends of the world.</p>
			</div>




			<div class="box center">
				<div class="img marginT"><img id="image001" src="" data-src="/img/guide/capture_001_en.jpg"></div>
				<p class="para" id="text0017">1) Shows block generation in real time from the block chain.</p>
				<p class="para" id="text0018">2) Indicates the block number generated in real time.</p>
				<p class="para" id="text0019">3) Indicates the block hash that is created per block.</p>
				<p class="para" id="text0020">4) Indicates the decision value generated from the random hash value generated by the block.</p>
				<p class="para" id="text0021">5) Go to Block Explorer to validate the block results.</p>


				<p class="para lineT title" id="text0022">Game Description</p>

				<p class="para marginT bold blue" id="text0023">1. Block-under game (one game is 40 seconds)</p>

				<div class="img marginT"><img id="image002" src="" data-src="/img/guide/capture_002_en.jpg"></div>
				<p class="para" id="text0024">Win when the result value is below the current number of the selected roll</p>

				<div class="img marginT"><img id="image003" src="" data-src="/img/guide/capture_003_en.jpg"></div>
				<p class="para" id="text0025">Adjust the dividend rate by moving left and right</p>

				<p class="para marginT bold" id="text0026">high dividend batting</p>
				<div class="img"><img id="image004"="" data-src="/img/guide/capture_004_en.jpg"></div>
				<p class="para" id="text0027">If you set the number of rolls to 20, the odds of results below 20 will be 19%, which will result in a higher dividend.</p>
				<div class="img"><img id="image005" src="" data-src="/img/guide/capture_005_en.jpg"></div>
				<p class="para" id="text0028">winning section</p>

				<p class="para marginT bold" id="text0029">Low dividend betting with a high chance of winning</p>
				<div class="img"><img id="image006" src="" data-src="/img/guide/capture_006_en.jpg"></div>
				<p class="para" id="text0030">If you set the number of rolls to 80, the probability of winning below 80 is 79%. Because of the high probability of winning, the dividend will be reduced.</p>
				<div class="img"><img id="image007" src="" data-src="/img/guide/capture_007_en.jpg"></div>
				<p class="para" id="text0028">winning section</p>


				<p class="para lineT bold blue" id="text0031">2. ODD / EVEN (one game takes 40 seconds)</p>

				<div class="img marginT"><img id="image008" src="" data-src="/img/guide/capture_008_en.jpg"></div>
				<p class="para" id="text0032">The hash result will be 1.3.5.7.9 - ODD, 2.4.6.8.0 - EVEN.</p>
				<div class="img"><img id="image009" src="" data-src="/img/guide/capture_009_en.jpg"></div>
				<div class="img"><img id="image010" src="" data-src="/img/guide/capture_010_en.jpg"></div>
				<p class="para" id="text0033">2 Result EVEN</p>
				<div class="img"><img id="image011" src="" data-src="/img/guide/capture_011_en.jpg"></div>
				<p class="para" id="text0034">1 Result ODD</p>


				<p class="para lineT bold blue" id="text0035">UNDER / OVER (one game takes 40 seconds)</p>

				<div class="img marginT"><img id="image012" src="" data-src="/img/guide/capture_012_en.jpg"></div>
				<p class="para" id="text0036">UNDER when hash result is 1~50, OVER when 51~100.</p>
				<div class="img"><img id="image013" src="" data-src="/img/guide/capture_013_en.jpg"></div>
				<div class="img"><img id="image014" src="" data-src="/img/guide/capture_014_en.jpg"></div>
				<p class="para" id="text0037">Results of 45 UNDER</p>
				<div class="img"><img id="image015" src="" data-src="/img/guide/capture_015_en.jpg"></div>
				<p class="para" id="text0038">Result OVER in 90</p>


				<p class="para lineT bold" id="text0039">Blockchain hash result verification</p>
				<div class="img marginT"><img id="image016" src="" data-src="/img/guide/capture_016_en.jpg"></div>
				<p class="para" id="text0040">Click on each created block value to connect to Block Explorer in Bizblocks' Aiser Blockchain to verify the result immediately.</p>
				<div class="img marginT"><img id="image017" src="" data-src="/img/guide/capture_017_en.jpg"></div>
			</div>



			<div class="box center">
				<p class="para title" id="text0041">BBT Betting Method Description</p>

				<div class="img"><img id="image018" src="" data-src="/img/guide/capture_018_en.jpg"></div>
				<p class="para" id="text0042">1) BBT reserves of present-day</p>
				<p class="para" id="text0043">2) The value of BBT holding converted to the current market price (select USD. CNY. KRW)</p>
				<p class="para" id="text0044">3) Quantity of BBT to be betted</p>
				<p class="para" id="text0045">4) Betting BBT converted to current market value</p>
				<p class="para" id="text0046">5) BBT Quantity to Win</p>


				<p class="para title" id="text0047">BBT Betting Start</p>

				<div class="img"><img id="image019" src="" data-src="/img/guide/capture_019_en.jpg"></div>
				<p class="para" id="text0048">1) betting time timer</p>
				<p class="para" id="text0049">2) Enable Betting Button</p>
				<div class="img marginT"><img id="image020" src="" data-src="/img/guide/capture_020_en.jpg"></div>
				<p class="para" id="text0050">End of Betting Time Warning</p>


				<p class="para title" id="text0051">BBT Betting End</p>

				<div class="img"><img id="image021" src="" data-src="/img/guide/capture_021_en.jpg"></div>
				<p class="para" id="text0052">1) Betting time over (Betting over)</p>
				<p class="para" id="text0053">2) Disable Betting Button</p>


				<p class="para title" id="text0054">BBT Betting Status</p>

				<div class="img"><img id="image022" src="" data-src="/img/guide/capture_022_en.jpg"></div>
				<p class="para" id="text0055">1) Overbetting (Dividend)</p>
				<p class="para" id="text0056">2) Betting fluid (+win BBT)</p>
				<p class="para" id="text0057">3) Betting Status in Progress</p>
				<p class="para" id="text0058">4) winning result status</p>
				<p class="para" id="text0059">5) status of results of a fall</p>
			</div>




			<div class="box center section_2">
				<p class="para title" id="text0060">BBT Deposit / Withdrawal</p>

				<div class="img"><img id="image023" src="" data-src="/img/guide/capture_023_en.jpg"></div>
				<p class="para marginT bold blue" id="text0061">BBT Token General Deposit</p>
				<p class="para marginT" id="text0062">What is a wallet? Blockchain-based coins all have their own wallets (address) like bank accounts. If you write down the address of the wallet and send it as if you are sending an account number, the coin will be sent to that address.</p>

				<p class="para title" id="text0063">general deposit</p>
				<p class="para small" id="text0064">(Receive a deposit from a User)</p>
				<div class="img"><img id="image024" src="" data-src="/img/guide/capture_024_en.jpg"></div>
				<div class="img marginT"><img id="image025" src="" data-src="/img/guide/capture_025_en.jpg"></div>
				<p class="para" id="text0065">Unlike regular games, direct the money to my wallet address, not to the management account, and run the game immediately.</p>
				<p class="para" id="text0066">If you send it to my BBT address from outside, it will be applied automatically.</p>
				<p class="para" id="text0067">Anyone can make a deposit to my BBT address.</p>
				<p class="para" id="text0068">Blockvet does not have its own deposit account.</p>

				<p class="para title" id="text0069">general withdrawal</p>
				<p class="para small" id="text0070">(Send withdrawals to users)</p>
				<div class="img"><img id="image026" src="" data-src="/img/guide/capture_026_en.jpg"></div>
				<div class="img marginT"><img id="image027" src="" data-src="/img/guide/capture_027_en.jpg"></div>
				<p class="para" id="text0071">Immediately to the Blockvet subscriber to be sent from my wallet (account), can be sent</p>
				<p class="para" id="text0072">Immediate, transferable without administrator approval</p>
				<p class="para" id="text0073">1) Enter the BBT address to send to wherever you want (BlockBet subscriber)</p>
				<p class="para" id="text0074">2) Enter quantity to send</p>
				<p class="para" id="text0075">3) Press the withdraw button. It will be withdrawn immediately.</p>
			</div>



			<div class="box center">
				<p class="para title" id="text0076">Easy token deposit / token withdrawal through the OTEX exchange</p>

				<p class="para marginT bold blue" id="text0077">Deposit / withdrawal using the OTEX exchange</p>
				<p class="para marginT " id="text0078">One-click deposit from OTEX to Blockbet</p>
				<p class="para" id="text0079">One-click withdrawal from Blockvet to &rarr; Otex</p>
				<p class="para" id="text0080">BBT Token is easily purchased and sold immediately on the OTEX Exchange Digital Virtual Assets (Coin) Exchange.</p>
				<p class="para" id="text0081">As strategic alliance partners, OTEX Exchange and Blockbet are more convenient for token trading.</p>
				<p class="para" id="text0082">Convenience, immediate purchase, and immediate sale are provided through API.</p>
				<p class="para" id="text0083">Bitcoins(BTC), Ethereum(ETH), Tether(USDT), Ripple(XRP), Kaiser(KISC), BBT, LightCoin(LTC) Optional deposit</p>

				<p class="para marginT bold blue" id="text0084">Join the Alliance of OTEX Virtual Digital Assets Exchange</p>
				<div class="img marginT"><img id="image029" src="" data-src="/img/guide/capture_029_en.jpg"></div>
				<p class="para" id="text0085">Download PaybanC in Google Play Store</p>
				<div class="btnArea download">
					<button type="button" class="btn blue" onclick="popDownload()">Download</button>
				</div>
				<div class="img marginT"><img id="image030" src="" data-src="/img/guide/capture_030_en.jpg"></div>
				<p class="para" id="text0086">PaybanC Membership</p>
				<div class="img marginT"><img id="image031" src="" data-src="/img/guide/capture_031_en.jpg"></div>
				<p class="para" id="text0087">E-Mail – same with blockbet</p>
				<div class="img marginT"><img id="image032" src="" data-src="/img/guide/capture_032_en.jpg"></div>
				<p class="para" id="text0088">Use after entering OTEX</p>

				<p class="para title" id="text0089">Purchase tokens on the Otex Exchange</p>
				<p class="para marginT bold blue" id="text0090">Deposit</p>
				<p class="para" id="text0091">Deposit to BlocKbet internal address via the OTEX exchange</p>
				<p class="para" id="text0092">Legal currency market, USD use country, CNY use country on the OTEX exchange. Choose the legal currency market used in the KRW countries, etc. Select the BBT token and send it after purchasing the token p2p</p>

				<div class="img marginT"><img id="image033" src="" data-src="/img/guide/capture_033_en.jpg"></div>
				<p class="para" id="text0095">1) USD market</p>
				<p class="para" id="text0096">2) General transaction: The presence of waiting time for purchase and sale</p>
				<p class="para" id="text0097">3) Buy-Seller(immediate transaction), Immediate Purchase Selection, Immediate Selling Selection</p>

				<div class="img marginT"><img id="image034" src="" data-src="/img/guide/capture_034_en.jpg"></div>
				<p class="para" id="text0098">1) Select deposit and withdrawal</p>
				<p class="para" id="text0099">2) withdrawal selection</p>
				<p class="para" id="text0100">3) Select BBT Token and Coin to Transfer</p>
				<p class="para" id="text0101">4) BBT withdrawal quantity selection</p>
				<p class="para" id="text0102">5) Click on Blockbet withdrawal: When you sign up for the same email between BlockBet and OTEX, BlockBet address is automatically applied.</p>
				<p class="para" id="text0103">6) Immediately upon application for withdrawal, charge the deposit to my blockbet.(If you have the same email subscription for Blocbet and OTEX)</p>
			</div>
		</div>

	</div> <!-- subWrap -->



	<!-- download popup -->
	<div class="downloadPop">
		<div class="pop">
			<a href="https://play.google.com/store/apps/details?id=io.bizblocks.kaiserbank" target="_blank" title="Google Play Store">
				<img src="/img/img_google.png">
			</a>
			<a href="https://bizblocks-io.s3.ap-northeast-2.amazonaws.com/kisc/public/apk/KaiserPayBanc.apk" target="_blank" title="Direct Download APK">
				<img src="/img/img_apk.png">
			</a>
			<div class="btnArea">
				<button type="button" class="btn blue" onclick="closeDownload()">CLOSE</button>
			</div>
		</div>
	</div>



@endsection
<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
	<!-- for IE Rendering -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="Description" content="">
	<!-- for Mobile -->
	<meta name="viewport" content="width=device-width,user-scalable=yes,initial-scale=1.0,minimum-scale=1.0">
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset("/img/favicon.png")}}" type="image/x-icon">
	<link rel="apple-touch-icon-precomposed" href="{{asset('/img/favicon.png')}}" type="image/x-icon">
	<title>BLOCK BET</title>
	<!-- css -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Noto+Sans+KR:300,400,500">
	<link rel="stylesheet" href="{{ asset('/css/swiper.css') }}" type="text/css">


	@if(Request::route()->getName() == 'game.underOver40' || Request::route()->getName() == 'game.under40' || Request::route()->getName() == 'game.oddEven40')
	<link rel="stylesheet" href="{{ asset('/css/common.css') }}" type="text/css">
	@else
	<link rel="stylesheet" href="{{ asset('/css/common.css') }}" type="text/css">
	@endif
	<!-- js -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
	<script src="{{asset('/js/jquery-3.4.1.min.js')}}"></script>
	<script src="{{asset('/js/swiper.min.js')}}"></script>
	<script src="{{asset('/js/common.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/web3@1.x.x/dist/web3.min.js" defer></script> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.15/lodash.min.js" integrity="sha256-VeNaFBVDhoX3H+gJ37DpT/nTuZTdjYro9yBruHjVmoQ=" crossorigin="anonymous"></script>
	<script src="https://unpkg.com/apollo-client-browser@1.9.0"></script>
	<script>
        // Laravel에서 주입된 graphqlUri 값을 JavaScript 변수로 사용
        window.APP_GRAPHQL_URI = "{{ $graphqlUri }}";
    </script>
	<script src="{{asset('/js/otex.js')}}"></script>
	<script>

		function showSlider() {
			var _slideOption = {
				speed: 1000,
				autoplay: {
					delay: 4000
				},
				loop: false,
				navigation: {
					nextEl: '.swiper-button-next',
					prevEl: '.swiper-button-prev'
				}
			};
			var slider = new Swiper(".sliderContainer", _slideOption);
			// 최초 슬라이더 박스 효과
			$('.sliderContainer').find('.swiper-slide-active').find('.textBox').addClass('animation-fadeUp');
			// 슬라이더 교체될 때마다 박스 효과
			slider.on('slideChangeTransitionEnd', function() {
				var box = $(this.$el).find('.swiper-slide-active').find('.textBox');
				box.addClass('animation-fadeUp').parents('li').siblings().find('.textBox').removeClass('animation-fadeUp');
			});
		}

		function locale(self){
			location.href='/language/'+$(self).val();
		}


		$(document).ready(function() {
			showSlider();
		});

	</script>
</head>
<body>
<!-- 전체 컨테이너 -->
<div class="wrapper">

	@include('includes.header',['game' => (Request::is('game/*') )])
    @yield('body')
	@include('includes.footer',['main' => (Route::currentRouteName() === 'index' ? true:false)])

</div> <!-- wrapper -->

<script>

var _guideText = {

	en: [
			// 0
			'@lang("BBT Real Time Block<br><br>HiperAiser blockschain developed in Bizblocks generates blocks every 3 seconds.<br>The hash value of a randomly generated block is used as the result of the game.<br>Since the generated blocks cannot be forged, we provide a reliable game that prevents the operation of the game.")',
			// 1
			'@lang("Block Number<br><br>Number of blocks created every 3 seconds in the HiperAiser chain.")',
			// 2
			'@lang("Block Hash<br><br>A function that receives a message of arbitrary length and outputs a fixed length value.<br>The purpose of the hash function is to detect errors or tampering with the message and provide the integrity of the data to be signed without third party intervention.")',
			// 3
			'@lang("Result<br><br>Randomly generated result of combining hash values of generated blocks.")',
			// 4
			'@lang("Block Under Game<br><br>If you choose a lower number from 1 to 100 and the Hash Reult value is within the selected range, you get a high dividend.<br>The game starts every 10 seconds.")',
			// 5
			'@lang("ODD &amp; EVEN<br><br>Based on 50 of the numbers 1 to 100, the odd hash value is ODD and the even number is EVEN.<br>The game starts every 10 seconds.")',
			// 6
			'@lang("UNDER &amp; OVER<br><br>Based on 50 out of 1 ~ 100 number, if Hash Reult value is less than 50, it becomes UNDER, and if more than 50, it becomes OVER.<br>The game starts every 10 seconds.")',
			// 7
			'@lang("DEPOSITE<br><br>Deposit OBB(BLOCK BET) coins and start the game.")',
			// 8
			'@lang("If you want to see detailed results, Click the link below.")'
		]

};
</script>
@stack('scripts')

<script>
function goMyPage(){
	@auth
		location.href='/mypage';
	@else
	alertPop('icon-error',"@lang('Required Login')",function(){
		location.href='/login';
	});
	@endif
}

function goMyTrade(){
	@auth
		location.href='/inout';
	@else
	alertPop('icon-error',"@lang('Required Login')",function(){
		location.href='/login';
	});

	@endif
}
</script>
<script>
@if(session('alert-error'))

	alertPop('icon-error',"{{session('alert-error')}}",function(){

	});

@endif

@if(session('alert-success'))

	alertPop('icon-info',"{{session('alert-success')}}",function(){

	});

@endif

</script>

@auth


<script>

	function logout() {
		confirmPop('icon-ask', "@lang('Do you want to log out?')", 'Logout', 'Cancel', function() {
			// logout..
			// .....
            document.getElementById('logout-form').submit();
		});
	}
</script>

@endauth

</body>
</html>


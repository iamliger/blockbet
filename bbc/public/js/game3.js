
// temporary script ----------------------------------------------------------
var _hashTemp = [
	{ block:'10894956', hash:'0x50167bc6dd4b4f6a2f570c0051a58eb994c24a72e17338146cd22d3b62619ee6' },
	{ block:'10894955', hash:'0x1150ea9d38cd48282812a5aa9107e05a5d0a1df338713f2d646e788195d6280f' },
	{ block:'10894954', hash:'0xda76d36d6ba9cc7772bc175ba17bab620e05bb67998d202bc94c9fd6dd314c20' },
	{ block:'10894953', hash:'0x9642916898a9f64876a5e07330b3fdfd01f6a5874fc134c9b2440c4f20b2e724' },
	{ block:'10894952', hash:'0xd3ed603308fdb5e8eff8942682d8b1384da1d61edb0abcfa60f1dcddb21138ef' },
	{ block:'10894951', hash:'0x6d01eb68d6671f416276793ccc42169c1aee2a347d865889dfbc746efb93d477' },
	{ block:'10894950', hash:'0x7e52feffa88e5d4755711aebf42ff907b3ef643736bc30cca49cfb1d4f8536f8' },
	{ block:'10894949', hash:'0x44fc1e71c6f79e4f4f5aedcf316ff20c05dec0951ba3e63af6647198594b8638' },
	{ block:'10894948', hash:'0x6e79836ba1274e28ba764b9df076000223a49af4592062149ba43d368919444d' },
	{ block:'10894947', hash:'0xdc987036b4682fed76b6fc0e400416f1225730d891bb4767e4d97471fa4ba5a1' }
];

let audio = new Audio();
audio.src = "/assets/sound/ball.wav";
let slide_audio = new Audio();
slide_audio.src = '/assets/sound/ball.mp3';

var _n = 0; // save index of hash code array
var _flyingTime = 1000; // Result Flying time
var _countSec = 0; // countdown second
var _speed = 2000; // 1 game time > countdown + Result Flying time

$(document).on('receivedEvent',()=>{

	$.get(result_url+'/under',(data)=>{
		let block = data[0];
		if($("#blocknumber_"+block.blocknumber).length === 0){
			// 이벤트의 내용을 여기에 적용한다.
				var result = block.result;
				// recycle temporary hash code
				if(_n > _hashTemp.length-1) _n = 0;
				// Add question mark. (parameter = false)
				addResult(false);
				// show countdown number
				countDown(_countSec);
				// wait for countdown
				setTimeout(function() {
					// add hash code -> At the same time, the result flies
					addHash(block.blocknumber, block.blockhash, result);
				}, _countSec);

				// wait for countdown + flying time
				setTimeout(function() {
					audio.play().then(()=>{}).catch(e=>console.log(e));
					// remove question mark
					removeQMark();
					// add result number
					addResult(true, result);
					// add result color on history grid box
					addGrid();
					// edit summary data
					summary();
					// use next hash code
					_n++;
					$(document).trigger('receivedEvent');
				}, _countSec + _flyingTime);
		}else{
			setTimeout(()=>{
				$(document).trigger('receivedEvent');
			},500);
		}
	});

});

$(document).trigger('receivedEvent');

// end of temporary script ---------------------------------------------------------------------




// 승패 색상 저장할 전역변수
var _resultColor = '';
var _maxHash = 30;


// 카운트 다운
function countDown(sec) {
	// 초 단위로 변경
	sec = sec / 1000;
	// 초를 배열에 순서대로 저장
	var secArray = [];
	for(var i=sec; i>0; i--) secArray.push(i);
	// 카운트 숫자들 표시
	for(var n=0; n<sec; n++) {
		// 화면에 뿌리는 작업을 1초씩 지연시키며 실행
		setTimeout(function() {
			// 카운트 숫자를 배열에 넣어 쓰는 이유는 setTimeout이 실행되는 시점에서 이미 변수값들이 변경되어, 모두 같은 숫자가 화면에 출력되는 오류를 해결하기 위함.
			var count = $('<p class="countDown">'+ secArray[0] +'</p>');
			$('body').append(count);
			// 사용한 배열값 제거
			if(secArray.length > 0) secArray.shift();
			// 추가된 요소는 충분한 시간 지나면 삭제
			setTimeout(function() { count.remove() }, 1200);
		}, n*1000);
	}
}



// 결과리스트 추가 함수.
function addResult(isResult, num) {
	var ul = $('.resultList');
	// 결과값이 아니면 물음표 표시
	var li = isResult ? '<li><p class="num '+ _resultColor +'">'+ num +'</p></li>' : '<li class="qmark"><p class="num white">?</p></li>';
	ul.append(li);
	// n개 이상 넘어가면 이전 리스트 삭제
	var max = 17;
	var lists = ul.find('li');
	if(lists.length > max) {
		lists.first().nextUntil(lists.eq(lists.length - max)).addBack().remove();
	}
}

// 물음표 삭제
function removeQMark() {
	$('.resultList .qmark').remove();
}

// 해쉬코드 추가 함수
function addHash(block, hash, result) {
	if($("#blocknumber_"+block).length === 0){
		var ul = $('.hashList');
		var li = $('<li class="highlight" id="blocknumber_'+block+'">\
				<span class="block">'+ block +'</span>\
				<a href="https://explorer.aiser.io/block/'+ hash +'" target="_blank"><span class="hash">'+ hash +'</span></a>\
				<span class="result">'+ result +'</span>\
			</li>');
		ul.prepend(li);
		// 게임 종류에 따라 승패 색상 결정
		var isOddEven = $('.gameTab .tabBtn').eq(1).hasClass('current');
		if(isOddEven) {
			_resultColor = result%2 == 0 ? 'red' : 'blue';
		} else {
			var gaugeValue = parseInt($('#gauge .value').text());
			_resultColor = result > gaugeValue ? 'red' : 'blue';
		}
		// 결과값 이동
		setTimeout(function() { moveResult(li.find('.result')) }, 100);
		// n개 이상 넘어가면 이전 리스트 삭제
		var lists = ul.find('li');
		if(lists.length > _maxHash) {
			lists.eq(_maxHash).nextAll().remove();
		}
	}
}


// 결과값 이동 함수
function moveResult(ele) {
	var num = parseInt(ele.text());
	// 목적지
	var target = $('#gauge .bar');
	var x1 = ele.offset().left;
	var y1 = ele.offset().top;
	var x2, y2;
	// odd/even 게임일 경우엔 목적지 좌표는 두 곳 중 한 곳으로 결정
	var isOddEven = $('.gameTab .tabBtn').eq(1).hasClass('current');
	if(isOddEven) {
		x2 = target.offset().left + (target.width() * (_resultColor == 'blue' ? 25 : 75) / 100);
	} else {
		x2 = target.offset().left + (target.width() * num / 100);
	}
	y2 = target.offset().top;
	// 이동될 엘리먼트 생성
	var fly = $('<div class="fly">'+ num +'</div>');
	// 초기 위치
	fly.css({ 'left':x1 +'px', 'top':y1 +'px' });
	$('body').append(fly);
	// 목적지로 날아가는 시간
	var flyTime = parseFloat($('.fly').css('animation-duration')) * 1000;
	// 목적지로 이동 후 제거
	fly.animate({ left:x2 +'px', top:y2 +'px' }, flyTime, function() {
		$(this).remove();
		// 게이지 위에 결과값 표시
		showResultBubble(num, isOddEven);
	});
}


// 게이지 위에 결과값 풍선 표시
function showResultBubble(num, isOddEven) {
	var bar = $('#gauge .bar');
	var x, bubble;
	if(isOddEven) {
		x = bar.width() * (_resultColor == 'blue' ? 25 : 75) / 100;
		var text = _resultColor == 'blue' ? 'ODD' : 'EVEN';
		bubble = $('<p class="resultBubble oddEven '+ _resultColor +'">'+ text +'</p>');
	} else {
		x = bar.width() * num / 100;
		bubble = $('<p class="resultBubble '+ _resultColor +'">'+ num +'</p>');
	}
	bubble.css({'left':x +'px'});
	bar.append(bubble);
	setTimeout(function() {
		bubble.remove();
	}, 1000);
}



// 게임 탭메뉴 클릭 시 처리
function selectGame(num) {
	// 버튼 활성화
	$('.gameTab li').eq(num).find('.tabBtn').addClass('current')
	$('.gameTab li').eq(num).siblings().find('.tabBtn').removeClass('current');
	// 게임별 설정
	
		// 게이지 조작 허용
		enableGauge('#gauge');
		// 게임버튼 교체
		$('.gameBtn0').css('display', 'flex');
		$('.gameBtn1, .gameBtn2').hide();
		// 스코어박스 색상변경
		$('.scoreBox').removeClass('color2 color3');	
}


// 게이지 입력
$.fn.extend({
	gaugeInput: function(min, max, init) {
		return this.each(function() {
			var $this = $(this);
			var bar = $this.find(".bar");
			var value = $this.find(".value");
			// 슬라이더 생성
			bar.slider({
				min:2, // 최소값
				max:96, // 최대값
				step:1, // 증감 간격
				value:init, // 초기값
				// 마우스 슬라이드 시 처리
				slide:function(event, ui) {					
					slide_audio.play().then(()=>{}).catch(e=>console.log(e));
					let currentValue = ui.value;
					value.text(currentValue);
					let val = Math.floor(100/(currentValue - 1)*(1 - 0.025)*100)/100;					
					setScores(currentValue);
					gaugeMove($this, currentValue)
					pick_number = currentValue;
					pick_rate = val;
					
				}
			});
			// 입력창 초기값 입력
			value.text(init);
			// 모바일 이벤트 설정
			bar.on("touchstart touchmove", function(e) {
				e.preventDefault();
				slide_audio.play().then(()=>{}).catch(e=>console.log(e));
				var touch = e.originalEvent.touches[0] || e.originalEvent.changedTouch[0];
				var x = touch.pageX - $(this).offset().left;
				var percent = (x / $(this).outerWidth()) * 100;
				let currentValue = Math.floor((max-min)*percent/100 + min);
				if(currentValue < 2) currentValue = 2;
				if(currentValue > 96) currentValue = 96;
				bar.slider("value",currentValue );
				value.text(bar.slider("value"));
				gaugeMove($this, bar.slider("value"));
				
				let val = Math.floor(100/(currentValue - 1)*(1 - 0.025)*100)/100;					
				setScores(currentValue);
				pick_number = currentValue;
				pick_rate = val;
			});
		});
	}
});

// 게이지가 이동될 때 실행되는 함수
function gaugeMove(id, value) {
	// 게이지 왼쪽 배경색 너비 조절
	$(id).find('.left').css('width', value +'%');
	$(id).find('.value').text(value);
	// 각 수치들 계산

}

function setScores(value){
	let val = Math.floor(100/(value - 1)*(1 - 0.025)*100)/100;
	$(".score2").text(val);
	$(".score1").text(value);
	$(".score3").text(Math.abs(value-1));
}

// 게이지 조작 금지
function disableGauge(id) {
	var bar = $(id).find('.bar');
	bar.slider('disable');
	bar.slider('value', 51);
	gaugeMove(id, 51);
	setScores(51);
}
// 게이지 조작 허용
function enableGauge(id) {
	var bar = $(id).find('.bar');
	bar.slider('enable');
	bar.slider('value', 51);
	gaugeMove(id, 51);
	setScores(51);
}


// 입력창 내용 삭제
function clearInput(btn) {
	$(btn).siblings('input').val('').focus();
}


// 히스토리 버튼
function toggleHistory(btn) {
	var box = $('.historyArea .innerWrap');
	if($(btn).hasClass('close')) {
		$(btn).removeClass('close');
		box.css('display', 'flex');
	} else {
		$(btn).addClass('close');
		box.hide();
	}
}


// 히스토리에서 연속된 색깔의 최대 개수
function getSequence(color) {
	var max = 0;
	var count = 0;
	$('.gridBox p').each(function() {
		if($(this).hasClass(color)) {
			count++;
			max = max < count ? count : max;
		} else if(!$(this).hasClass('blank')) {
			max = max < count ? count : max;
			count = 0;
		}
	});
	return max;
}


// 히스토리 요약값 계산
function summary() {
	var redSum = $('.gridBox .red').length;
	var blueSum = $('.gridBox .blue').length;
	$('.totalGame').text(redSum+blueSum);
	$('.totalRed').text(redSum);
	$('.totalBlue').text(blueSum);
	$('.aveRed').text((redSum/(redSum+blueSum)*100).toFixed(2) +'%');
	$('.aveBlue').text((blueSum/(redSum+blueSum)*100).toFixed(2) +'%');
	$('.seqRed').text(getSequence('red'));
	$('.seqBlue').text(getSequence('blue'));
}


// 레코드 리스트 탭 버튼
function recordTab(btn) {
	$(btn).addClass('current').siblings().removeClass('current');
	// 해당 탭 열기
	var index = $(btn).index();
	$('.record').eq(index).show().siblings().hide();
}




// 그리드 박스 슬라이더 설정
var _gridSlider;
var _gridOption = {
	direction: "horizontal",
	autoplay: false,
	loop: false,
	slidesPerView: 15,
	spaceBetween: 1,
	freeMode: true,
	freeModeSticky: true
};

// 그리드 박스 입력 함수
function addGrid() {
	var box = $('.gridBox .swiper-wrapper');
	var row;
	// 마지막 칼럼
	var lastCol = box.find('.row').last();
	// 마지막 칼럼의 마지막 값
	var lastValue = lastCol.find('p').last().attr('class');
	// 마지막 칼럼의 마지막 값이 비어있지 않을 때
	if(lastValue != 'blank') {
		// 마지막 값이 현재값과 같으면 같은 칼럼에 이어서 표시, 다르면 새칼럼 추가
		if(lastValue === _resultColor) {
			row = '<li class="row swiper-slide"><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="'+ _resultColor +'"><b></b></p></li>';
		} else {
			row = '<li class="row swiper-slide"><p class="'+ _resultColor +'"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p></li>';
		}
		_gridSlider.appendSlide(row);
	} else {
		// 비어있는 첫 셀
		var blankCell = lastCol.find('.blank').first();
		// 이전값
		var prevCell = blankCell.prev().attr('class');
		// 이전값이 현재값과 같으면 이어서 표시, 다르면 새 칼럼 추가
		if(prevCell === _resultColor) {
			blankCell.removeClass('blank').addClass(_resultColor);
		} else {
			row = '<li class="row swiper-slide"><p class="'+ _resultColor +'"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p><p class="blank"><b></b></p></li>';
			_gridSlider.appendSlide(row);
		}
	}
	// 슬라이더 이동
	_gridSlider.slideTo(_gridSlider.slides.length-1, 1000);
}




// DOM 로딩 후
$(document).ready(function() {

	// 게이지 생성
	$('#gauge').gaugeInput(0, 100, 51); // 최소, 최대, 초기값
	setScores(51);

	// 그리드 바둑판 생성
	_gridSlider = new Swiper(".gridBox", _gridOption);
	_gridSlider.on('slideChangeTransitionEnd', function() {
		// n개 넘으면 삭제
		var max = 100;
		var slideLength = _gridSlider.slides.length;
		if(slideLength > max) {
			var indexArray = [];
			for(var i=0; i<slideLength-max; i++) indexArray.push(i);
			// max개를 넘는 앞부분을 일괄 삭제
			_gridSlider.removeSlide(indexArray);
		}
	});

	// 리스트 길이 조정
	var mediaCase = window.matchMedia("(orientation:landscape) and (min-width:1080px)");
	$(window).on("resize", function() {
		if(mediaCase.matches) {
			var hashHeight = $('.centerArea').outerHeight() - $('.leftArea .title').outerHeight() - $('.hashArea .head').outerHeight() - $(window).width()*0.022;
			var recordHeight = $('.centerArea').height() - $('.recordTab').outerHeight() - $('.rightArea .head').outerHeight();
			$('.hashList').height(hashHeight);
			$('.recordWrap').height(recordHeight);
		} else {
			$('.hashList').css('height', '10rem');
			$('.recordWrap').css('height', '11rem');
		}
	}).trigger('resize');
});

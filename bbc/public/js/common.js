
// jquery 확장함수
$.fn.extend({
	// 스크롤에 따른 애니메이션
	setEffect: function(amount) {
		return this.each(function() {
			var $this = $(this);
			var effectType = ($(this).attr("class")).match(/effect\-(\w+)/)[1];
			var effect = "animation-" + effectType;
			$(window).on("scroll", function(e) {
				var winTop = $(this).scrollTop();
				var screenH = $(this).height();
				var thisTop = $this.offset().top + amount ;
				if(winTop + screenH > thisTop) {
					$this.addClass(effect);
				}
			});
		});
	}
});


// 특정 요소가 맞는지 여부 반환. jQuery의 is()와 비슷
HTMLElement.prototype.is = function(selector) {
	var firstChar = selector.substr(0,1);
	if(firstChar === '.') {
		if(this.classList.contains(selector.substr(1))) return true;
	} else if(firstChar === '#') {
		if(this.getAttribute('id') === selector.substr(1)) return true;
	} else {
		if(this.tagName.toLowerCase() === selector.toLowerCase()) return true;
	}
	return false;
};


// 부모들 중 selector와 일치하는 부모 반환. jQuery의 parents()와 비슷
HTMLElement.prototype.parents = function(selector) {
	var parent = this.parentElement;
	if(parent && parent.tagName.toLowerCase !== 'html') {
		if(parent.is(selector)) return parent;
		else return parent.parents(selector);
	}
	return null;
};


// 형제 엘리먼트 반환: jQuery의 siblings()와 비슷
HTMLElement.prototype.siblings = function(selector) {
	var _this = this;
	var matched = [];
	var check = function(element) {
		if(element) {
			if(!element.isSameNode(_this)) {
				if((selector && element.is(selector)) || !selector) matched.push(element);
			}
			return check(element.nextElementSibling);
		} else {
			return null;
		}
	};
	check(_this.parentElement.firstElementChild);
	return matched;
};


// 엘리먼트 생성: 다른 함수에서 사용 중
function newElement(tagName, className, innerHtml) {
	var ele = document.createElement(tagName);
	if(className) ele.classList.add(className);
	if(innerHtml) ele.innerHTML = innerHtml;
	return ele;
}


// 메세지 팝업 처리 : 다른 함수에서 사용
function createMessagePop(popType, icon, msg, trueStr, falseStr, callback) {
	function closeMessagePop(btn, callback) {
		btn.parents('.pop').classList.add('hide');
		btn.parents('.pop').addEventListener('animationend', function() { $(this).parents('div').remove(); });
		if(callback) callback();
	}
	var pop = newElement('div', 'messagePopup', '<div class="pop"><span class="icon '+ icon +'"></span><div class="msg"><p>'+ msg +'</p></div><div class="btnArea"></div></div>');
	var yesBtn = newElement('button', 'okBtn', trueStr);
	yesBtn.addEventListener('click', function() { closeMessagePop(this, callback); });
	pop.querySelector(".btnArea").appendChild(yesBtn);
	if(popType === 'confirm') {
		var noBtn = newElement('button', 'cancelBtn', falseStr);
		noBtn.addEventListener('click', function() { closeMessagePop(this); });
		pop.querySelector(".btnArea").appendChild(noBtn);
	}
	document.body.appendChild(pop);
	pop.querySelector("button:last-child").focus();
}

// 확인 버튼이 있는 팝업 : 콜백함수 존재하면 확인 버튼 누른 후 실행
// 아이콘 종류 : "icon-check", "icon-error", "icon-ask", "icon-info", "icon-caution"
function alertPop(icon, msg, callback) {
	createMessagePop('alert', icon, msg, 'OK', null, callback);
}

// 예, 아니오 버튼이 있는 팝업 : 콜백함수 존재하면 예 버튼 누른 후 실행
function confirmPop(icon, msg, trueStr, falseStr, callback) {
	createMessagePop('confirm', icon, msg, trueStr, falseStr, callback);
}


// url 파라미터 값 반환
function getURLParam(name) {
	// url에서 query string 부분만 떼어내 각 파라미터 그룹으로 분리
	var paramArr = location.search.substr(1).split("&");
	for(var i=0; i<paramArr.length; i++) {
		var value = paramArr[i].split("=");
		if(value[0]==name)
			// 공백문자가 있을 경우 처리
			return value[1].replace(/%20/g, " ");
	}
	return null;
}


// 메뉴 토글
function toggleMenu(btn) {
	$(btn).toggleClass('open');
	$('.menu ul').toggleClass('open');
}


function setBettingTime(percent) {
	var bar = $('.bettingTime .border .bar');
	bar.css('width', percent +'%');
	if(percent < 50) {
		bar.addClass('red');
	} else {
		bar.removeClass('red');
	}
}







// DOM 로딩 후 실행
$(document).ready(function() {

	// 컨텐츠 애니메이션 실행
	$("[class*='effect-']").setEffect(0);
	$(window).on('resize', function() {
		$(this).trigger("scroll");
	});
	$(window).trigger("scroll");

	// input창 클릭 시 효과
	$('input').on('focus', function() {
		$(this).parents('.inputBox').addClass('borderBright');
	}).on('blur', function() {
		$(this).parents('.inputBox').removeClass('borderBright');
		if($(this).val() == '') {
			$(this).parents('.inputBox').find('.title').removeClass('black');
		}
	}).on('input', function() {
		$(this).parents('.inputBox').find('.title').addClass('black');
	});

	// 배팅 버튼 클릭 시 효과
	$('.fullBtn, .halfBtn, .xBtn').on('click', function() {
		var btn = $(this);
		btn.addClass('on');
		setTimeout(function() { btn.removeClass('on') }, 200);
	})

	// 본문 클릭 시 메뉴 닫기
	$('.mainContent, .subWrap, .mainWrap').on('click', function() {
		$('.menuBtn, .menu ul').removeClass('open');
	});


}); //ready

function bettingTimeout() {
	// show time over text
	var timeOver = $('.bettingTime .border .end');
	timeOver.css('display', 'flex');
	// hide time over text
	// timeOver.hide();

	// disable betting button
	$('.bettingRow .btnArea button').prop('disabled', true);
	// enable betting button
	// $('.bettingRow .btnArea button').prop('disabled', false);

	// clear interval : temporary
}
$.fn.toggleAttr = function (attr, attr1, attr2) {
	return this.each(function () {
		var self = $(this);
		if (self.attr(attr) == attr1) {
			self.attr(attr, attr2);
		} else {
			self.attr(attr, attr1);
		}
	});
};
// SAMPLE_COMPONENTS.testWidthJs();
let $menuButton = $('[data-js="toggle-menu"]'),
	$headerMain = $('.header--main'),
	menuShowing = 'header--menu-showing',
	$navTabIndex = $('.header__nav, .header__menu, .header__menu .header__main-link'),
	$body = $('body'),
	$lastMenuLink = $('.header__nav').find('ul:last-child li:last-child a'),
	$firstMenuLink = $('.header__nav').find('ul:first-child li:first-child a'),
	$menuListItem = $('.header__list-item'),
	$offCanvas = $('.off-canvas');

function removeTabIndex(){
	$menuButton.attr('aria-expanded', 'true');
	$navTabIndex.attr('tabindex','0');
}

function resetTabIndex(){
	$menuButton.attr('aria-expanded', 'false');
	$navTabIndex.attr('tabindex','-1')

	$lastMenuLink.off('keydown blur');
	$menuButton.off('keydown blur');
	$firstMenuLink.off('keydown blur');

	$(window).off('keyup');

	$menuListItem.off("mouseenter mouseleave");
}

function clickOutsideMenu() {

	if($headerMain.hasClass(menuShowing)){
		$menuButton.trigger('click');
	}
}

function trapFocus() {
	$lastMenuLink.on('keydown blur', function (e) {
		let $this = $(this);
		if (e.shiftKey && e.keyCode === 9) {
			$this.parent().prev('li').find('a').focus();
			return false;
		} else if (e.keyCode === 9) {
			$menuButton.focus();
			// console.log('tab')
			return false;
		}
	});

	$menuButton.on('keydown blur', function (e) {
		if (e.shiftKey && e.keyCode === 9) {
			$lastMenuLink.focus();
			//console.log('shift tab')
			return false;
		} else if (e.keyCode === 9) {
			$firstMenuLink.focus();
			//console.log('tab')
			return false;
		}
	});

	$firstMenuLink.on('keydown blur', function (e) {
		if (e.shiftKey && e.keyCode === 9) {
			$menuButton.focus();
			//console.log('shift tab')
			return false;
		}
	});

	$(window).on('keyup', function(e){
		if (e.keyCode === 27) {
			clickOutsideMenu();
		}
	});
}


function initHeader(){

	$menuButton.on('click',function(){
		$body.toggleClass('menu-open');
		setTimeout(() => {
			$headerMain.toggleClass(menuShowing);
		}, 0);
		if($headerMain.hasClass(menuShowing)){
			resetTabIndex();
			setTimeout(() => {
				$offCanvas.removeClass('off-canvas--hidden');
			}, 300);
		} else {
			removeTabIndex();
			trapFocus();
			$offCanvas.addClass('off-canvas--hidden');
		}
	});

	$menuListItem.on("mouseenter mouseleave", function(){
		let $thisInnerLink = $(this).find('.header__featured-link');
		$thisInnerLink.fadeToggle();
	});

}

module.exports = {
	initHeader
};

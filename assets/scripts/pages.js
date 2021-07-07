let HEADER_COMPONENTS = require('./components/header');
/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
	var FancySquares = {
		// All pages
		'common': {
	  		init: function() {
				// JavaScript to be fired on all pages
				$(document).foundation();
				HEADER_COMPONENTS.initHeader();

				let singleFigureProduct = '.figure__product-link';
				$('[data-js="single-product-click"]').on('click',function(){
					let $this = $(this);
					$this.toggleClass('figure__product--visible-product');
					$this.find(singleFigureProduct).fadeToggle();
				});

				$('.owl-feature-insta').on('click','[data-js="shop-products-dynamic"]',function(e){
					e.preventDefault();

					let $this = $(this),
						instaProduct = '.insta-block__items';
					$this.toggleClass('figure__product--visible-product');
					$this.siblings(instaProduct).fadeToggle();
				})

				let $postPreviewProducts = $('[data-js="shop-products"]');
				$postPreviewProducts.on('click',function(){
					let $this = $(this);
					$this.toggleClass('post-preview__product-title--showing');
					$this.siblings().fadeToggle();
				});

				let $mainElement = document.getElementById('waypoint'),
					$bodyElement = $('body');
				var waypoint = new Waypoint({
					element: $mainElement,
					handler: function(direction) {
						$bodyElement.toggleClass('scrolling');
					},
					offset: -50
				})

				bsBreakpoints.init()

				$('.widget_product_categories h3').on('click', function() {
					if ($(window).width() < 1024) {
						$(this).
							toggleClass('opened').
							parent().
							find('.product-categories').
							toggleClass('show');
					}
				});
	  		},
	  		finalize: function() {
				// JavaScript to be fired on all pages, after page specific JS is fired

	  		}
		},
		// Home page
		'home': {
	  		init: function() {
				// JavaScript to be fired on the home page

				// fancySquareCookies.remove('modal_shown');

				// if (fancySquareCookies.get('modal_shown') === undefined) {
    //                 fancySquareCookies.set('modal_shown', 'value', { expires: 7 });
    //                 $('#newsletterModal').foundation('open');
	//             }
				$('.owl-feature-insta').owlCarousel({
					loop:true,
					margin:40,
					nav:true,
					mouseDrag: false,
					responsive:{
						0:{
							items:1
						},
						600:{
							items:3
						},
						1000:{
							items:4
						},
						1600:{
							items:5
						}
					},
					dots: false,
					autoplay: true,
					autoplayTimeout: 5000,
					autoplayHoverPause: true
				})

		},
	  		finalize: function() {
				// JavaScript to be fired on the home page, after the init JS
	  		}
		},
		// about page
		'page_template_tmpl_about': {
			init: function() {
				// JavaScript to be fired on the about page
				let $newsLetter = $('.main-newsletter'),
					$main = $('#waypoint'),
					$recentPosts = $('[data-js="move-recent-posts"]'),
					$featuredShop = $('.featured-shop');

					$main.after($newsLetter);

					$featuredShop.after($recentPosts);
			},
			finalize: function() {
				// JavaScript to be fired on the about page, after the init JS
			}
		},
		// single post. page-template-tmpl-about
		'single_post': {
	  		init: function() {
				// JavaScript to be fired on the about us page
				$('.owl-carousel').owlCarousel({
					loop:true,
					margin:40,
					nav:true,
					items: 1,
					dots: false,
					autoplay: true,
					autoplayTimeout: 5000,
					autoplayHoverPause: true
				})

				let currentBreakPoint = bsBreakpoints.detectBreakpoint(),
					$postHeader = $('.featured-interview--single-post header'),
					$featuredElement = $('.featured-interview--single-post');
				// console.log(currentBreakPoint);
				if(currentBreakPoint === 'small'){
					$featuredElement.after($postHeader);
				}
				function resizeWidthOnly(a,b) {
					var c = [window.innerWidth];
					return onresize = function() {
						var d = window.innerWidth,
						e = c.length;
						c.push(d);
						if(c[e]!==c[e-1]){
						clearTimeout(b);
							b = setTimeout(a, 250);
						}
					}, a;
				}

				resizeWidthOnly(function() {
					// console.log(bsBreakpoints.getCurrentBreakpoint());
					let $hasHeader = $('article > header').length,
						activeBreakPoint = bsBreakpoints.getCurrentBreakpoint();
					if(activeBreakPoint === 'small' && $hasHeader === 0){
						$featuredElement.after($postHeader);
					}
				});
	  		}
		}
	};

	// The routing fires all common scripts, followed by the page specific scripts.
	// Add additional events for more control over timing e.g. a finalize event
	var UTIL = {
		fire: function(func, funcname, args) {
			var fire;
			var namespace = FancySquares;
			funcname = (funcname === undefined) ? 'init' : funcname;
			fire = func !== '';
			fire = fire && namespace[func];
			fire = fire && typeof namespace[func][funcname] === 'function';

			if (fire) {
			  namespace[func][funcname](args);
			}
		},
		loadEvents: function() {
			// Fire common init JS
			UTIL.fire('common');

			// Fire page-specific init JS, and then finalize JS
			$.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
				UTIL.fire(classnm);
				UTIL.fire(classnm, 'finalize');
			});

			// Fire common finalize JS
			UTIL.fire('common', 'finalize');
		}
	};

	// Load Events
  	$(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.

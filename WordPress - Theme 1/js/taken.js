+function($){

	"use strict";

	$(document).on('ready', function(){
		$('.header-v1 .menu li a').on('click', function(e){
			if($(this).attr('href') == 0 || $(this).attr('href') == "#"){
				e.preventDefault();

				// check if current li is clicking again
				if($(this).parent().hasClass('active-sub-menu')){

					// remove active class from current li
					$(this).parent().removeClass('active-sub-menu');

					//remove active class from first menu parent
					$('.menu').removeClass('sub-menu-active');

					// remove active class from all li parents of current li
					$('.menu li').removeClass('active-parent');

					//repeat click procedure for closest li parent to simulate back
					var closestParent = $(this).parent().parents('li:first');
					console.log(closestParent);

					// check if this li is not last li item in menu
					if(closestParent.hasClass('menu-item')){
						//clear all classes before adding to a new li
						$('.menu li').removeClass('active-sub-menu');

						// add active class to current li
						closestParent.addClass('active-sub-menu');

						// add active class to all li parents of current li
						closestParent.parents('li').addClass('active-parent');

						//add active class to first menu parent
						$('.menu').addClass('sub-menu-active');
					}

				}else{

					//clear all classes before adding to a new li
					$('.menu li').removeClass('active-sub-menu');

					// add active class to current li
					$(this).parent().addClass('active-sub-menu');

					// add active class to all li parents of current li
					$(this).parents('li').addClass('active-parent');

					//add active class to first menu parent
					$('.menu').addClass('sub-menu-active');

				}
			}
		});
	});
	
	$('.header-v1 .menu-icon > a').on('click', function(e){
		e.preventDefault();
		$(this).parent().find('.menu').slideToggle();
	});

	$('.header-v3 .menu-icon > a').on('click', function(e){
		e.preventDefault();
		$(this).toggleClass('active-header-item');
		$(this).parent().children('div').fadeToggle();
		$(this).find('i').toggleClass('fa-navicon');
		$(this).find('i').toggleClass('fa-times');

		if($(this).find('i').hasClass('fa-navicon')){
			var menuItems = $(this).parent().children('div').find(' > ul > li');
			menuItems.css({'opacity':0});
		}else{
			var menuItems = $(this).parent().children('div').find(' > ul > li');
			$.each(menuItems, function(i, el){
				$(el).css({'opacity':0});
				setTimeout(function(){
					$(el).animate({
					'opacity': 1
					}, 400);
				},400 + ( i * 120 ));
			});
		}
	});

	$(".header-v3 ul.menu li > a").on('click', function(w){
		
		if($(this).attr('href') == 0 || $(this).attr('href') == "#"){

			//because e is to mainstream 
			w.preventDefault();

			//in case if clicked item has active class
			//add or remove active class and toggle direct child ul.submenu
			if($(this).parent().hasClass('active')){
				$(this).parent().toggleClass('active');
				$(this).parent().children("ul.sub-menu").stop().slideToggle();
				console.log("case 1");
			}

			//in case if clicked items parent has active class, 
			//so it's second or deeeper level
			//add active class to this item and slideDown direct child ul.submenu
			else if($(this).parents('li').hasClass('active')){
				$(this).parent().addClass('active');
				$(this).parent().children("ul.sub-menu").stop().slideDown();
				console.log("case 2");
			}

			//in case if doesn't have active class and parents does not have active class
			//add class active and slideDown
			else{
				$(".header-v3 ul.menu li").removeClass('active');
				$("ul.sub-menu").slideUp();
				$(this).parent().addClass('active');
				$(this).parent().children("ul.sub-menu").stop().slideDown();
				console.log("case 3");
			}

		}

	});

	$('.header-v5 .menu-icon > a').on('click', function(e){
		e.preventDefault();
		if($(this).attr('href') == 0 || $(this).attr('href') == "#"){
			$('body').toggleClass('active-menu');
			$('.header-v5 ul.menu').toggleClass('active-menu');
		}
	});

	$('.shares > a').on('click', function(e){
		e.preventDefault();
		var items = $(this).parent().find('ul li');
		if(items.css('display') == 'list-item'){
			items = $(this).parent().find('ul li').get().reverse();
		}
		$.each(items, function(i){
			// console.log(i);
			var item = $(this);
			setTimeout(function(){
				item.stop().fadeToggle(700);
			}, i * 200);
		});

	});

	$(document).on('click', '.search-btn > a', function(e){
		var btn = $(this);
		btn.toggleClass('active-header-item');
		btn.find('i').toggleClass('fa-search');
		btn.find('i').toggleClass('fa-times');
		btn.parent().find('.form-container').fadeToggle();

		btn.parent().find('.input-border').toggleClass('active');
		btn.parent().find('.search-btn-container').toggleClass('active');

		e.preventDefault();
	});

	/*
	*	check if owl is initialized
	*	loop through items to initialize each
	*/
	if($('[data-owl-carousel]')){
		$.each($('[data-owl-carousel]'), function(){
			var $this = $(this);
			var options = $this.data('owl-carousel-options');
			var navigation = $this.data('navigation');
			var activeClass = $this.data('owl-active-item');
			
			$(document).on('ready', function(){
				if(options.length != 0){
					$this.on('initialized.owl.carousel', function(event){
						if(event.page.size >= event.item.count){
							$this.parents('.stoned-container').siblings('.nav').hide();
							console.log($this.parents('.stoned-container'));
						}else{
							$this.parents('.stoned-container').siblings('.nav').show();
						}

					});
					$this.owlCarousel(options);
					if(navigation == 'nav1'){

						// initialize carousel to variable
						var slider = $this, nav;

						// find slider navigation
						if(slider.parents('.stoned-container').siblings('.nav').length){
							nav = slider.parents('.stoned-container').siblings('.nav');
						}else if(slider.parents('.stoned-container').find('.nav').length){
							nav = slider.parents('.stoned-container').find('.nav');
						}

						console.log(nav);

						nav.find('.prev').on('click', function(){
							// slider.prev();  // prev slide
							if($('body').hasClass('rtl')){
								slider.trigger('next.owl.carousel', [300]);
							}else{
								slider.trigger('prev.owl.carousel', [300]);
							}
						});

						nav.find('.next').on('click', function(){
							// slider.next();  // next slide
							if($('body').hasClass('rtl')){
								slider.trigger('prev.owl.carousel', [300]);
							}else{
								slider.trigger('next.owl.carousel', [300]);
							}
						});

						slider.on('resized.owl.carousel', function(event){
							if(event.page.size >= event.item.count){
								nav.hide();
							}else{
								nav.show();
							}

						});
					} else if(navigation == 'nav2'){
						// initialize carousel data to variable
						var slider = $this;
						var sliderNav = $this.siblings('.nav2')

						sliderNav.find('.prev').on('click', function(){
							if($('body').hasClass('rtl')){
								slider.trigger('next.owl.carousel', [300]);
							}else{
								slider.trigger('prev.owl.carousel', [300]);
							}
						});

						sliderNav.find('.next').on('click', function(){
							if($('body').hasClass('rtl')){
								slider.trigger('prev.owl.carousel', [300]);
							}else{
								slider.trigger('next.owl.carousel', [300]);
							}
						});

						sliderNav.on('resized.owl.carousel', function(event){
							if(event.page.size >= event.item.count){
								$this.parents('.stoned-container').siblings('.nav').hide();
								console.log($this.parents('.stoned-container'));
							}else{
								$this.parents('.stoned-container').siblings('.nav').show();
							}

						});
					}

				}else{
					console.log(options.length);
					$this.owlCarousel({
						nav : true,
						slideSpeed : 300,
						paginationSpeed : 400,
						items : true,
						transitionStyle: "fade"
					});
				}
			});
		});
	}

	/*
	*	check if Royal Slider is initialized
	*	loop through items to initialize each
	*/
	if($('[data-royal-slider]')){
		$.each($('[data-royal-slider]'), function(){
			var $this = $(this);
			var options = $this.data('royal-slider-options');
			var isRtl = $('body').hasClass('rtl') ? true : false;
			console.log(isRtl);
			
			$(document).on('ready', function(){
				if(options.length != 0){

					if(isRtl){
						var slides = $('.royalSlider > div');
						var slideNum = slides.length;
						slides.each(function() {
					        $(this).prependTo(this.parentNode);
					    });
					    if(slideNum > 0){
					    	options['startSlideId'] = slideNum - 1;	
					    }else{
					    	options['startSlideId'] = 0;
					    }
					    console.log(options)
					}

					$this.royalSlider(options);

					var slider = $this.data('royalSlider');

					slider.playVideo();

					$this.siblings('.nav').find('.prev').on('click', function(){
						slider.prev();  // prev slide
					});

					$this.siblings('.nav').find('.next').on('click', function(){
						slider.next();  // next slide
					});

					slider.ev.on('rsAfterSlideChange', function(event) {
						slider.playVideo();
					});

					$(window).on('resize load', function(){
						if(1 >= slider.numSlides){
							console.log($this.siblings('.nav').hide());
						}else{
							$this.siblings('.nav').show();
						}
					});

				}else{
					console.log(options);
					$this.royalSlider({
						keyboardNavEnabled: true,
						imageScaleMode: 'fill',
						controlNavigation: 'none',
						transitionType: 'fade'
					});  
				}
			});
		});
	}

	/*
	*	check if Google Map is initialized
	*	loop through items to initialize each
	*/
	if($('[data-map]')){
		$.each($('[data-map]'), function(){
			var $this = $(this);
			var options = $this.data('data-map-options');
			
			$(document).on('ready', function(){
				var element = document.getElementById('map-canvas');

				var options = $(element).data('mapOptions');

				var myLatLng = new google.maps.LatLng(options.lattitude, options.longtitude);

				var mapOptions = {
					center: myLatLng,
					zoom: options.zoom,
					disableDefaultUI: true,
					draggable: false,
					scrollwheel: false,
					styles: [
						{"featureType": "landscape","stylers": [{"saturation": -100},{"lightness": 65},{"visibility": "on"}]},
						{"featureType": "poi","stylers": [{"saturation": -100},{"lightness": 51},{"visibility": "simplified"}]},
						{"featureType": "road.highway","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
						{"featureType": "road.arterial","stylers": [{"saturation": -100},{"lightness": 30},{"visibility": "on"}]},
						{"featureType": "road.local","stylers": [{"saturation": -100},{"lightness": 40},{"visibility": "on"}]},
						{"featureType": "transit","stylers": [{"saturation": -100},{"visibility": "simplified"}]},
						{"featureType": "administrative.province","stylers": [{"visibility": "off"}]},
						{"featureType": "water","elementType": "labels","stylers": [{"visibility": "on"},{"lightness": -25},{"saturation": -100}]},
						{"featureType": "water","elementType": "geometry","stylers": [{"hue": "#ffff00"},{"lightness": -25},{"saturation": -97}]}
					]
				};

				var map = new google.maps.Map(element, mapOptions);

				var marker = new google.maps.Marker({
					position: myLatLng,
					map: map,
					icon: options.icon,
					title: options.title
				});
			});
		});
	}

	/*
	*	check if DynamicLayout is initialized
	*	loop through items to initialize each
	*/
	if($('[data-dynamicLayout]')){
		$.each($('[data-dynamicLayout]'), function(){
			$(window).on('load', function(){
				var colorThief = new ColorThief();
				var img = $('.overlay-container').find('img');
				$.each(img, function(){
					var $this = $(this);
					var color = colorThief.getColor(this);
					console.log(color);
					console.log($this.parents('.overlay-container').find('.overlay').css('background-color', 'rgba('+ color +', 0.8)'));
					// console.log(this);
				});
				// console.log(img);
			});			
		});
	}

	$(document).on('itemsChanged', function(){
		if($('[data-dynamicLayout]')){
			$.each($('[data-dynamicLayout]'), function(){
				var colorThief = new ColorThief();
				var img = $('.overlay-container').find('img');
				$.each(img, function(){
					var $this = $(this);
					var color = colorThief.getColor(this);
					console.log(color);
					console.log($this.parents('.overlay-container').find('.overlay').css('background-color', 'rgba('+ color +', 0.8)'));
					// console.log(this);
				});
			});
			console.log("img");
		}
	});

	/*
	*	check if CustomScrollbar is initialized
	*	loop through items to initialize each
	*/
	if($('[data-customScrollbar]')){
		$.each($('[data-customScrollbar]'), function(){
			var $this = $(this);
			$(window).on('load', function(){
				// person-info
				$this.mCustomScrollbar({
					theme:"minimal",
					scrollInertia: 5
				});
			});			
		});
	}

	/*
	*	check if CustomScrollbar is initialized
	*	loop through items to initialize each
	*/
	if($('[data-customScrollbarr]')){
		$.each($('[data-customScrollbarr]'), function(){
			var $this = $(this);
			$(window).on('load', function(){
				// person-info
				$this.mCustomScrollbar({
					scrollInertia: 10,
					axis:"x",
					theme: "minimal-dark",
					scrollEasing: "linear",
					scrollbarPosition: "outside",
					mouseWheel:{ 
						axis: "x"
					}
				});
			});			
		});
	}

	/*
	*	check if Scroll Reveal is initialized
	*	loop through items to initialize each
	*/
	if($('[data-scroll-reveal]')){
		var isOnePage = $('body').is('#one-page') ? true : false;
		// console.log(isOnePage);
		if(isOnePage){
			$(window).on('load', function(){
				window.sr = new scrollReveal({
					"delay": "onload"
				});
			});
		}else{
			$.each($('[data-scroll-reveal]'), function(){
				var $this = $(this);
				var config = $this.data('scroll-reveal-options');

				$(window).on('load', function(){
					window.sr = new scrollReveal(config);
				});			
			});
		}
	}

	/*
	*	preload effect
	*/
	$(window).on('load', function(){
		$('.loading-screen').fadeOut();
	});

	/*
	*	check if Home filter is initialized
	*/
	$('.filter.filter-home').on( 'click', 'a', function(e) {
		e.preventDefault();

		var anchorParent = $(this).parents('.filter').find('a').removeClass('active');
		$(this).addClass('active');

  		var filterValue = $(this).attr('data-filter');
  		var parent = $('.items');
  		parent.find('.item').removeClass('unactive-item');
  		parent.find('.item').addClass('unactive-item');
  		parent.find(filterValue).removeClass('unactive-item');
	});

	/*
	*	set and remove placeholder on inputs(currently only in site search)
	*/
	$('.search-field').focus(function(){
	   $(this).data('placeholder',$(this).attr('placeholder'))
	   $(this).attr('placeholder','');
	});

	$('.search-field').blur(function(){
	   $(this).attr('placeholder',$(this).data('placeholder'));
	});

	$('[data-remove-text]').focus(function(){
	   $(this).data('placeholder',$(this).attr('placeholder'))
	   $(this).attr('placeholder','');
	});

	$('[data-remove-text]').blur(function(){
	   $(this).attr('placeholder',$(this).data('placeholder'));
	});

	$('.wpcf7 input').focus(function(){
	   $(this).data('placeholder',$(this).attr('placeholder'))
	   $(this).attr('placeholder','');
	});

	$('.wpcf7 input').blur(function(){
	   $(this).attr('placeholder',$(this).data('placeholder'));
	});

	$('.wpcf7 textarea').focus(function(){
	   $(this).data('placeholder',$(this).attr('placeholder'))
	   $(this).attr('placeholder','');
	});

	$('.wpcf7 textarea').blur(function(){
	   $(this).attr('placeholder',$(this).data('placeholder'));
	});
	
	/*
	*	number of posts in category animation
	*/
	var support = { animations : Modernizr.cssanimations },
		animEndEventNames = { 'WebkitAnimation' : 'webkitAnimationEnd', 'OAnimation' : 'oAnimationEnd', 'msAnimation' : 'MSAnimationEnd', 'animation' : 'animationend' },
		animEndEventName = animEndEventNames[ Modernizr.prefixed( 'animation' ) ],
		onEndAnimation = function( el, callback ) {
			console.log(el = el.get(0));
			var onEndCallbackFn = function( ev ) {
				if( support.animations ) {
					if( ev.target != this ) return;
					this.removeEventListener( animEndEventName, onEndCallbackFn );
				}
				if( callback && typeof callback === 'function' ) { callback.call(); }
			};
			if( support.animations ) {
				el.addEventListener( animEndEventName, onEndCallbackFn );
			}
			else {
				onEndCallbackFn();
			}
		}

	$('.cbutton').each(function(){
		var item = $(this).next();
		$(this).on('click', function(){
			$('.cbutton').next().removeClass('active');
			item.addClass('active');
			item.addClass('cbutton--click');
			onEndAnimation(item, function(){
					item.removeClass('cbutton--click');
				}
			);
		});
	});

	/*
	*	responsive menu toggle
	*/
	$(document).on('click', 'a.responsive-menu-btn', function(w){
		console.log(this);
		w.preventDefault();
		$('.responsive-menu ul.menu').slideToggle();
	});

	/*
	*	contact form
	*/
	function validateEmail(email) {
    	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    	return re.test(email);
	}

	$(document).ready(function(){
	    /*Ajax Contact Form*/
        $("body").on("submit","form.contactForm",function(e){			
			
			$('.error').removeClass('error');
			
			var name = $(this).find("#name");
            var email = $(this).find("#email");
			var topic = $(this).find("#topic");
            var message = $(this).find("#comment");           
			
			var return_state = true;
            var form = $(this);
			
            if(name.val() == ""){
                name.addClass("error");
                return_state = false;
            }
            if(email.val() == "" || !validateEmail(email.val())){
                email.addClass("error");
                return_state = false;
            }
			
            if(message.val() == ""){
                message.addClass("error");
                return_state = false;
            }
		    
			if(return_state){
					 var data = {
						 sth_name : name.val(),
						 sth_email : email.val(),
						 sth_topic : topic.val(),
						 sth_message : message.val()
					}
					
					jQuery.post(document.URL,data,function(data){
						  form.fadeOut("normal",function(){									
							$('.sth_message').html(data);
							$(".sth_message").fadeIn("normal");
						});
						
					}).error(function(){
							alert('errorr');								
					});
			}
			return false;
	    	/*Ajax Contact Form*/
		});
		
		//Reset contact form fields
		$("input[value='Reset']").click(function(e){
        	e.preventDefault();
        	$("#name").val('');
        	$("#email").val('');
        	$("#topic").val('');
        	$("#comment").val('');
    	});
	});

}(jQuery);

/*
*	initialize masonry layout for home page
*/
+function($){
	"use strict";
	var $container;

	function setLayoutItemSizes(){
		var ww = $(window).width();
		if(ww >= 990){

			$('.horizontal-rect').css({
				'width': 430,
				'height': 200
			});

			$('.rect').css({
				'width': 430,
				'height': 430
			});

			$('.small-rect').css({
				'width': 200,
				'height': 200
			});

			$('.vertical-rect').css({
				'width': 200,
				'height': 430
			});

			$container = $('.items').isotope({
				layoutMode: 'masonryHorizontal',
				columnWidth: '.small-rect',
				itemSelector: '.item'
			});

		}else{
			var horRectWidth = ww;
			var horRectHeight = ((ww - 30) / 2).toFixed(2);

			var rectWidth = ww;
			var rectHeight = ww;

			var smallRectWidth = (ww / 2).toFixed(2);
			var smallRectHeight = (ww / 2).toFixed(2);

			var verRectWidth = (ww / 2).toFixed(2);
			var verRectHeight = ww;

			$('.horizontal-rect').css({
				'width': horRectWidth,
				'height': horRectHeight
			});

			$('.rect').css({
				'width': rectWidth,
				'height': rectWidth
			});

			$('.small-rect').css({
				'width': smallRectWidth,
				'height': smallRectHeight
			});

			$('.vertical-rect').css({
				'width': verRectWidth,
				'height': verRectHeight
			});
		}
	}

	jQuery(document).ready(function($) {
		setLayoutItemSizes();
	});

	$(window).on('load', function(){
		setLayoutItemSizes();
		var isRtl = $('body').hasClass('rtl') ? true : false;
		if(isRtl){
			$('.items').imagesLoaded( function(){
				$container = $('.items').isotope({
					 masonry: {
					    // use outer width of grid-sizer for columnWidth
					    columnWidth: '.small-rect'
					  },
					  itemSelector: '.item',
					  isOriginLeft: false,
					  transitionDuration: 0
				});
	        });
		}else{
			$('.items').imagesLoaded( function(){
				$container = $('.items').isotope({
					 masonry: {
					    // use outer width of grid-sizer for columnWidth
					    columnWidth: '.small-rect'
					  },
					  itemSelector: '.item',
					  transitionDuration: 0
				});
	        });
		}
	});

}(jQuery);

function blog(){
	$ = jQuery;
	var container = $('#blog_container .blog-items');
	 $(".loadMoreBtn").click(function(e){
        e.preventDefault();
		
        var loadBtnContainer = $('.load-more-container');
		loadBtnContainer.addClass('loading');

        page++;
        var ajax_data = {
            paged : page,
            sth_page : true
        };
        $.post(document.URL,ajax_data,function(data){
            if(data){
                $(data).imagesLoaded( function(){					
					$(container).append($(data));
					sr.init();
                });
                if(last_page == page ){
                    $("a.loadMoreBtn").fadeOut();
                }
                
                loadBtnContainer.removeClass('loading');
            }
		
        }).error(function(){
                jQuery("a.loadMoreBtn").fadeOut();
        });
        
    });
}

function blogmasonry(){
	$ = jQuery;
	var container = $('.blog-masonry-items');
	container.siblings('.load-more-container').find(".loadMoreBtn").click(function(e){
        e.preventDefault();
        var loadBtnContainer = $(this).parent();
        loadBtnContainer.addClass('loading');
        blog_page++;
        var ajax_data = {
        	"action": "sth_blog_masonry",
            "blog_page" : blog_page,
            "postID" : $('.blog-masonry-items').data("id")
        };
        $.post(ajax_url,ajax_data,function(data){
            if(data){
                $(data).imagesLoaded( function(){	
                	$(container).isotope( 'insert', $(data));
					$(document).trigger('itemsChanged');
					loadBtnContainer.removeClass('loading');			
                });

                if(blog_last_page == blog_page ){
                    container.siblings('.load-more-container').find(".loadMoreBtn").fadeOut();
                }
            }
		
        }).error(function(){
			container.siblings('.load-more-container').find(".loadMoreBtn").fadeOut();
        });
        
    });
}



//Project like & Iterate to add liked items	
function projectLike(){
	$ = jQuery;
	//Iterate to add liked items	
	$('.like').each(function(i, obj) {			
		if(readCookie('Viewed' + $(this).attr("data-id")) === $(this).attr("data-id"))
		{ 
			$(this).addClass('portfolio-active');
		}
	});

	//Project like
	$('body').on('click', '.like', function(e){	
		e.preventDefault();
		if($(this).hasClass('portfolio-active')){
			//$(this).removeClass('portfolio-active');
		}
		else{
			insert_like($(this).attr("data-id"));
			$(this).addClass('portfolio-active');
		}
	});	
}

function lightbox(container){
	$ = jQuery;
	var $id_of_post = $(container).data('id');

	// $('.modal-dialog').fadeOut(function(){
	// 	$('.modal-dialog').remove();
	// });
	var currentModal = $('.modal-dialog');
	currentModal.fadeOut(function(){
		currentModal.remove();
	});

	$('.modal-close').remove();
	
	$('.animation-container').addClass('loading');
	var ajax_lightbox = {
		id_of_post : $id_of_post,
		sth_ligthbox : true
	};

	$.post(document.URL, ajax_lightbox, function(data){

		if($(data).length>0){

			$(data).imagesLoaded( function(){

				console.log($(data));

				var content = $('.bs-example-modal-lg').html($(data).hide().fadeIn());

				var options = content.find('[data-owl-carousel]').data('owl-carousel-options');

				content.find('[data-owl-carousel]').owlCarousel(options);

				var slider = content.find('[data-owl-carousel]');

				slider.parent().find('.nav .prev').on('click', function(){
					if($('body').hasClass('rtl')){
						slider.trigger('next.owl.carousel', [300]);
					}else{
						slider.trigger('prev.owl.carousel', [300]);
					}
				});

				slider.parent().find('.nav .next').on('click', function(){
					if($('body').hasClass('rtl')){
						slider.trigger('prev.owl.carousel', [300]);
					}else{
						slider.trigger('next.owl.carousel', [300]);
					}
				});

				$('.animation-container').removeClass('loading');

				$('.modal-close').click(function(){
					$('.modal-dialog').remove();
				})

				$('.bs-example-modal-lg').on('hidden.bs.modal', function(){
					$('.modal-dialog').remove();	
				});
			});
		}
		}).error(function(){
		   console.log('error');
	});	
}

function loadMore(container,portfolio){
	$ = jQuery;
	// $('.button.loadMoreBtn').find('span').css('opacity', 0);
	// $('.button.loadMoreBtn').find('i').css('opacity', 1);
	var loadBtnContainer = $('.portfolio-items-container').find('.load-more-container');
	loadBtnContainer.addClass('loading');

	console.log($('.portfolio-items-container').data("id"));
    page++;
    var ajax_data = {
    	"action" : portfolio,
        "paged" : page,
        "postID" : $('.portfolio-items-container').data("id")
    };
    $.post(ajax_url,ajax_data,function(data){
        if(data){

            $(data).imagesLoaded( function(){					
				/*$(container).isotope( 'insert', $(data), function(){
					$(container).isotope( 'reLayout');
				})*/
           		$(container).append($(data));			
    //             $('.button.loadMoreBtn').find('span').css('opacity', 1);
				// $('.button.loadMoreBtn').find('i').css('opacity', 0);	
				$(document).trigger('itemsChanged');
				sr.init({delay: 'onload'});

	            if(last_page == page ){
	                loadBtnContainer.find("a.loadMoreBtn").fadeOut();
	            }
	            
		        loadBtnContainer.removeClass('loading');
            });
        }
	
    }).error(function(){
            loadBtnContainer.find("a.loadMoreBtn").fadeOut();
    });
}

function categorization(category,container,portfolio){
	$ = jQuery;
    var ajax_data = {
    	"action" : portfolio,
        "category" : category,
        "postID" : $('.portfolio-items-container').data("id")
    };  

    // fade out current elms
    var elements = $('.portfolio-item');
    elements.fadeOut(function(){
    	elements.remove();
    });

    $.post(ajax_url,ajax_data,function(data){
        if(data){
            $(data).imagesLoaded( function(){					
				/*$(container).isotope( 'insert', $(data), function(){
					$(container).isotope( 'reLayout');
				})*/
				$(container).html($(data));
				$(document).trigger('itemsChanged');
				// setTimeout(function(){
					sr.init();
				// }, 500)
				console.log("test2");
            });
            if(last_page == page ){
                container.siblings('.load-more-container').find("a.loadMoreBtn").fadeOut();
            }
        }
	
    }).done(function(){
    	console.log('test');
    })
    .error(function(){
		jQuery("a.loadMoreBtn").fadeOut();
    });
}

(function($){
	var isOnePage = $('body').is('#one-page') ? true : false;
	if(isOnePage){

		// Create a clone of the menu, right next to original.
		$('header').addClass('original').clone().insertAfter('header').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();

		scrollIntervalID = setInterval(stickIt, 10);

		function stickIt() {

			var orgElementPos = $('.original').offset();
			orgElementTop = orgElementPos.top;               

			if ($(window).scrollTop() >= (orgElementTop)) {
				// scrolled past the original position; now only show the cloned, sticky element.

				// Cloned element should always have same left position and width as original element.     
				orgElement = $('.original');
				coordsOrgElement = orgElement.offset();
				leftOrgElement = coordsOrgElement.left;  
				widthOrgElement = orgElement.css('width');
				$('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
				$('.original').css('visibility','hidden');
			} else {
				// not scrolled past the menu; only show the original menu.
				$('.cloned').hide();
				$('.original').css('visibility','visible');
			}
		}

		$('header .menu > li > a').on('click', function(e){
			e.preventDefault();
			var elToScroll = $(this).attr('href');
			if($(window).width() < 992){
				$('header > div.responsive-header .responsive-menu ul.menu').hide();
				$('html, body').scrollTop($(elToScroll).offset().top - 175)
			}else{
				$('html, body').animate({
					scrollTop: $(elToScroll).offset().top - 152
				}, 1000, "linear");
			}
		});

	}
})(jQuery);
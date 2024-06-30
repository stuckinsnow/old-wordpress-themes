
// window.addEventListener("load", function() { window. scrollTo(220, 220); });
// document.addEventListener("touchmove", function(e) { e.preventDefault() });

    jQuery.fn.hideReveal = function(options) {
      options = jQuery.extend({
        filter: '*',
        hiddenStyle: {
          opacity: 0.2
        },
        visibleStyle: {
          opacity: 1
        },
      }, options);
      this.each(function() {
        var $items = jQuery(this).children();
        var $visible = $items.filter(options.filter);
        var $hidden = $items.not(options.filter);
        // reveal visible
        $visible.animate(options.visibleStyle);
        // hide hidden
        $hidden.animate(options.hiddenStyle);
      });
    };
    jQuery(function($) {


 




      $('.main-carousel2').flickity({
        // options
        lazyLoad: true,
        draggable: false,
        // cellAlign: 'left',
        contain: true,
        fade: true,
        prevNextButtons: true,
        pageDots: true,
        autoPlay: false,
        wrapAround: true,
        initialIndex: 1,
      });
      $('.main-carousel').flickity({
        // setGallerySize: false, /* .main-carousel height */
        imagesLoaded: true,
        // lazyLoad: true,
        lazyLoad: 1, // load next 1 slide
        draggable: true,
        // selectedAttraction: 0.01,
        // friction: 0.15,
        prevNextButtons: false,
        adaptiveHeight: false,
        autoPlay: 6000,
        pauseAutoPlayOnHover: false,
        percentPosition: true,
        initialIndex: 1,
        fade: false,
      });

      /* if (jQuery(window).width() >= 1024) {

       var $carousel = $('.main-carousel');
       var $imgs = $carousel.find('.carousel-cell img');
      // get transform property
      var docStyle = document.documentElement.style;
      var transformProp = typeof docStyle.transform == 'string' ? 'transform' : 'WebkitTransform';
      // get Flickity instance
      var flkty = $carousel.data('flickity');

      $carousel.on('scroll.flickity', function() {
        flkty.slides.forEach(function(slide, i) {
          var img = $imgs[i];
          var x = (slide.target + flkty.x) * -1 / 3;
          img.style[transformProp] = 'translateX(' + x + 'px)';
        });
      });

      } */
      var $container = $('#portfolio'); //The ID for the list with all the blog posts
      var $container2 = $('.wp-block-gallery');
      filters = {};
      $container.imagesLoaded(function() {
        $container.isotope({
          itemSelector: '.portfolio-item',
          percentPosition: true,
          resizable: true,
          layoutMode: 'masonry', // masonry fitRows cellsByColumn cellsByRow vertical horizontal
          masonryHorizontal: {
            columnWidth: 1,
            rowHeight: 1,
            gutter: 1,
            rowHeight: 1
          },
          onLayout: function($container, instance) {},
          sortBy: 'attachments',
          /* visibleStyle: {
            opacity: 1,
            transform: 'translateX(0)',
          },
          hiddenStyle: {
            opacity: 0,
            transform: 'translateX(100vw)',
          }, */
          sortAscending: false,
          masonry: {
            columnWidth: '.portfolio-item',
            rowHeight: '.portfolio-item',
            gutter: '.gutter-sizer',
          }
        });
        $container2.isotope({
          itemSelector: '.gallery-item, .blocks-gallery-item',
          percentPosition: false,
          resizable: true,
          layoutMode: 'masonry', // masonry fitRows cellsByColumn cellsByRow vertical horizontal
          sortBy: 'attachments',
          visibleStyle: {
            opacity: 1,
            transform: 'translateX(0)',
          },
          hiddenStyle: {
            opacity: 0,
            transform: 'translateX(100vw)',
          },
          sortAscending: false,
          masonry: {
            columnWidth: '.gallery-item, .blocks-gallery-item',
            rowHeight: '.gallery-item, .blocks-gallery-item',
            gutter: 4
          }
        });
      });
      //$("#portfolio-page-wrap").mCustomScrollbar({
      //   axis:"x" // horizontal scrollbar
      //});
      var $container = $('#portfolio, .wp-block-gallery'); //The ID for the list with all the blog posts
      // init Isotope
      // layout Isotope after each image loads
      $container.imagesLoaded().progress(function() {
        console.log('relayout');
        $grid.isotope('layout');
      });
      var $grid = $('#portfolio').isotope({
        itemSelector: '.portfolio-item',
        getSortData: {
          lens: function(itemElem) {
            var lens = $(itemElem).find('.lens').text();
            return parseFloat(lens.replace(/Lens:/g, ''));
          },
          date: '.date parseInt',
          // date: function(itemElem) {
          //    var iso = $(itemElem).find('.date').text();
          //    return parseFloat(iso.replace(/Date:/g, ''));
          // },
          iso: function(itemElem) {
            var iso = $(itemElem).find('.iso').text();
            return parseFloat(iso.replace(/ISO:/g, ''));
          },
          aperture: function(itemElem) {
            var aperture = $(itemElem).find('.aperture').text();
            return parseFloat(aperture.replace(/Aperture: ƒ\//g, ''));
          },
          attachments: '.attachments parseInt'
        }
      });
      var $grid = $('.wp-block-gallery, #portfolio').isotope({
        itemSelector: '.gallery-item, .blocks-gallery-item, .portfolio-item',
      });
      $(window).resize(function() {
        $grid.isotope('layout');
        // $container.isotope( 'shuffle', function() {});  
      });
      $grid.on('click', '.gallery-item, .blocks-gallery-item', function() {
        // change size of item by toggling gigante class
        $(this).toggleClass('big');
        $grid.isotope('layout');
      });
      $(".portfolio-item").one("mouseover", function() {
        console.log('show scrollbar');
        $("#portfolio-page-wrap-bar").find('.mCSB_dragger').addClass("funstuff");
      });
      // init Isotope
      // bind sort button click
      $('.sort-by-button-group').on('click', 'div', function() {
        var sortValue = $(this).attr('data-sort-value');
        $grid.isotope({
          sortBy: sortValue,
          sortAscending: false
        });
      });
      // change is-checked class on buttons
      $('.button-group').each(function(i, buttonGroup) {
        var $buttonGroup = $(buttonGroup);
        $buttonGroup.on('click', 'div', function() {
          $buttonGroup.find('.is-checked').removeClass('is-checked');
          $(this).addClass('is-checked');
        });
      });
      $(function() {
        var $container = $('#portfolio'),
          $checkboxes = $('#filters input');
        $container.isotope({
          itemSelector: '.portfolio-item'
        });
        $checkboxes.change(function() {
          var filters = [];
          // get checked checkboxes values
          $checkboxes.filter(':checked').each(function() {
            filters.push(this.value);
          });
          filters = filters.join('');
          // $container.hideReveal({
          $container.isotope({
            filter: filters // +', .portfolio-item-fixed'
          });
        });
        $('#shuffle').click(function() {
          $container.isotope('shuffle');
          // $bug = Math.random().toString(16).substr(2);
          $bugs = [];
          $('<div class="shuffle-console-spam' + $bugs + '">Shuffling</div>')
            // $( '<div id="complete-' + $ving + '">No more images</div>' ).appendTo('#div-console').fadeTo(0, 0).fadeTo(2000, 1).fadeTo(6000, 0);
            .appendTo('#div-console').slideUp(0).slideDown(500).fadeTo(0, 1).fadeTo(1000, 1).fadeTo(1000, 0);
          setTimeout(function() {
            $('.shuffle-console-spam' + $bugs + '').remove();
          }, 2500);
          $(".button-group").find('.is-checked').removeClass("is-checked");
          console.log('#shuffle-console-spam' + $bugs + '');
        });
        $('#remove-all').click(function() {
          var filtersremove = [];
          filtersremove = filtersremove.join('');
          $container.isotope({
            filter: filtersremove
          });
          $('input:checkbox').prop('checked', false);
        });
        /* this is my header .button */
        var $page = $('.site');
        var $pagee = $('.site-header-menu');
        var $pageee = $('#menu-toggle-pc, #cornerdiv');
        var $pageeee = $('#perspective');
        var self = $('body');
        $('#menu-toggle-pc').on('click', function() {
          if ($('#menu-toggle-pc').hasClass('toggled-on')) {
            console.log('yooopi');
            setTimeout(function() {
              /* self.removeClass("button-scroll-up"); */
            }, 450)
          }
          if ($('#perspective').hasClass('contacty')) {
            $('#perspective').removeClass('contacty');
            console.log('he-gooooooooo');
            return;
          }
          if ($pageee.hasClass('button-scroll-up')) {
            console.log('yooopoo');
            var body = $("html, body");
            body.stop().animate({
              scrollTop: 0
            }, 45, 'swing', function() {
              console.log('scroll up');
              /* $('#menu-toggle-pc').toggleClass('toggled-on');
              $pagee.removeClass('toggled-on');
              $page.removeClass('toggled-on');
              self.removeClass('toggled-on'); */
              setTimeout(function() {
                /* self.removeClass("button-scroll-up"); */
                $pageeee.addClass('toggled-on');
                $pageee.addClass('toggled-on');
                $pagee.addClass('toggled-on');
                $page.addClass('toggled-on');
                self.addClass('toggled-on');
              }, 200)
            });
          }
          else {
            $pageeee.toggleClass('toggled-on');
            $pageee.toggleClass('toggled-on');
            $pagee.toggleClass('toggled-on');
            $page.toggleClass('toggled-on');
            self.toggleClass('toggled-on');
          }
        });
        /* $('#button-scroll-up').on('click', function() {
          var body = $("html, body");
          body.stop().animate({
            scrollTop: 0
          }, 450, 'swing', function() {
            console.log('scroll up');
          });
        }); */
        $('.site-content').on('click', function() {
          if ($('#perspective').hasClass('contacty')) {
            $('#perspective').removeClass('contacty');
            return;
          }
          else {
            $page.removeClass('toggled-on');
            $pagee.removeClass('toggled-on');
            $pageee.removeClass('toggled-on');
            $pageeee.removeClass('toggled-on');
            self.removeClass('toggled-on');
          }
        });
        $('.leaf-title').on('click', function() {
          if ($('#perspective').hasClass('contacty')) {
            $('#perspective').removeClass('contacty');
            console.log('he-gooooooooo');
          }
          else {
            console.log('he-nooooooooot');
            $('#perspective').addClass('contacty');
          }
        });
        var scrolly = false;
        var debounce_timer;
        $(window).scroll(function() {
          if (debounce_timer) {
            window.clearTimeout(debounce_timer);
          }
          debounce_timer = window.setTimeout(function() {
            // run your actual function here
            console.log('Fire');
            if (document.body.scrollTop < 350 || document.documentElement.scrollTop < 350) {
              scrolly = false;
            }
            if (document.body.scrollTop > 350 || document.documentElement.scrollTop > 350) {
              scrolly = true;
              if ($('#perspective').hasClass('contacty')) {
                /* $('#page').removeClass('contacty');
                console.log('he-gooooooooo scrolly'); */
                return;
              }
              else {
                $page.removeClass('toggled-on');
                $pagee.removeClass('toggled-on');
                $pageee.removeClass('toggled-on');
                $pageeee.removeClass('toggled-on');
              }
              self.removeClass('toggled-on');
              if (scrolly === true) {
                if ($pageee.hasClass('button-scroll-up')) {
                  console.log('he-go');
                }
                else {
                  console.log('he-not');
                  $pageee.addClass('button-scroll-up');
                }
              }
            }
            else {
              $pageee.removeClass('button-scroll-up');
            }
            console.log('bob');
          }, 100);
        });
        $('.content').on('click', function() {
          $page.removeClass('shazam');
        });
        $('.load-more-button').on('click', function(e) {
          /* $('.load_more_cont a').live('click', function(e) { */
          // var $that = $(this),
          //     url = $that.attr('data-href'),
          //   nextPage = parseInt($that.attr('data-page'), 10) + 1,
          // maxPages = parseInt($that.attr('data-max-pages'), 10);
          e.preventDefault();
          $ving = Math.random().toString(16).substr(2);
          if ($(this).hasClass('loading')) {
            // $('#div-console').text('I am busy loading content right now');
            $('<div class="loading-console-spam">I am busy loading content right now</div>').appendTo('#div-console').slideUp(0).slideDown(500).fadeTo(0, 1).fadeTo(1000, 1).fadeTo(1000, 0);
            return;
            // alert("Don't click me bro, I'm loading stuff");
          }
          $(this).addClass('loading').text('Loading...');
          $.ajax({
            type: "GET",
            url: $('.nextpostslink').prop('href'),
            dataType: "html",
            success: function(out) {
              // result = $(out).find('#portfolio .portfolio-item');
              result = $(out).find('.portfolio-item');
              nextlink = $(out).find('.nextpostslink').prop('href');
              result.imagesLoaded(function() {
                $container.prepend(result);
                $container.isotope('insert', result);
                $container.isotope('layout');
                // $('#portfolio').append(result).isotope('prepended', result);
                //     $('#portfolio').append(result);
                setTimeout(function() {
                  console.log('success');
                  $('.loading-console-spam').remove();
                }, 2000)
                $('.load-more-button').removeClass('loading').text('ready');
                if (nextlink != undefined) {
                  $('.nextpostslink').prop('href', nextlink);
                }
                else {
                  $('.load-more-button').remove();
                  // $('#div-console').text('No more images');
                  $('<div class="complete-console-spam">No more images</div>').appendTo('#div-console').slideUp(0).slideDown(500).fadeTo(0, 1).fadeTo(1000, 1).fadeTo(2000, 0);
                  // $( '<div id="complete-' + $ving + '">No more images</div>' ).appendTo('#div-console').fadeTo(0, 0).fadeTo(2000, 1).fadeTo(6000, 0);
                  // console.log('#complete-' + $ving + '');
                  setTimeout(function() {
                    $('.complete-console-spam').remove();
                  }, 3000);
                  $('#div-input').append('<label id="' + $ving + '" class="filters">No More</label>');
                }
              });
            }
          });
        }).resize(); // This will simulate a resize to trigger the initial run.
        // });  
      });

      if ($('body').hasClass('home')) {
      jQuery(document).ready(myfunction);
      jQuery(window).on('resize', myfunction);
      function myfunction() {
        if (jQuery(window).width() >= 1020) {
          console.log('bobbbbbbby');
          var scrollTimeout;
          var throttle = 20;
          var scrollMessage = function(message) {
            console.log(message);
          };
          $(window).on('scroll', function() {
            if (!scrollTimeout) {
              scrollTimeout = setTimeout(function() {
                if ($('body').hasClass('home')) {
                  myFunction()
                }
                scrollMessage('throttled scroll');
                scrollTimeout = null;
              }, throttle);
            }
            // console.log('native scroll');
          });
          if ($('body').hasClass('home')) {
            var header = document.getElementById("snappy");
            var sticky = header.offsetTop;
          }

          function myFunction() {
            if (window.pageYOffset > sticky) {
              header.classList.add("sticky");
              $('#perspective').removeClass('perspective-on');
              $('#perspective').addClass('perspective-off');
              // console.log('bb');
            }
            else {
              header.classList.remove("sticky");
              $('#perspective').addClass('perspective-on');
              $('#perspective').removeClass('perspective-off');
              // console.log('aa');
            }
          }
        }
      }
      console.log('hashome');
    }
    });
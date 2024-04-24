jQuery(function($) {
    var $container = $('#load-container'); //The ID for the list with all the blog posts
    filters = {};
    $container.imagesLoaded(function() {
        $container.isotope({
            itemSelector: '.type-post, .big_post, .big_post_fixed',
            percentPosition: true,
            resizable: true,
            layoutMode: 'vertical' // masonry fitRows cellsByColumn cellsByRow vertical horizontal
            // sortBy: 'attachments'
        });
    });
    $(document).ready(function() {
        // init Isotope

        // layout Isotope after each image loads
        $container.imagesLoaded().progress(function() {
            console.log('relayout');
            $grid.isotope('layout');
        });

        setTimeout(function() {
            $grid.isotope('layout');
        }, 400);
        var $grid = $('#load-container').isotope({
            itemSelector: '.type-post, .big_post, .big_post_fixed',
        });
        $grid.on('layoutComplete',
            function(event, laidOutItems) {
                console.log('Isotope layout completed on ' +
                    laidOutItems.length + ' items');
            }
        );
        $grid.on('click', '.big_post, .type-post', function() {
            // change size of item by toggling gigante class
            $(this).toggleClass('post_box_gigantic');
            $grid.isotope('layout');
        });


        $('.load-button a').on('click', function(e) {
            e.preventDefault();
            if ($(this).hasClass('loading')) {
                return;
            }
            $(this).addClass('loading').text('Loading...');
            $.ajax({
                type: "GET",
                url: $(this).prop('href') + '#load-container',
                dataType: "html",
                success: function(out) {
                    result = $(out).find('#load-container .type-post');
                    nextlink = $(out).find('.load-button a').prop('href');
                    result.imagesLoaded(function() {
                        $('#load-container').prepend(result);
                        $('#load-container').isotope('insert', result);
                        $('#load-container').isotope('layout');
                        $('.load-button a').removeClass('loading').text('Load more posts');
                        if (nextlink != undefined) {
                            $('.load-button a').prop('href', nextlink);
                        } else {
                            $('.load-button a').remove();
                            $grid.isotope('layout');
                        }
                    });
                }
            });
        });

    });

    var $container = $('#portfolio, #singleportfolio-primary'); //The ID for the list with all the blog posts
    filters = {};
    $container.imagesLoaded(function() {
        $container.isotope({
            itemSelector: '.portfolio-item',
            percentPosition: true,
            resizable: true,
            layoutMode: 'masonry', // masonry fitRows cellsByColumn cellsByRow vertical horizontal
            masonry: {
                // columnWidth: $container.width() / 3,
                columnWidth: '.portfolio-item',
                rowHeight: '.portfolio-item',
                gutter: 0
            }
            // sortBy: 'attachments'
        });
    });
    $(document).ready(function() {
        // init Isotope
        var $grid = $('#portfolio').isotope({
            itemSelector: '.portfolio-item',
            getSortData: {
                lens: function(itemElem) {
                    var lens = $(itemElem).find('.lens').text();
                    return parseFloat(lens.replace(/Lens:/g, ''));
                },
                //  date: '.date parseInt',
                date: '.date',
                category: '[data-category]',
                weight: function(itemElem) {
                    var weight = $(itemElem).find('.weight').text();
                    return parseFloat(weight.replace(/[\(\)]/g, ''));
                },
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
        });
        // (function($) {
        // Ajax-fetching "Load more posts"
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
                $('<div class="loading-console-spam">I am busy loading content right now</div>')
                    .appendTo('#div-console').slideUp(0).slideDown(500).fadeTo(0, 1).fadeTo(1000, 1).fadeTo(1000, 0);
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
                        } else {
                            $('.load-more-button').remove();
                            // $('#div-console').text('No more images');
                            $('<div class="complete-console-spam">No more images</div>')
                                .appendTo('#div-console').slideUp(0).slideDown(500).fadeTo(0, 1).fadeTo(1000, 1).fadeTo(2000, 0);
                            // $( '<div id="complete-' + $ving + '">No more images</div>' ).appendTo('#div-console').fadeTo(0, 0).fadeTo(2000, 1).fadeTo(6000, 0);
                            // console.log('#complete-' + $ving + '');
                            setTimeout(function() {
                                $('.complete-console-spam').remove();
                            }, 3000);
                            $('#the-add-bug').append('<label id="' + $ving + '" class="filters">Finished</label>');
                        }
                    });
                }
            });
        });
    });
    $(window).resize(function() {
        // $container.isotope('shuffle', function() {});
    });

     
    $(".gallery-icon a, .fancybox-content, .openbox, a[rel^='attachment'], a[rel^='gallery'], a[data-fancybox-group^='fancybox']").fancybox({
        // maxWidth: 4000,
        // maxHeight: 3000,
        fitToView: true,
        padding: 0,
        margin: 0,
        // width: '100%',
        // height: '100%',
        position: 'top',
        autoSize: true,
        openOpacity: true,
        closeOpacity: true,
        nextSpeed: 800,
        closeSpeed: 100,
        openSpeed: 300,
        prevSpeed: 100,
        openEffect: 'fade',
        closeEffect: 'fade',
        nextEffect: 'fade',
        prevEffect: 'fade', 
        helpers: {
            overlay: {
                showEarly: true,
                speedIn: 300,
                speedOut: 200
            },
            title: {
                type: 'outside',
            },
            thumbs: {
                //  width : 50,
                //  height  : 50
            }
        } 
    }).attr('rel', 'gallery', 'attachment');
});

// jQuery(function($) {

// $( '#site-navigation' ).find( '.dropdown-toggle' ).click( function(e) {
//         e.preventDefault();

//         $( '#site-navigation' ).find( 'li' ).not( $(this).parents() ).removeClass( 'open' );
//         $(this).parent().toggleClass( 'open' );
//     } );

// });


jQuery(function($) {
    // external js: isotope.pkgd.js
    $(document).ready(function() {
        // make <div class="grid-item grid-item--width# grid-item--height#" />
        function getItemElement() {
            var $item = $('<div class="portfolio-item"></div>');
            // add width and height class
            var wRand = Math.random();
            var hRand = Math.random();
            var widthClass = wRand > 0.85 ? 'portfolio-item--width3' : wRand > 0.7 ? 'portfolio-item--width2' : '';
            var heightClass = hRand > 0.85 ? 'portfolio-item--height3' : hRand > 0.5 ? 'portfolio-item--height2' : '';
            $item.addClass(widthClass).addClass(heightClass);
            return $item;
        }
    });
 
});
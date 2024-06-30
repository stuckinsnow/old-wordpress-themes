tips callto error can be because jquery needs updating

page-portfolio above galleryfloat



        <div class="excerpt">
        <div class="countcontainer">
        <p>
      

      <?php // Get the images attached to the post
  $images = get_children( array(
    'post_parent' => $post->ID,
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'numberposts' => 999
));

// If there are images, count them and display the number of images
if ( $images ) {
    $total_images = count( $images );
    echo $total_images;
} ?>



        </p>
        
          <div class="gallerytitle"><?php echo substr(get_the_title(),0,10); ?></div>
          <?php echo substr(get_the_excerpt(),0,15); ?>
          
        </div>

</div>
    <?php /*    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"> */ ?>





isotope



.excerpt {

background-color: #2A2A2A;
border-width: 1px;
border-color: #000000;
border-style: solid;
border-top-width: 1px;
border-bottom-width: 1px;
color: #ffffff;
font-size: small;
font-family: 'Annie Use Your Telescope', cursive;
position: absolute;
background-color: rgba(0, 0, 0, 0);
/* display: none; */
content: '';
transition: all .5s ease-in-out; 
height: 100%;
width: 100%;
opacity: 0;
z-index: 20;
}

.excerpt:hover {
background-color: rgba(10, 0, 0, .4); 
z-index: 1;
 -moz-box-shadow: inset 0 0 50px #000000;  
 -webkit-box-shadow: inset 0 0 50px #000000;   
 box-shadow: inset 0 0 50px #000000;
 opacity: 1;
}

.excerpt p {
  opacity: 1;
  height: 50%;
  width: 100%;
  float: left;
  border: 1px;
  border-style: dashed;
  border-color: #ffffff;
}

.gallerytitle {
    display: block;
/*
    background-color: #2A2A2A;
*/
    border-width: 1px;
    border-style: solid;
    border-color: #ffffff;
    border-top-width: 1px;
    border-bottom-width: 1px;
    color: #CCFF00;
    font-size: large;
    height: 25%;
    opacity: 1;
}










function lightbox() {
 
    // Our Lightbox functioning will be added now...
 
}
 
if(jQuery().fancybox) {
    lightbox();
}

$("a[rel^='fancybox']").fancybox({
    maxWidth  : 800,
    maxHeight : 600,
    fitToView : true,
    width   : '70%',
    height    : '70%',
    autoSize  : true,
    closeClick  : false,
    openEffect  : 'fade',
    closeEffect : 'fade',
    prevEffect    : 'fade',
    nextEffect    : 'fade',
    nextSpeed : 150,
    closeSpeed : 150,
    openSpeed : 150,
    helpers : {
      title : {
        type: 'inside'
      },
      thumbs  : {
        width : 50,
        height  : 50
      }
    }

  });

});









change this line to put the thumbs as part of the overlay

line 60

this.wrap = $('<div id="fancybox-thumbs"></div>').addClass(opts.position).appendTo('body');
this.wrap = $('<div id="fancybox-thumbs"></div>').addClass(opts.position).appendTo('.fancybox-overlay');

line 139

if (this.wrap) {this.wrap.appendTo('.fancybox-wrap');}

add this to thumbs

it goes below 

this.list.children().removeClass('active').eq(obj.index).addClass('active');

this

create fade to for thumbs

line 141

if (this.wrap) {this.wrap.fadeTo(100, 0.4).fadeTo(200, 0).fadeTo(200, 0.4).fadeTo(200, 1);}

line 57

style="width:' + thumbWidth + 'px;height:' + thumbHeight + 'px;"

line 1730

this.overlay.fadeIn(opts.speedIn, $.proxy( this ));

create fade in for main

line 1692

speedIn : 400

line 97

$(this).css({
              width  : width,
              height : height,
            //  top    : Math.floor(thumbHeight / 2 - height / 2), // remove if you want images to be relative to bullet point
            //  left   : Math.floor(thumbWidth / 2 - width / 2) // important if you want images in same position
          });

add comment to change images

line 104

  //        parent.width(thumbWidth).height(thumbHeight);

add comment











(function($){

// Ajax-fetching "Load more posts"


$('.nextpostslink').live('click', function(e) {
/* $('.load_more_cont a').live('click', function(e) { */

 // var $that = $(this),
   //     url = $that.attr('data-href'),
     //   nextPage = parseInt($that.attr('data-page'), 10) + 1,
       // maxPages = parseInt($that.attr('data-max-pages'), 10);

  e.preventDefault();

  //$(this).addClass('loading').text('Loading...');

  $.ajax({

    type: "GET",

    url: $(this).attr('href') + '#content',

    dataType: "html",

    success: function(out) {

      result = $(out).find('#portfolio .portfolio-item');
    nextlink = $(out).find('.nextpostslink').attr('href'); 

      $('#portfolio').append(result).isotope('prepended', result);

               //     $('#portfolio').append(result);

      //$('.fetch a').removeClass('loading').text('Load more posts');

      if (nextlink != undefined) {

        $('.nextpostslink').attr('href', nextlink);

      } else {

        $('.nextpostslink').remove();

                                $('#portfolio').append('<div class="clear"></div>');

                              //  $('.load_more_cont').css('visibilty','hidden');

      }


         /*           if (nextlink != undefined) {

                        $.get(nextlink, function(data) {
                         // if ( nextPage == maxPages ) {

                         if ($('.load_more_cont .load_more_text:contains("Load")').length > 0) {

                         // if($(data + ":contains('post_box')") != '') {

                          alert('not found');
                                                    $('.load_more_cont').remove();

                                                    $('#portfolio').append('<div class="clear"></div>');        

                          } 
                        });                        

                    } */



                        

    } 

  });

});

})(jQuery);
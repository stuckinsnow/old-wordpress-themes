<?php
/**

 */

get_header(); ?>

	<div id="primary" class="content-area">
        

		<main id="main" class="site-main" role="main">

<!--  	<div class="main-carousel"
  data-flickity='{ "wrapAround": true }'> -->


<div class="main-carousel">


<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args  = array(
    'post_type' => 'homephotos',
    'posts_per_page' => '12',
    'paged' => $paged
);
$loop  = new WP_Query($args);
while ($loop->have_posts()):
    $loop->the_post();
	echo '<div class="carousel-cell">';
    // echo substr(get_the_excerpt(), 0, 2000);
    $home_meta = get_post_meta($post->ID, 'home_meta', true);

    echo '<div class="home-about hide-mobile">';
    // echo $home_meta;
    echo '</div>';


    echo '<div class="home-title">';
    the_title();
    echo '</div>';

    $large_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' );
    $large_image = $large_image[0];
    // the_post_thumbnail( 'fullsize',["class" => "carousel-cell-image"] );

   


    echo '<img class="carousel-cell-image" data-flickity-lazyload="'. $large_image .'">';
    echo '</div>';
endwhile;
?>
 
</div>

<div id="side-info" class="hide-mobile">

    <div>
        <h2>A title</h2>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Euismod lacinia at quis risus sed vulputate odio ut. Etiam erat velit scelerisque in. Habitasse platea dictumst quisque sagittis purus.

        <br><br> Dignissim enim sit amet venenatis urna cursus. Fusce id velit ut tortor pretium viverra suspendisse potenti. Facilisis volutpat est velit egestas dui id. Urna neque viverra justo nec ultrices. Faucibus scelerisque eleifend donec pretium vulputate sapien. Tortor aliquam nulla facilisi cras fermentum. Rhoncus dolor purus non enim praesent elementum facilisis leo vel. Eu sem integer vitae justo eget magna. Ornare aenean euismod elementum nisi quis eleifend quam adipiscing. Non odio euismod lacinia at quis. Morbi leo urna molestie at elementum eu. Odio euismod lacinia at quis risus sed vulputate. Odio eu feugiat pretium nibh. Accumsan lacus vel facilisis volutpat est velit egestas. Suscipit tellus mauris a diam.
    </div>
</div>

<div id="home-contact-left" class="hide-mobile">
    <div><a href="<?php echo get_site_url(); ?>/about/">About</a></div>
    <div><a href="<?php echo get_site_url(); ?>/contact/">Contact</a></div>
</div>

<!-- <div class="home-h2">
    <h2>Information</h2>
</div> -->

<?php 
echo '<div class="home-about-lower">';
 
while ($loop->have_posts()):
    $loop->the_post();


$home_meta2 = get_post_meta($post->ID, 'home_meta2', true);
$home_meta3 = get_post_meta($post->ID, 'home_meta3', true);


    echo $home_meta2;
    echo $home_meta3;


endwhile;

/* echo '</div>';
echo '<div id="home-contact-form" class="contact-form">';
echo do_shortcode("[sitepoint_contact_form]"); 
echo '</div>'; */


?>




		
	</div><!-- .content-area -->
    </main><!-- .site-main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

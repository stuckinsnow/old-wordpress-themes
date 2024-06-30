<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Philip_Clear
 * @since Philip Clear 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">


		<main id="main" class="site-main" role="main">

<div class="main-carousel">


<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args  = array(
    'post_type' => 'portfolio',
    'posts_per_page' => '12',
    'paged' => $paged
);
$loop  = new WP_Query($args);
while ($loop->have_posts()):
    $loop->the_post();
    echo '<div class="carousel-cell">';
    // echo substr(get_the_excerpt(), 0, 2000);
    $home_meta = get_post_meta($post->ID, 'home_meta', true);

    // echo '<div class="home-about hide-mobile">';
    // echo $home_meta;
    // echo '</div>';


    // echo '<div class="home-title">';
    // the_title();
    // echo '</div>';

    $large_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' );
    $large_image = $large_image[0];
    // the_post_thumbnail( 'fullsize',["class" => "carousel-cell-image"] );

   


    echo '<img class="carousel-cell-image" data-flickity-lazyload="'. $large_image .'">';
    echo '</div>';
endwhile;
?>
 
</div>





        <div id="pagenavi">
    <?php
        if (function_exists('wp_pagenavi')) {
            wp_pagenavi(array(
            'query' => $loop));
        wp_reset_postdata();
    }
    ?>
        </div><!-- pagenavi -->

    <?php
    wp_reset_query();
    ?>  





<div id="home-container">





<div id="home-cat">
    <div id="infogo">Recently modified pages</div>
 <ul>
<?php
//Number of pages
$nbpages = 6;
//Storage and query results
$pages = wp_list_pages("title_li=&depth=-1&sort_column=post_modified&sort_order=DESC&echo=0");
//display
$pages_arr = explode("\n", $pages);
for($i=0;$i<$nbpages;$i++){
echo $pages_arr[$i];
}
?>
 
    </ul>
</div>





    <div id="iblogp" class="pc-only">Recent Blog Posts</div>
<div id="load-container">

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<?php
			// Start the loop.
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content-home', get_post_format() );

			// End the loop.
			endwhile;

			// Previous/next page navigation.
			// the_posts_pagination( array(
			//	'prev_text'          => __( 'Previous page', 'philipclear' ),
			//	'next_text'          => __( 'Next page', 'philipclear' ),
		    //  	'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'philipclear' ) . ' </span>',
			// ) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>
</div>

</div>





<div id="more-buttons">
<div class="load-button"><?php next_posts_link('Load More Posts') ?></div>









	</div><!-- .content-area -->

</main><!-- .site-main -->


</div><!-- .content-area -->



<?php // get_sidebar(); ?>
<?php get_footer(); ?>

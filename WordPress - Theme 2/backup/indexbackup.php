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










    <div id="portfolio-page">
    <div id="portfolio">
    
    <?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args  = array(
    'post_type' => 'homephotos',
    'posts_per_page' => '3',
    'paged' => $paged
);
$loop  = new WP_Query($args);
while ($loop->have_posts()):
    $loop->the_post();
    
     
    
    
?>
<?php
     
    
    echo '<div class="portfolio-item">';
    echo '<div class="portfolio-item-writing">';
    echo '<div class="portfolio-item-writing-title">';
    the_title();
    echo '</div>';
    echo '<div class="portfolio-item-writing-attachments">';
    echo '<div>';
    echo '<span class="attachments">';
    echo '</span>';
    echo '</div>';
    echo '<p data-fancybox-group="fancybox['. $post->ID .']">';
    // echo substr(get_the_excerpt(), 0, 200);
    echo '</p>';

    echo '</div>'; // portfolio-item-writing-attachments
    
    echo '</div>';
    $large_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '');
    $large_image = $large_image[0];
    echo '<a data-fancybox-group="fancybox['. $post->ID .']" href="'. $large_image .'"
    title="">';
    // '. substr(get_the_excerpt(), 0, 300) .'

?>

<div class="portfolio-item-thumbnail">
    <?php
    the_post_thumbnail();
?>
</div>

<?php
    echo '</a>';
?>


        <?php
    
    
    echo '</div>';
endwhile;
?>


</div>
    </div><!-- #portfolio -->
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
 <ul>
    <?php wp_list_categories('title_li=');( array(
        'orderby'    => 'name',
        'show_count' => true,
        'exclude'    => array( 20 )
    ) ); ?> 
    </ul>
</div>





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

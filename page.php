<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Philip_Clear
 * @since Philip Clear 1.0
 */

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}

			// End of the loop.
		endwhile;
		?>
<div id="page-list">
<?php if( ! $post->post_parent ) {
    // Will display the subpages of this top level page.
    $children = wp_list_pages( array(
        'title_li' => '',
        'child_of' => $post->ID,
        'echo'     => 0
    ) );
} else {
    if ( $post->ancestors ) {
        /*
         * Now you can get the the top ID of this page. WordPress is putting the ids DESC,
         * thats why the top level ID is the last one.
         */
        $ancestors = get_post_ancestors( $this_page );
        $children  = wp_list_pages( array(
            'title_li' => '',
            'child_of' => $ancestors,
            'echo'     => 0
        ) );
    }
}
 
if ( $children ) : ?>
    <ul>
        <?php echo $children; ?>
    </ul>
<?php endif; ?>
</div>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
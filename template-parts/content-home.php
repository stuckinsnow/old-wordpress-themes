<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Philip_Clear
 * @since Philip Clear 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-header">
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
			<div class="sticky-post"><?php _e( 'Featured', 'philipclear' ); ?></div>
		<?php endif; ?>

		<?php the_title( sprintf( '<div class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' ); ?>


		<?php philipclear_entry_meta(); ?>


	</div><!-- .entry-header -->

	<!-- .entry-content -->

	
</article><!-- #post-## -->

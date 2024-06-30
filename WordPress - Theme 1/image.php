<?php
/**
 * The template for displaying image attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
				// Start the loop.
			while ( have_posts() ) :
				the_post();
				?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<nav id="image-navigation" class="navigation image-navigation">
					<div class="nav-links">
						<div class="nav-previous"><?php previous_image_link( false, __( 'Previous Image', 'twentysixteen' ) ); ?></div>
						<div class="nav-next"><?php next_image_link( false, __( 'Next Image', 'twentysixteen' ) ); ?></div>
					</div><!-- .nav-links -->
				</nav><!-- .image-navigation -->

				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
				</header><!-- .entry-header -->

				<div class="entry-content">

					<div class="entry-attachment">
						<?php
							/**
							 * Filter the default twentysixteen image attachment size.
							 *
							 * @since Twenty Sixteen 1.0
							 *
							 * @param string $image_size Image size. Default 'large'.
							 */
							$image_size = apply_filters( 'twentysixteen_attachment_size', 'large' );

							echo wp_get_attachment_image( get_the_ID(), $image_size );
						?>

						<?php twentysixteen_excerpt( 'entry-caption' ); ?>

						</div><!-- .entry-attachment -->

						<!-- To display thumbnail of previous and next image in the photo gallery -->
<div style="float:right;">
      <?php next_image_link() ?>
</div><?php previous_image_link() ?><br />

<!-- To display current image in the photo gallery -->
<div style="text-align: center;">
      <a href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image( $post->ID, 'medium' ); ?></a>
</div><br />

<!-- Using WordPress functions to retrieve the extracted EXIF information from database -->
<div style="padding:5px 0 5px 20px;border:1px dotted;">
   <?php
      $imgmeta = wp_get_attachment_metadata( $id );




      $exif = wp_get_attachment_metadata( $post_id );
		echo '<pre>';
		print_r( $exif );
		echo '</pre>';




// Convert the shutter speed retrieve from database to fraction
      if ((1 / $imgmeta['image_meta']['shutter_speed']) > 1)
      {
         if ((number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1)) == 1.3
         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.5
         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 1.6
         or number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1) == 2.5){
            $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 1, '.', '') . " second";
         }
         else{
           $pshutter = "1/" . number_format((1 / $imgmeta['image_meta']['shutter_speed']), 0, '.', '') . " second";
         }
      }
      else{
         $pshutter = $imgmeta['image_meta']['shutter_speed'] . " seconds";
       }

// Start to display EXIF and IPTC data of digital photograph
       echo "Date Taken: " . date("d-M-Y H:i:s", $imgmeta['image_meta']['created_timestamp'])."<br />";
       echo "Copyright: " . $imgmeta['image_meta']['copyright']."<br />";
       echo "Credit: " . $imgmeta['image_meta']['credit']."<br />";
       echo "Title: " . $imgmeta['image_meta']['title']."<br />";
       echo "Caption: " . $imgmeta['image_meta']['caption']."<br />";
       echo "Camera: " . $imgmeta['image_meta']['camera']."<br />";
       echo "Focal Length: " . $imgmeta['image_meta']['focal_length']."mm<br />";
       echo "Aperture: f/" . $imgmeta['image_meta']['aperture']."<br />";
       echo "ISO: " . $imgmeta['image_meta']['iso']."<br />";
       echo "Shutter Speed: " . $pshutter . "<br />"
   ?>
</div>
      
<?php if ( !empty($post->post_excerpt) ) the_excerpt(); ?><br />

<a href="<?php echo get_permalink($post->post_parent); ?>" rev="attachment"><?php echo get_the_title($post->post_parent); ?> </a>
					</div><!-- .entry-content -->

					<footer class="entry-footer">
					<?php twentysixteen_entry_meta(); ?>
						<?php
						// Retrieve attachment metadata.
						$metadata = wp_get_attachment_metadata();
						if ( $metadata ) {
							printf(
								'<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
								esc_html_x( 'Full size', 'Used before full size attachment link.', 'twentysixteen' ),
								esc_url( wp_get_attachment_url() ),
								absint( $metadata['width'] ),
								absint( $metadata['height'] )
							);
						}
						?>
						<?php
						edit_post_link(
							sprintf(
								/* translators: %s: Name of current post */
								__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
								get_the_title()
							),
							'<span class="edit-link">',
							'</span>'
						);
						?>
					</footer><!-- .entry-footer -->
				</article><!-- #post-## -->

				<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}

				// Parent post navigation.
				the_post_navigation(
					array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
					)
				);
				// End the loop.
				endwhile;
			?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

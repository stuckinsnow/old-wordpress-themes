<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
	 


<div id="" class="phone-only homephone">
    <div><a href="<?php echo get_site_url(); ?>/about/">About</a></div>
    <div><a href="<?php echo get_site_url(); ?>/contact/">Contact</a></div>
</div>


			<div class="site-info">
				 
				<?php
				if ( function_exists( 'the_privacy_policy_link' ) ) {
					// the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
					the_privacy_policy_link( '', '' );
				}
				?>
			 
			</div><!-- .site-info -->


		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->




</div><!-- .perspective-on -->

<?php wp_footer(); ?>




</body>
</html>

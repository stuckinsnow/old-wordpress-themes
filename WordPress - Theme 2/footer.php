<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Philip_Clear
 * @since Philip Clear 1.0
 */
?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer" role="contentinfo">

			<?php if ( has_nav_menu( 'social' ) ) : ?>
				<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'philipclear' ); ?>">
					<?php
						wp_nav_menu( array(
							'theme_location' => 'social',
							'menu_class'     => 'social-links-menu',
							'depth'          => 1,
							'link_before'    => '<span class="screen-reader-text">',
							'link_after'     => '</span>',
						) );
					?>
				</nav><!-- .social-navigation -->
			<?php endif; ?>













			<div class="site-info">
				<?php
					/**
					 * Fires before the philipclear footer text for footer customization.
					 *
					 * @since Philip Clear 1.0
					 */
					do_action( 'philipclear_credits' );
				?>
				<span class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></span>
				<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'philipclear' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'philipclear' ), 'WordPress' ); ?></a>
				<div id="privacy">
				<a href="http://photochirp.com/privacy-policy/">Privacy Policy</a>
				</div>
			</div><!-- .site-info -->

		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>





<div id="amzn-assoc-ad-c792684f-4e93-403f-83a2-3cff4e53575a"></div><script async src="//z-na.amazon-adsystem.com/widgets/onejs?MarketPlace=US&adInstanceId=c792684f-4e93-403f-83a2-3cff4e53575a"></script>




</body>
</html>

<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Philip_Theme
 * @since Philip Theme
 */
?>
<div id="sidebar-nicebar">

	<?php
		$description = get_bloginfo( 'description', 'display' );
		if ( ! empty ( $description ) ) :
	?>
	<!-- <h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
	<?php endif; ?> -->

	<?php if ( has_nav_menu( 'secondary' ) ) : ?>
	<nav role="navigation" class="navigation site-navigation secondary-navigation">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>
	</nav>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-2' ) ) : ?>
<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	
</div><!-- #primary-sidebar -->
	<?php endif; ?>

<div id="anchor-menu-wrapper">


 <?php $pattern = get_shortcode_regex();
    preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches );


    if( is_array( $matches ) && array_key_exists( 2, $matches ) && in_array( 'good', $matches[2] ) )
    {
     

     // foreach ($matches[0] as $value) {

     //   $value = wpautop( $value, true );
        // echo do_shortcode($value);
      //  print_r($value);

      foreach ($matches[0] as $value) {
$lookfor = "[good";

if (substr($value,0,strlen($lookfor))==$lookfor) {

$vig = str_replace(" ","-",$value);
$vig = str_replace("-i=\"i1\"","",$vig);
$vig = str_replace("-i=\"i2\"","",$vig);
$vig = str_replace("-i=\"i3\"","",$vig);
$vig = str_replace("]","",$vig);
$vig = str_replace("[good","",$vig);
$vig = str_replace("[/good", "", $vig);

//this is a [good] one

// $value = str_replace("good i","good class",$value); 

$value = str_replace("i=","class=",$value);
$value = str_replace("]",">",$value);
$value = str_replace("[good","<a href='#anchormenu-$vig'",$value);
$value = str_replace("[/good","</a",$value);
$value = wpautop( $value, true );

 

// print_r($value);
echo($value);

}



      }
    } else {
      // Do Nothing
    } ?> 
</div>










</div><!-- #sidebar-nicebar -->
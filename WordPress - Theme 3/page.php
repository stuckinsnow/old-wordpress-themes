<?php get_header(); ?>



<div id="pagewrapper">
<div id="cat_content_right">
<div class="home_content_inside">
<div class="home-div">
  <?php wp_nav_menu( array( 'theme_location' => 'home-menu', 'container_class' => 'menu-home-menu' ) ); ?>
</div>
<div id="page-right">
  <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
  <h1>
    <?php the_title(); ?>
  </h1>
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
    <?php get_sidebar('nice-bar'); ?>


  <?php the_content(); ?>
  <br />
  <br />
  <?php comments_template(); ?>
  <?php endwhile; else: ?>
  <h3>Sorry, no posts matched your criteria.</h3>
  <?php endif; ?>
<div>
</div>
</div>
<!--//single_left -->

<!-- <?php // get_sidebar(); ?> -->
</div>
</div>
</div> <!-- pagewrapper -->
<?php get_footer(); ?> 

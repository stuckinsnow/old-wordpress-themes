<?php get_header(); ?>
  
<div id="content_inside">

 
  <?php $x = 0; ?>
  <?php while (have_posts()) : the_post(); ?>
  <div class="post_box">
    <?php if($x % 2 == 0) { ?>
    <h3>
    <?php } else { ?>
    <h3 class="gray">
      <?php } ?>
      <a href="<?php the_permalink(); ?>"><?php echo substr(get_the_title(),0,35); ?></a></h3>
    <?php if(has_post_thumbnail()) { ?>
    <a href="<?php the_permalink(); ?>">
    <div class="maximum">
      <?php the_post_thumbnail('featured-home-small'); ?>
      <?php $shortex = substr(get_the_excerpt(), 0, 300);echo $shortex; echo "\r\n"; ?>
    </div>
    </a>
    <?php } else { ?>
    <a href="<?php the_permalink(); ?>">
    <div class="maximum">
      <?php $shortex = substr(get_the_excerpt(), 0, 650
	  );echo $shortex; echo "\r\n"; ?>
    </div>
    </a>
    <?php } ?>
  </div>
  <!--//big_post_box-->
  
  <?php $x++; ?>
  <?php endwhile; ?>
  <?php wp_reset_query(); ?>
  <div class="clear"></div>
  <?php if(get_next_posts_link() != '') { ?>
  



  <!--//load_more_cont-->
  
  <?php } ?>
  <div class="clear"></div>


<?php get_footer(); ?>


<?php load_more_button() ?>

<?php get_sidebar('nice-bar'); ?>
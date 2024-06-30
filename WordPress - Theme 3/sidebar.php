
<div id="sidebar">
  <div class="side_box">
    <h3>Art</h3>
    <ul>
      <?php
         global $post;
         $myposts = get_posts('numberposts=5&category_name=Art');
         foreach($myposts as $post) :
           setup_postdata($post);
         ?>
      <li><a href="<?php the_permalink();
          ?>"> <?php echo substr(get_the_title(), 0, 42); ?> </a></li>
      <?php endforeach; ?>
    </ul>
    <h3>Random</h3>
    <ul>
      <?php
         global $post;
         $myposts = get_posts('numberposts=5&category_name=Uncategorized');
         foreach($myposts as $post) :
           setup_postdata($post);
         ?>
      <li><a href="<?php the_permalink();
          ?>"> <?php echo substr(get_the_title(), 0, 42); ?> </a></li>
      <?php endforeach; ?>
    </ul>
    <h3>Computer</h3>
    <ul>
      <?php
         global $post;
         $myposts = get_posts('numberposts=5&category_name=Computer');
         foreach($myposts as $post) :
           setup_postdata($post);
         ?>
      <li><a href="<?php the_permalink();
          ?>"> <?php echo substr(get_the_title(), 0, 42); ?> </a></li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) : ?>
  
  <!--//side_box-->
  
  <div class="side_box">
  
  </div>
  <!--//side_box-->
  
  <?php endif; ?>
</div>
<!--//sidebar-->
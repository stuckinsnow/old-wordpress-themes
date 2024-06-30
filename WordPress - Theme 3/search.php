<?php get_header(); ?>



        <div id="single_left">



            <?php if (have_posts()) : ?>

            <?php while (have_posts()) : the_post(); ?>

            

            <div class="blog_box">

                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-image'); ?></a>

                <p><?php echo substr(strip_tags(get_the_content()),0,290); ?></p>

            </div><!--//blog_box-->            

            

            <?php endwhile; ?>

            

            <?php else : ?>
          

          <div class="blog_post">
                    <h2 class="center">No posts found. Try a different search?</h2>
                    <?php get_search_form(); ?>

          </div><!--//blog_post-->
      
            <?php endif; ?>

            

            

            <?php wp_reset_query(); ?>

        </div><!--//single_left-->

        

        <?php get_sidebar(); ?>

        

        <div class="clear"></div>

        

<?php get_footer(); ?>        
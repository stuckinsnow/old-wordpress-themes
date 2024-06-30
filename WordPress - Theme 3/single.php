<?php get_header(); ?>


        <div id="pagewrapper">

        <div class="home_content_inside">

        <div class="home-div">
    <?php wp_nav_menu( array( 'theme_location' => 'home-menu', 'container_class' => 'menu-home-menu' ) ); ?>
</div>

<div id="page-right">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

          

                <h1><?php the_title(); ?></h1>

                

                <?php the_content(); ?>

                

                <?php comments_template(); ?>


            <?php endwhile; else: ?>

            

                <h3>Sorry, no posts matched your criteria.</h3>

            

            <?php endif; ?>

        </div>
</div>
        

        <?php // get_sidebar(); ?>

        

        </div> <!-- pagewrapper -->
        <?php get_footer(); ?>
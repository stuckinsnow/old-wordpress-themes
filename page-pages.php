<?php
/*
Template Name: Pages
*/
get_header();
?>

<div class="all-pages-container">

<div class="all-pages-container-title">My Recommended</div>
<!-- <div id="information"> --> <?php wp_nav_menu( array( 'theme_location' => 'recommended-menu' ) ); ?> <!-- </div> -->

<div class="all-pages-container-title">Reviews</div>
<!-- <div id="reviews"> --> <?php wp_nav_menu( array( 'theme_location' => 'review-menu' ) ); ?> <!-- </div> -->

<div class="all-pages-container-title">Information</div>
<!-- <div id="information"> --> <?php wp_nav_menu( array( 'theme_location' => 'information-menu' ) ); ?> <!-- </div> -->

<div class="all-pages-container-title">Travel</div>
<!-- <div id="information"> --> <?php wp_nav_menu( array( 'theme_location' => 'travel-menu' ) ); ?> <!-- </div> -->


</div> 




    <?php
    wp_reset_query();
    ?>  

    <?php
    get_footer();
    ?>

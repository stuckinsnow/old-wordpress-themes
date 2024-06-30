<?php
/*
Template Name: Portfolio
*/
get_header();
?>


<div id="div-console">
    </div>
<div id="header_container">
<div id="header_menu">
  <?php // wp_nav_menu( array( 'theme_location' => 'home-menu', 'container_class' => 'menu-home-menu' ) ); ?>
</div>

<div id="filters">

<div class="button-group sort-by-button-group portfolio-item-fixed">
        <div class="button" data-sort-value="original-order"><div class="vislabel">Sort by: Post Date</div></div>
        <div class="button" data-sort-value="attachments"><div class="vislabel">Sort by: Gallery Size</div></div>
        <div class="button" data-sort-value="date"><div class="vislabel">Sort by: Date Taken</div></div>
        <div class="button" data-sort-value="lens"><div class="vislabel">Sort by: Focal Length</div></div>
        <div class="button" data-sort-value="iso"><div class="vislabel">Sort by: ISO</div></div>
        <div class="button" data-sort-value="aperture"><div class="vislabel">Sort by: Aperture</div></div>
</div>

    <div id="the-add-bug" class="filters"><label class="load-more-button">Load More</label><div class="hiddenlabel">Load More</div></div>
    <div id="shuffle" class="filters"><label>Shuffle</label><div class="hiddenlabel">Shuffle</div></div>
    <div id="remove-all" class="filters"><label>Clear</label><div class="hiddenlabel">Clear</div></div>



        <?php
    $terms = get_terms("portfolio-categories");
    $count = count($terms);
    if ($count > 0) {
    
    foreach ($terms as $term) {
        $uniqueID = sha1(mt_rand());
        $termname = strtolower($term->name);
        $termname = str_replace(' ', '-', $termname);
        echo '<div class="filters ' . $termname . ' ">';
        echo '<input type="checkbox" id="' . $uniqueID . '" class="' . $termname . '" title="" value=".' . $termname . '">';
        echo '<label for="' . $uniqueID . '" class="' . $termname . '">';
        echo $term->name;
        echo '</label>';
        echo '<div class="hiddenlabel">';
        echo 'Filter by: ';
        /* echo $term->name; */
        echo '</div>';
        echo '</div>';
    }
}
?>

    <div id="the-info-bug" class="filters">
    <a class="fancybox-content" href="#info-bug" rel="fancybox" data-fancybox-group="[fancybox-info-bug]">
    <label class="info">Information</label>
    </a>
    <div class="hiddenlabel">Information</div>
    </div>

<div id="info-bug" class="hidden-div">
<p>The filter buttons filter out photographs not matching the button's criteria e.g. if you select "colour", then the "black and white" photographs won't be shown.</p>
<p>You can add multiple filters e.g. "colour" and "landscape"; this would only show landscape photographs that are in colour.
<p>The sort buttons can be used in conjunction with the filter buttons; sort buttons simply re-arrange the photographs i.e. they get moved around on the grid but they do not get removed.</p>
<p>The clear button removes all filters but it does not remove the sorting.</p>
<p>The shuffle button clears the sorting as it re-arranges the photographs on the grid to an unknown order.</p>
</div>
    </div> <!-- filters -->
</div>



<!-- </div> --> <!-- journalism-carcass -->

    <div id="portfolio-page">
    <div id="portfolio">
    
    <?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args  = array(
    'post_type' => 'portfolio',
    'posts_per_page' => '8',
    'paged' => $paged
);
$loop  = new WP_Query($args);
while ($loop->have_posts()):
    $loop->the_post();
    
    $terms = get_the_terms($post->ID, 'portfolio-categories');
    if ($terms && !is_wp_error($terms)):
        $links = array();
        foreach ($terms as $term) {
            $links[] = $term->name;
        }
        $tax_links = join(" ", str_replace(' ', '-', $links));
        $tax       = strtolower($tax_links);
    else:
        $tax = '';
    endif;
    
    
?>
<?php
    $gallery     = get_post_gallery(get_the_ID(), false);
    $args        = array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'post__in' => explode(',', $gallery['ids'])
    );
    $attachments = get_posts($args);
    $great       = (count($attachments) + 1);
    
    echo '<div class="portfolio-item ' . $tax . '" data-category="' . $post_excerpt . '">';
    echo '<div class="portfolio-item-writing">';
    echo '<div class="portfolio-item-writing-title">';
    the_title();
    echo '</div>';
    echo '<div class="portfolio-item-writing-attachments">';
    if (function_exists('exifography_display_exif')) {
        echo exifography_display_exif();
    }

    echo '<div>';
    echo 'Attachments: ';
    echo '<span class="attachments">';
    echo $great;
    echo '</span>';
    echo '</div>';

    echo '<p data-fancybox-group="fancybox['. $post->ID .']">';
    echo substr(get_the_excerpt(), 0, 200);
    echo '</p>';

    echo '</div>'; // portfolio-item-writing-attachments
    
    echo '</div>';
    $large_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '');
    $large_image = $large_image[0];
    echo '<a data-fancybox-group="fancybox['. $post->ID .']" href="'. $large_image .'" title="'. substr(get_the_excerpt(), 0, 300) .'">';
?>

<div class="portfolio-item-thumbnail">
    <?php
    the_post_thumbnail();
?>
</div>

<?php
    echo '</a>';
?>


        <?php
    
    echo '<div>';
    foreach ($attachments as $attachment) {
        
        $image_alt = get_post_meta($attachment->ID, '_wp_attachment_image_alt', true);
        if (empty($image_alt)) {
            $image_alt = $attachment->post_title;
        }
        if (empty($image_alt)) {
            $image_alt = $attachment->post_excerpt;
        }
        $image_title  = $attachment->post_title;
        $post_content = $attachment->post_content;
        $post_excerpt = $attachment->post_excerpt;
        $image_url    = wp_get_attachment_image_src($attachment->ID, 'full');
        $small_image  = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
        
        echo '<a class="hidden-class" data-fancybox-group="fancybox[' . $post->ID . ']" href="' . $image_url[0] . '" title=" ' . '<p>' . $image_title . '</p><p>' . $post_content . '</p><p>' . $post_excerpt  . '</p>' . '">';
        echo '<img src="' . $small_image[0] . '" alt="">';
        echo '</a>';
    }
    
    echo '</div></div>';
endwhile;
?>

</div>
    </div><!-- #portfolio -->
        <div id="pagenavi">
    <?php
        if (function_exists('wp_pagenavi')) {
            wp_pagenavi(array(
            'query' => $loop));
        wp_reset_postdata();
    }
    ?>
        </div><!-- pagenavi -->

    <?php
    wp_reset_query();
    ?>  

    <?php
    get_footer();
    ?>

<!-- <div> --> <!-- journalism-carcass -->

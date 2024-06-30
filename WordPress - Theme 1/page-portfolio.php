<?php
/*
Template Name: Portfolio
*/
get_header();
?>

<div id="header_container">
</div>


        
        <!-- <div class="main-carousel2"
data-flickity='{ "fade": false }'> -->

<div id="carouselsticky" class="main-carousel2 hide-mobiles">
        <!-- <div id="filter-container"> -->

            <div class="carousel-cell">
                <div> <!-- wrapper -->
            <!-- <div> -->
                <div id="add-bug" class="filters-button sort-label">
                        <div id="div-input"class="">
                            <label class="load-more-button">Load More</label>
                        </div>
                </div>

                <div id="shuffle" class="filters-button sort-label">
                    <div>
                        <label>Shuffle</label>
                    </div>
                    <!-- <div class=""></div> -->
                </div>

                <div id="remove-all" class="filters-button sort-label">
                    <div>
                        <label>Clear Filters</label>
                    </div>
                    <!-- <div class=""></div> -->
                </div>


            <!-- </div> -->

    </div> <!-- wrapper -->

            </div>
        
        <div class="carousel-cell">
            <div> <!-- wrapper -->
        <div id="filters">
            
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
            echo '';
            echo $term->name;
            echo '</label>';
            echo '</div>';
    }
}
?>
    </div> </div> <!-- wrapper --> 
</div>

     <div class="carousel-cell">
        <div> <!-- wrapper -->
    <div id="filters2" class="button-group sort-by-button-group portfolio-item-fixed">
        <!-- <span>Sort by -</span> -->
            
            <div class="filters-button sort-label" data-sort-value="original-order">
                Published Date
            </div>
            <div class="filters-button sort-label" data-sort-value="attachments">
                Gallery Size
            </div>
            <div class="filters-button sort-label" data-sort-value="date">
                Date Taken
            </div>
            <div class="filters-button sort-label" data-sort-value="lens">
                Focal Length
            </div>
            <!-- <div class="filters-button sort-label" data-sort-value="iso">
                ISO
            </div>
            <div class="filters-button sort-label" data-sort-value="aperture">
                Lens Blur
            </div> -->
    </div> </div> <!-- wrapper -->
    <!-- </div> --> <!-- #filter-container -->
</div>
        </div> <!-- .main-carousel -->



 
        <div id="portfolio" class="">

  <div class="gutter-sizer"></div> 


    <?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args  = array(
    'post_type' => 'portfolio',
    'posts_per_page' => '10',
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
    
    $gallery     = get_post_gallery(get_the_ID(), false);
    $args        = array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'post__in' => explode(',', $gallery['ids'])
    );
    $attachments = get_posts($args);
    $great       = (count($attachments) + 1);
    $note1 = get_post_meta($post->ID, 'exif_date_taken', true);
    $note1_raw = get_post_meta($post->ID, 'exif_date_taken_raw', true);
    $note2 = get_post_meta($post->ID, 'exif_copyright', true);
    $note3 = get_post_meta($post->ID, 'exif_credit', true);
    $note4 = get_post_meta($post->ID, 'exif_title', true);
    $note5 = get_post_meta($post->ID, 'exif_caption', true);
    $note6 = get_post_meta($post->ID, 'exif_camera', true);
    $note7 = get_post_meta($post->ID, 'exif_focal_length', true);
    $note8 = get_post_meta($post->ID, 'exif_aperture', true);
    $note9 = get_post_meta($post->ID, 'exif_iso', true);
    $note10 = get_post_meta($post->ID, 'exif_shutter_speed', true);


            echo '<div class="portfolio-item  ' . $tax . '" data-category="' . $post_excerpt . '">';
            // echo '<div class="portfolio-item-lines-1"></div>';
            // echo '<div class="portfolio-item-lines-2"></div>';
            echo '<div class="portfolio-item-writing hide-mobile">';
            
            echo '<div class="portfolio-item-writing-title">';
                the_title();
                            // echo '<div class="portfolio-item-writing-attachments">';
     
            // echo do_shortcode(get_post_field('post_content', $postid));
            // echo 'Attachments: '; 
            echo ' // ';
            // echo do_shortcode(get_post_field('post_content', $postid));
            // echo 'Attachments: ';
            echo '<span class="attachments">';
            echo $great;
            echo '</span>';
            echo '</div>';
            // echo '</div>';
 

            // get the title
            


            // echo '<p data-fancybox="gallery['. $post->ID .']">';
            // echo get_post_meta($post->ID, 'designers', true);
            // echo substr(get_the_excerpt(), 0, 200);
            // echo '</p>';

            // get the excerpt
            
            // echo '<div class="exif_data, hidden-class" data-fancybox="gallery['. $post->ID .']">';
            echo '<div class="exif_data, hidden-class" data-fancybox="gallery['. $post->ID .']">';
                        echo '<h6>Title: ';            echo $note2. " " . $note3. " " . $note4. " " . $note5;            echo '</h6><h6 class="">Date: ';            echo $note1;            echo '</h6><h6>Camera: ';            echo $note6;            echo '</h6><h6 class="lens">Lens: ';            echo $note7;            echo 'mm';            echo '</h6><h6 class="aperture">Aperture: ƒ/';            echo $note8;            echo '</h6><h6 class="iso">ISO: ';            echo $note9;            echo '</h6><h6 class="shutter_speed">Shutter speed: ';            echo $note10; echo '</h6>';
            echo '</div>';
            echo '<div class="hidden-class date">';
            echo $note1_raw;
            echo '</div>';
            echo '</div>'; // portfolio-item-writing



    $large_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '');
    $large_image = $large_image[0];
            echo '<a data-fancybox="gallery['. $post->ID .']" href="'. $large_image .'" title="'. substr(get_the_excerpt(), 0, 300) .'">';
?>

<div class="portfolio-item-thumbnail">
    <?php
    the_post_thumbnail();
?>
</div>

<?php
            echo '</a>';
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
        // $small_image  = wp_get_attachment_image_src($attachment->ID, 'thumbnail');
        
            echo '<a class="hidden-class" data-fancybox="gallery[' . $post->ID . ']" href="' . $image_url[0] . '" title=" ' . '<p>' . $image_title . '</p><p>' . $post_content . '</p><p>' . $post_excerpt  . '</p>' . '">';
            echo '<img src="' . $image_url[0] . '" alt="">';
            echo '</a>';
    }

            echo '</div></div>';
    endwhile;
?>    







    </div><!-- #portfolio --> 

<div id="div-console"></div>




    <div id="pagenavi" class="hidden-class">
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

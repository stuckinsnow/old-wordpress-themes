<?php 
/*
Template Name: Portfolio
*/
get_header(); ?>

<div class="button-group sort-by-button-group">
  <button class="button is-checked" data-sort-value="original-order">original order</button>
  <button class="button" data-sort-value="name">name</button>
  <button class="button" data-sort-value="symbol">symbol</button>
  <button class="button" data-sort-value="number">number</button>
  <button class="button" data-sort-value="weight">weight</button>
  <button class="button" data-sort-value="category">category</button>
  <button class="button" data-sort-value="colour">colour</button>
  <button class="button" data-sort-value="aperture">aperture</button>
  <button class="button" data-sort-value="attachments">attachments</button>
</div>

 

<div id="page-portfolio-centered">

  <a data-fancybox-group="fancybox[group]" class="fancybox-content" href="#dog">Filters</a> 
  <div id="dog" class="fancybox-hidden">
    <ul class="filters">
      <button class="insert-button">Shuffle</button>
        <?php
            $terms = get_terms("portfolio-categories");
            $count = count($terms);
                echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
            if ( $count > 0 ){
 
                foreach ( $terms as $term ) {
 
                    $termname = strtolower($term->name);
                    $termname = str_replace(' ', '-', $termname);
                    echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'">'.$term->name.'</a></li>';
                }
            }
        ?>
    </ul>
  </div>


  <div id="portfolio-page">
 
  <div class="filters"><ul>
  <li class="insert-button">Shuffle</li>
        <?php
            $terms = get_terms("portfolio-categories");
            $count = count($terms);
                echo '<li><a href="javascript:void(0)" title="" data-filter=".all" class="active">All</a></li>';
            if ( $count > 0 ){
 
                foreach ( $terms as $term ) {
 
                    $termname = strtolower($term->name);
                    $termname = str_replace(' ', '-', $termname);
                    echo '<li><a href="javascript:void(0)" title="" data-filter=".'.$termname.'">'.$term->name.'</a></li>';
                }
            }
        ?>
    </ul></div> 
 
 

    <div id="portfolio">
    <?php 
       $paged = get_query_var('paged') ? get_query_var('paged') : 1;
       $args = array( 
          'post_type' => 'portfolio',
          'posts_per_page' => '4',
          'paged' => $paged );
       $loop = new WP_Query( $args );
         while ( $loop->have_posts() ) : $loop->the_post(); 
 
       $terms = get_the_terms( $post->ID, 'portfolio-categories' );                     
            if ( $terms && ! is_wp_error( $terms ) ) : 
 
                $links = array();
 
                foreach ( $terms as $term ) {
                    $links[] = $term->name;
                }
 
                $tax_links = join( " ", str_replace(' ', '-', $links));          
                $tax = strtolower($tax_links);
            else :  
            $tax = '';      

            endif; 
 
        echo '<div class="all portfolio-item '. $tax .'" data-category="' . $post->post_date . '">';
        ?>

 <?php
    $large_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'fullsize', false, '' ); 
    $large_image = $large_image[0];
?>



        <div class="viv">
        <a data-fancybox-group="fancybox[<?php echo $post->ID ?>]" href="<?php  echo $large_image ?>" title="<?php echo the_excerpt(); ?>"> 

<p> <?php the_post_thumbnail(); ?> </p>


<?php 
        echo '</a>';
?>




</div>

  <div class="galleryfloat">
  <div class="galleryfloatexcerpt">

 

<div class="galleryfloatmini">
<div class="kebab"><a><?php the_post_thumbnail(); ?></a></div>
<?php
$gallery = get_post_gallery( get_the_ID(), false );
$args = array( 
    'post_type'      => 'attachment', 
    'posts_per_page' => -1, 
    'post_status'    => 'any', 
    'post__in'       => explode( ',', $gallery['ids'] ) 
); 
$attachments = get_posts( $args );

foreach ( $attachments as $attachment ) {

    $image_alt = get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true);
    if ( empty( $image_alt )) {
        $image_alt = $attachment->post_title;
    }
    if ( empty( $image_alt )) {
        $image_alt = $attachment->post_excerpt;
    }
    $image_title = $attachment->post_title;
    $post_content = $attachment->post_content;
    $post_excerpt = $attachment->post_excerpt;
    $image_url = wp_get_attachment_image_src( $attachment->ID, 'full' );
    $small_image = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );

    
    echo '<div class="kebab">';
    echo '<a data-fancybox-group="fancybox['. $post->ID .']" href="' . $image_url[0] . '" title=" ' . '<p>' . $image_alt . '</p><p>' . $post_content . '</p><p>' . $post_excerpt . '</p><p>' . $image_title . '</p>' . '">';
    echo '<img src="' . $small_image[0] . '" alt="'. '[ -- '. $image_alt . ' - //// - ' . $image_title . ' - //// - ' .  $post_content . ' - //// - ' .  $post_excerpt . ' -- ]' .'">';
    echo '</a>';
    /* echo '<span data-featherlight-gallery class="item-label">' . $image_title . '</span>'; */
    echo '</div>';

} ?>


<div class="hidden-class">
<?php // Sample code to use, try to paste this to post.php or page.php inside your theme
$great = (count($attachments)+1 . " attachments ");
$values = ipmb_get_metabox_values('ipmb_metabox_0');
foreach($values as $i => $value) {
    echo "<strong>Fields [{$i}]: </strong><br/>";
    echo "Lens: <p class='name'>{$value['lens']}</p><br/>";
    echo "Date Taken: <p class='number'>{$value['date_taken']}</p><br/>";
    echo "<p class='attachments'>$great</p>'";
    echo "Aperture: <p class='symbol'>{$value['aperture']}</p><br/>";
    echo "Colour: <p class='colour'>{$value['colour']}</p><br/>";
    echo "Aperture: <p class='aperture'>{$value['aperture']}</p><br/>";
    echo "weight: <p class='weight'>{$value['aperture']}</p><br/>";
    echo "<br/>";
} ?>
</div>



</div>




<!-- <a href="<?php the_permalink(); ?>">

  Link to post
  </a> -->

<span><?php the_title(); ?></span>

<span data-fancybox-group="fancybox[<?php echo $post->ID ?>]"><?php echo substr(get_the_excerpt(), 0, 650); ?></span>



</div>
       </div>

        <?php

        
        
        echo '</div>'; 



      endwhile; ?>







 
   </div><!-- #portfolio -->


<div id="pagenavi">

  <?php
    if(function_exists('wp_pagenavi'))
    {
        wp_pagenavi(array(  'query' => $loop ) );
        wp_reset_postdata();
    }
?>

</div><!-- pagenavi -->

 <?php wp_reset_query(); ?>  

   </div><!-- #page -->




<script type="text/javascript">


</script>

</div>


<?php get_footer(); ?>
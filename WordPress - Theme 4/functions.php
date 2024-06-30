<?php
if ( ! isset( $content_width ) ) {
	$content_width = 580;
}

/*
**widget sidbar
*/
function journalism_widget_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'journalism' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'journalism' ),
		'before_widget' => '<div class="widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widgettitle">',
		'after_title'   => '</h5>',
	) );
}

/*
**journalism_setup
*/
function journalism_setup() {
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'journalism' ),
	) );
	/*
	**logo-text-color
	*/
	$args = array( 'width' => 940, 'height' => 129, 'default-text-color' => 'ffffff', 'uploads' => true );
	add_theme_support( 'custom-header', $args );
	/*
	**body-background
	*/
	add_theme_support( 'custom-background', array( 'default-color' => '273035', 'default-text' => '828789' ) );
	/*
	**load_theme_textdomain() for translation/localization support
	*/
	load_theme_textdomain( 'journalism', get_template_directory() . '/languages' );
	/*
	**add_editor_style() to style the visual editor
	*/
	add_editor_style();
	/*
	**add_theme_support() to add support for post thumbnails, automatic feed links and post formats
	*/
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
}

/*
**including the javascript and css of the theme
*/
function journalism_scripts() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// Load our main stylesheet.
	wp_enqueue_style( 'journalism-style', get_stylesheet_uri() );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'journalism-style-ie7', get_template_directory_uri() . '/css/ie7.css' );
	wp_style_add_data( 'journalism-style-ie7', 'conditional', 'IE 7' );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'journalism-style-ie8', get_template_directory_uri() . '/css/ie8.css' );
	wp_style_add_data( 'journalism-style-ie8', 'conditional', 'IE 8' );

	wp_enqueue_script( 'journalism-html5', get_template_directory_uri() . '/js/html5.js' );
	wp_script_add_data( 'journalism-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'journalism-script-slides', get_template_directory_uri() . '/js/jquery.slides.min.js', array( 'jquery' ) );
	wp_enqueue_script( 'journalism-script', get_template_directory_uri() . '/js/script.js', array( 'jquery' ) );
	$string_js = array(
		'chooseFile' => __( 'Choose file...', 'journalism' ),
		'fileNotSel' => __( 'File is not selected.', 'journalism' ),
		'fileSel'    => __( 'File Selected', 'journalism' ),
	);
	wp_localize_script( 'journalism-script', 'journalismStringJs', $string_js );
}

/*
**top-menu
*/
function journalism_page_menu_args( $args ) {
	if ( ! isset( $args['show_home'] ) ) {
		$args['show_home'] = true;
	}
	return $args;
}

/*
**navigate
*/
function journalism_nav( $html_id ) {
	global $wp_query;
	if ( 1 < $wp_query->max_num_pages ) : ?>
		<nav id="<?php echo esc_attr( $html_id ); ?>">
			<div class="nav-previous"><?php next_posts_link( '<span class="meta-nav">&larr;</span>' . __( 'Older posts', 'journalism' ) ); ?></div>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'journalism' ) . '<span class="meta-nav">&rarr;</span>' ); ?></div>
		</nav><!-- #nav-above -->
		<div class="clear"></div>
	<?php endif;
}

/*
**style for logo
*/
function journalism_admin_header() { ?>
	<style type="text/css">
		<?php if ( ! display_header_text() ) : ?>
			.header h1 a,
			.header p {
				display: none;
			}
		<?php else : ?>
			.header h1 a,
			.header p {
				color: <?php echo '#' . get_header_textcolor(); ?>;
			}
		<?php endif; ?>
	</style>
<?php }

/*
**featured_image_title
*/
function journalism_featured_image_title() {
	global $post;
	$thumbnail_id    = get_post_thumbnail_id( $post->ID );
	$thumbnail_image = get_posts( array( 'p' => $thumbnail_id, 'post_type' => 'attachment', 'post_status' => 'any' ) );
	if ( $thumbnail_image && isset( $thumbnail_image[0] ) ) {
		echo $thumbnail_image[0]->post_title;
	}
}

/*
**admin slider
*/
function journalism_add_metabox_for_slider() {
	add_meta_box( 'metabox_slider_id', 'Slider', 'journalism_metabox_callback', 'post', 'side' );
}

/*
**callback function for meta box
*/
function journalism_metabox_callback() {
	global $check;
	if ( get_post_meta( get_the_ID(), 'journalism_add_to_slider', true ) ) {
		$check = 'checked';
	}
	echo __( 'If you want to add this post in slider, choose the checkbox &nbsp ', 'journalism' ) .
			 '<form action="" method="post">' .
			 '<input type="checkbox" name="addToSlider" ' . $check . ' >' .
			 '</form>';
}

/*
**save meta box data
*/
function journalism_save_box_data( $post_id ) {
	$post = get_post( $post_id );
	if ( 'post' == $post->post_type ) {
		update_post_meta( $post_id, 'journalism_add_to_slider', esc_attr( $_POST['addToSlider'] ) );
	}

	return $post_id;
}

/*
**slider
*/
function journalism_slider_template() {
	$args = array(
		'post_type'           => 'post',
		'post_status'         => 'publish',
		'posts_per_page'      => - 1,
		'ignore_sticky_posts' => true,
		'meta_query' => array(
			array(
				'key'   => 'journalism_add_to_slider',
				'value' => 'on',
			),
			array(
				'key'     => '_thumbnail_id',
				'compare' => 'EXISTS',
			),
		),
	);
	$slider_posts = new WP_Query( $args );
	if ( $slider_posts->have_posts() ) : ?>
		<div class="container">
			<div id="slides">
				<?php while ( $slider_posts->have_posts() ) : $slider_posts->the_post(); ?>
					<div class="slidesjs-slide">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail(); ?>
							<div class="slider-text">
								<h1><?php the_title(); ?></h1>
								<?php the_excerpt(); ?>
							</div>
						</a>
					</div>
				<?php endwhile; ?>
			</div>
		</div><!--div slider-->
	<?php endif;
	wp_reset_postdata();
}

/*Template for comments and pingbacks.*/
function journalism_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
			<p><?php _e( 'Pingback:', 'journalism' );
				comment_author_link();
				edit_comment_link( __( 'Edit', 'journalism' ), '<span class="edit-link">', '</span>' ); ?>
			</p>
			<?php break;
		default : ?>
			<div id="comment-<?php comment_ID(); ?>" class='comment'>
				<header>
					<div class="comment-meta">
						<div class="comment-author vcard" <?php comment_class(); ?>>
							<?php $avatar_size = 68;
							if ( '0' != $comment->comment_parent ) {
								$avatar_size = 39;
							}
							echo get_avatar( $comment, $avatar_size );
							/* translators: 1: comment author, 2: date and time */
							printf( '%1$s' . __( 'on', 'journalism' ) . ' %2$s <span class="says">' . __( 'said:', 'journalism' ) . '</span>',
								sprintf( '<span class="fn">%s</span> <br />', get_comment_author_link() ),
								sprintf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
									esc_url( get_comment_link( $comment->comment_ID ) ),
									get_comment_time( 'c' ),
									/* translators: 1: date, 2: time */
									sprintf( __( '%1$s at %2$s', 'journalism' ), get_comment_date(), get_comment_time() )
								)
							); ?>
						</div><!-- .comment-author .vcard -->
						<?php if ( '0' == $comment->comment_approved ) : ?>
							<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'journalism' ); ?></em>
							<br />
						<?php endif; ?>
					</div>
				</header>
				<div class="clear"></div>
				<div class="comment-content">
					<?php comment_text(); ?>
				</div>
				<footer>
					<?php edit_comment_link( __( 'Edit', 'journalism' ), '<span class="edit-link">', '</span>' ); ?>
					<div class="reply">
						<?php comment_reply_link( array_merge( $args, array(
							'reply_text' => __( 'Reply', 'journalism' ) . '<span>&darr;</span>',
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
						) ) ); ?>
					</div><!-- .reply -->
				</footer>
			</div><!-- #comment-## -->
			<?php break;
	endswitch;
}
// ends check for journalism_comment()

/*
**hooks
*/
add_action( 'after_setup_theme', 'journalism_setup' );
add_action( 'widgets_init', 'journalism_widget_init' );
add_action( 'wp_enqueue_scripts', 'journalism_scripts' );
add_filter( 'wp_head', 'journalism_admin_header' );
add_filter( 'wp_page_menu_args', 'journalism_page_menu_args' );
add_action( 'journalism_wp_link_pages', 'journalism_nav' );
add_action( 'journalism_slides_template', 'journalism_slider_template' );
add_action( 'journalism_featured_images_title', 'journalism_featured_image_title' );
add_action( 'add_meta_boxes', 'journalism_add_metabox_for_slider' );
add_action( 'save_post', 'journalism_save_box_data' );

/*
 * Add a portfolio custom post type.
 */
add_action('init', 'create_redvine_portfolio');
function create_redvine_portfolio() 
{
  $labels = array(
    'name' => _x('Portfolio', 'portfolio'),
    'singular_name' => _x('Portfolio', 'portfolio'),
    'add_new' => _x('Add New', 'portfolio'),
    'add_new_item' => __('Add New Portfolio Item'),
    'edit_item' => __('Edit Item'),
    'new_item' => __('New Item'),
    'view_item' => __('View Item'),
    'search_items' => __('Search Items'),
    'not_found' =>  __('No items found'),
    'not_found_in_trash' => __('No items found in Trash'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'show_ui' => true, 
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'menu_position' => 20,
    'supports' => array('title','editor','thumbnail')
  ); 
  register_post_type('portfolio',$args);
}

register_taxonomy( "portfolio-categories", 
	array( 	"portfolio" ), 
	array( 	"hierarchical" => true,
			"labels" => array('name'=>"Creative Fields",'add_new_item'=>"Add New Field"), 
			"singular_label" => __( "Field" ), 
			"rewrite" => array( 'slug' => 'fields', // This controls the base slug that will display before each term 
							'with_front' => false)
		 ) 
);


function add_isotope() {
	

	wp_deregister_script( 'jquery' );
	wp_deregister_script('jquery-migrate');
	// Register
	wp_register_script('jquery', get_template_directory_uri(). '/js/jquery-2.1.4.min.js', false, '2.1.4');
	wp_register_script('jquery-migrate', get_template_directory_uri(). '/js/jquery-migrate-1.2.1.min.js', array('jquery'),  true, '1.2.1'); // require jquery, as loaded above	
	

    wp_register_script( 'isotope', get_template_directory_uri().'/js/jquery.isotope.min.js', array('jquery'),  true );
    // wp_register_script( 'fancybox-media', get_template_directory_uri().'/js/jquery.fancybox-media.js', array('jquery'),  true );
    // wp_register_script( 'fancybox-thumbs', get_template_directory_uri().'/js/jquery.fancybox-thumbs.js', array('jquery'),  true );
    wp_register_script( 'fancybox', get_template_directory_uri().'/js/jquery.fancybox.js', array('jquery'),  true );
    wp_register_script( 'isotope-init', get_template_directory_uri().'/js/jquery.launch.js', array('jquery', 'isotope'),  true );
	wp_register_style( 'isotope-css', get_stylesheet_directory_uri() . '/css/isotope.css' );
	wp_register_script( 'responsiveslides', get_template_directory_uri().'/js/ResponsiveSlides.js', array('jquery'),  true );
	wp_register_script( 'imagesloaded', get_template_directory_uri().'/js/imagesloaded.pkgd.min.js', array('jquery'),  true );
	// wp_register_script( 'featherlight', get_template_directory_uri().'/js/jquery.featherlight.js', array('jquery'),  true );

	wp_enqueue_script('jquery');
    wp_enqueue_style('isotope-css');
    wp_enqueue_script('isotope-init');
    wp_enqueue_script('isotope');
	wp_enqueue_script('fancybox');
    // wp_enqueue_script('fancybox-media');
	// wp_enqueue_script('fancybox-thumbs');
	wp_enqueue_script('imagesloaded');
	wp_enqueue_script('responsiveslides');
	// wp_enqueue_script('featherlight');
}
 
add_action( 'wp_enqueue_scripts', 'add_isotope' );
    
// Register our styles
function register_css()
{
    if (!is_admin()) {
        wp_register_style( 'fancybox-css', get_template_directory_uri() . '/css/fancybox.css' );
        wp_enqueue_style( 'fancybox-css' );
    }
}
 
add_action( 'init', 'register_css' );

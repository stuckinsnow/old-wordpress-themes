<?php
/**
 * Philip Theme functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Philip_Theme
 * @since Philip Theme 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Philip Theme 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 660;
}

/**
 * Philip Theme only works in WordPress 4.1 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'Philiptheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since Philip Theme 1.0
 */
function Philiptheme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Philiptheme, use a find and replace
	 * to change 'Philiptheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'Philiptheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 600, 400, true );
	add_image_size( 'portfolio', 15, 15, true ); // custom line

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'Philiptheme' ),
		'social'  => __( 'Social Links Menu', 'Philiptheme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

	$color_scheme  = Philiptheme_get_color_scheme();
	$default_color = trim( $color_scheme[0], '#' );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'Philiptheme_custom_background_args', array(
		'default-color'      => $default_color,
		'default-attachment' => 'fixed',
	) ) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'genericons/genericons.css', Philiptheme_fonts_url() ) );
}
endif; // Philiptheme_setup
add_action( 'after_setup_theme', 'Philiptheme_setup' );

/**
 * Register widget area.
 *
 * @since Philip Theme 1.0
 *
 * @link https://codex.wordpress.org/Function_Reference/register_sidebar
 */
function Philiptheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'Philiptheme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'Philiptheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'Philiptheme_widgets_init' );

if ( ! function_exists( 'Philiptheme_fonts_url' ) ) :
/**
 * Register Google fonts for Philip Theme.
 *
 * @since Philip Theme 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function Philiptheme_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'Philiptheme' ) ) {
		$fonts[] = 'Noto Sans:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'Philiptheme' ) ) {
		$fonts[] = 'Noto Serif:400italic,700italic,400,700';
	}

	/*
	 * Translators: If there are characters in your language that are not supported
	 * by Inconsolata, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'Philiptheme' ) ) {
		$fonts[] = 'Inconsolata:400,700';
	}

	/*
	 * Translators: To add an additional character subset specific to your language,
	 * translate this to 'greek', 'cyrillic', 'devanagari' or 'vietnamese'. Do not translate into your own language.
	 */
	$subset = _x( 'no-subset', 'Add new subset (greek, cyrillic, devanagari, vietnamese)', 'Philiptheme' );

	if ( 'cyrillic' == $subset ) {
		$subsets .= ',cyrillic,cyrillic-ext';
	} elseif ( 'greek' == $subset ) {
		$subsets .= ',greek,greek-ext';
	} elseif ( 'devanagari' == $subset ) {
		$subsets .= ',devanagari';
	} elseif ( 'vietnamese' == $subset ) {
		$subsets .= ',vietnamese';
	}

	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * JavaScript Detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Philip Theme 1.1
 */
function Philiptheme_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'Philiptheme_javascript_detection', 0 );

/**
 * Enqueue scripts and styles.
 *
 * @since Philip Theme 1.0
 */
function Philiptheme_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'Philiptheme-fonts', Philiptheme_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'Philiptheme-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'Philiptheme-ie', get_template_directory_uri() . '/css/ie.css', array( 'Philiptheme-style' ), '20141010' );
	wp_style_add_data( 'Philiptheme-ie', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'Philiptheme-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'Philiptheme-style' ), '20141010' );
	wp_style_add_data( 'Philiptheme-ie7', 'conditional', 'lt IE 8' );

	wp_enqueue_script( 'Philiptheme-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20141010', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'Philiptheme-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20141010' );
	}

	wp_enqueue_script( 'Philiptheme-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20150330', true );
	wp_localize_script( 'Philiptheme-script', 'screenReaderText', array(
		'expand'   => '<span class="screen-reader-text">' . __( 'expand child menu', 'Philiptheme' ) . '</span>',
		'collapse' => '<span class="screen-reader-text">' . __( 'collapse child menu', 'Philiptheme' ) . '</span>',
	) );
}
add_action( 'wp_enqueue_scripts', 'Philiptheme_scripts' );

/**
 * Add featured image as background image to post navigation elements.
 *
 * @since Philip Theme 1.0
 *
 * @see wp_add_inline_style()
 */
function Philiptheme_post_nav_background() {
	if ( ! is_single() ) {
		return;
	}

	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	$css      = '';

	if ( is_attachment() && 'attachment' == $previous->post_type ) {
		return;
	}

	if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
		$prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . '); }
			.post-navigation .nav-previous .post-title, .post-navigation .nav-previous a:hover .post-title, .post-navigation .nav-previous .meta-nav { color: #fff; }
			.post-navigation .nav-previous a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	if ( $next && has_post_thumbnail( $next->ID ) ) {
		$nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
		$css .= '
			.post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . '); border-top: 0; }
			.post-navigation .nav-next .post-title, .post-navigation .nav-next a:hover .post-title, .post-navigation .nav-next .meta-nav { color: #fff; }
			.post-navigation .nav-next a:before { background-color: rgba(0, 0, 0, 0.4); }
		';
	}

	wp_add_inline_style( 'Philiptheme-style', $css );
}
add_action( 'wp_enqueue_scripts', 'Philiptheme_post_nav_background' );

/**
 * Display descriptions in main navigation.
 *
 * @since Philip Theme 1.0
 *
 * @param string  $item_output The menu item output.
 * @param WP_Post $item        Menu item object.
 * @param int     $depth       Depth of the menu.
 * @param array   $args        wp_nav_menu() arguments.
 * @return string Menu item with possible description.
 */
function Philiptheme_nav_description( $item_output, $item, $depth, $args ) {
	if ( 'primary' == $args->theme_location && $item->description ) {
		$item_output = str_replace( $args->link_after . '</a>', '<div class="menu-item-description">' . $item->description . '</div>' . $args->link_after . '</a>', $item_output );
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'Philiptheme_nav_description', 10, 4 );

/**
 * Add a `screen-reader-text` class to the search form's submit button.
 *
 * @since Philip Theme 1.0
 *
 * @param string $html Search form HTML.
 * @return string Modified search form HTML.
 */
function Philiptheme_search_form_modify( $html ) {
	return str_replace( 'class="search-submit"', 'class="search-submit screen-reader-text"', $html );
}
add_filter( 'get_search_form', 'Philiptheme_search_form_modify' );

/**
 * Implement the Custom Header feature.
 *
 * @since Philip Theme 1.0
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 *
 * @since Philip Theme 1.0
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 *
 * @since Philip Theme 1.0
 */
require get_template_directory() . '/inc/customizer.php';










function register_my_menu() {
  register_nav_menu('home-menu',__( 'Home Menu' ));
  register_nav_menu( 'primary', __( 'Primary Menu', 'Main-Menu' ) );
}
add_action( 'init', 'register_my_menu' );


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




// [bartag foo="id-value"]
function good_shortcode( $atts, $content = null ) {

	// static $i = 0; $i++;
	$a = shortcode_atts( array(
		'id' => $content,
		// 'id' => uniqid(),
	), $atts );

	$unique_id = uniqid();
	
	$movie_details="";
   // get attibutes and set defaults
        extract(shortcode_atts(array(
                'gener' => uniqid(),
                'rating' => 'G',
                'i' => 0
       ), $atts));
    // Display info 

    $class_details .= $i;
    $gener_details .= $gener ;

    // $movie_details = '<div class=' . $unique_id . '><ul>';
    // $movie_details .= '<li class=' . $date . '>';


    // $ending_ul .= '</li></ul></div>';

	$cat = str_replace(" ","-",$a);

	return '<div class="good-div '. $class_details .'" id="anchormenu-'.esc_attr($cat['id']).'">' . $content . '</div>';

	// return '<div class="'.$movie_details.'" id="anchormenu-'.esc_attr($cat['id']).'">' . $movie_details . $content . $ending_ul . '</div>';
	// return $movie_details;

}

add_shortcode( 'good', 'good_shortcode' );

<?php
/**
 * Twenty Sixteen functions and definitions
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
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

/**
 * Twenty Sixteen only works in WordPress 4.4 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.4-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

if ( ! function_exists( 'twentysixteen_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * Create your own twentysixteen_setup() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Twenty Sixteen, use a find and replace
	 * to change 'twentysixteen' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'twentysixteen', get_template_directory() . '/languages' );

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
	 * Enable support for custom logo.
	 *
	 *  @since Twenty Sixteen 1.2
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 240,
		'width'       => 240,
		'flex-height' => true,
	) );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 9999 );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'twentysixteen' ),
		'social'  => __( 'Social Links Menu', 'twentysixteen' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'status',
		'audio',
		'chat',
	) );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', twentysixteen_fonts_url() ) );

	// Indicate widget sidebars can use selective refresh in the Customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif; // twentysixteen_setup
add_action( 'after_setup_theme', 'twentysixteen_setup' );

/**
 * Sets the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'twentysixteen_content_width', 840 );
}
add_action( 'after_setup_theme', 'twentysixteen_content_width', 0 );

/**
 * Registers a widget area.
 *
 * @link https://developer.wordpress.org/reference/functions/register_sidebar/
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'twentysixteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentysixteen' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'twentysixteen_widgets_init' );

if ( ! function_exists( 'twentysixteen_fonts_url' ) ) :
/**
 * Register Google fonts for Twenty Sixteen.
 *
 * Create your own twentysixteen_fonts_url() function to override in a child theme.
 *
 * @since Twenty Sixteen 1.0
 *
 * @return string Google fonts URL for the theme.
 */
function twentysixteen_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	/* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Merriweather font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Merriweather:400,700,900,400italic,700italic,900italic';
	}

	/* translators: If there are characters in your language that are not supported by Montserrat, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Montserrat font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Montserrat:400,700';
	}

	/* translators: If there are characters in your language that are not supported by Inconsolata, translate this to 'off'. Do not translate into your own language. */
	if ( 'off' !== _x( 'on', 'Inconsolata font: on or off', 'twentysixteen' ) ) {
		$fonts[] = 'Inconsolata:400';
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
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'twentysixteen_javascript_detection', 0 );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function twentysixteen_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'twentysixteen-fonts', twentysixteen_fonts_url(), array(), null );

	// Add Genericons, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.4.1' );

	// Theme stylesheet.
	wp_enqueue_style( 'twentysixteen-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie', get_template_directory_uri() . '/css/ie.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie', 'conditional', 'lt IE 10' );

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie8', get_template_directory_uri() . '/css/ie8.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie8', 'conditional', 'lt IE 9' );

	// Load the Internet Explorer 7 specific stylesheet.
	wp_enqueue_style( 'twentysixteen-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'twentysixteen-style' ), '20160412' );
	wp_style_add_data( 'twentysixteen-ie7', 'conditional', 'lt IE 8' );

	// Load the html5 shiv.
	wp_enqueue_script( 'twentysixteen-html5', get_template_directory_uri() . '/js/html5.js', array(), '3.7.3' );
	wp_script_add_data( 'twentysixteen-html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'twentysixteen-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20160412', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'twentysixteen-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20160412' );
	}

	wp_enqueue_script( 'twentysixteen-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20160412', true );

	wp_localize_script( 'twentysixteen-script', 'screenReaderText', array(
		'expand'   => __( 'expand child menu', 'twentysixteen' ),
		'collapse' => __( 'collapse child menu', 'twentysixteen' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'twentysixteen_scripts' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function twentysixteen_body_classes( $classes ) {
	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) {
		$classes[] = 'custom-background-image';
	}

	// Adds a class of group-blog to sites with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of no-sidebar to sites without active sidebar.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'twentysixteen_body_classes' );

/**
 * Converts a HEX value to RGB.
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $color The original color, in 3- or 6-digit hexadecimal form.
 * @return array Array containing RGB (red, green, and blue) values for the given
 *               HEX code, empty array otherwise.
 */
function twentysixteen_hex2rgb( $color ) {
	$color = trim( $color, '#' );

	if ( strlen( $color ) === 3 ) {
		$r = hexdec( substr( $color, 0, 1 ).substr( $color, 0, 1 ) );
		$g = hexdec( substr( $color, 1, 1 ).substr( $color, 1, 1 ) );
		$b = hexdec( substr( $color, 2, 1 ).substr( $color, 2, 1 ) );
	} else if ( strlen( $color ) === 6 ) {
		$r = hexdec( substr( $color, 0, 2 ) );
		$g = hexdec( substr( $color, 2, 2 ) );
		$b = hexdec( substr( $color, 4, 2 ) );
	} else {
		return array();
	}

	return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images
 *
 * @since Twenty Sixteen 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function twentysixteen_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	840 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 62vw, 840px';

	if ( 'page' === get_post_type() ) {
		840 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	} else {
		840 > $width && 600 <= $width && $sizes = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 61vw, (max-width: 1362px) 45vw, 600px';
		600 > $width && $sizes = '(max-width: ' . $width . 'px) 85vw, ' . $width . 'px';
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'twentysixteen_content_image_sizes_attr', 10 , 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Twenty Sixteen 1.0
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function twentysixteen_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( 'post-thumbnail' === $size ) {
		is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 840px';
		! is_active_sidebar( 'sidebar-1' ) && $attr['sizes'] = '(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';
	}
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'twentysixteen_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Modifies tag cloud widget arguments to have all tags in the widget same font size.
 *
 * @since Twenty Sixteen 1.1
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array A new modified arguments.
 */
function twentysixteen_widget_tag_cloud_args( $args ) {
	$args['largest'] = 1;
	$args['smallest'] = 1;
	$args['unit'] = 'em';
	return $args;
}
add_filter( 'widget_tag_cloud_args', 'twentysixteen_widget_tag_cloud_args' );



/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB2 directory)
 *
 * Be sure to replace all instances of 'opps_' with your project's prefix.
 * http://nacin.com/2010/05/11/in-wordpress-prefix-everything/
 *
 * @category YourThemeOrPlugin
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/WebDevStudios/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}



/**
 * Remove Posts & Pages from Dashboard as to not confuse the Authors
 *
 */

function remove_menus(){
  remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
	remove_menu_page( 'themes.php' );                 //Appearance
}
add_action( 'admin_menu', 'remove_menus' );


/**
 * Conditionally displays meta boxes as defined per parent cat
 *
 * Using JS to display instead...
 */
 /*
add_action( 'init', 'cmb2_category_post' );
function cmb2_category_post() {
	$post_id = $_GET['post'];
	$categories = get_the_category($post_id);
	if ( in_category(27,$post_id) ) { add_action( 'cmb2_admin_init', 'cmb2_register_iot' ); }
}
*/

/**
 * Move category boxes into an include
 */
add_action( 'cmb2_admin_init', 'cmb2_register_iot' );
add_action( 'cmb2_admin_init', 'cmb2_register_waste' );
add_action( 'cmb2_admin_init', 'cmb2_register_naturalproducts' );
add_action( 'cmb2_admin_init', 'cmb2_register_worldtea' );
add_action( 'cmb2_admin_init', 'cmb2_register_nbj' );
add_action( 'cmb2_admin_init', 'cmb2_register_mtce' );

function cmb2_register_iot() {
	$cmb = new_cmb2_box( array(
        'id'           => 'iot_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity'), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_iot',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Marketing Assets' => 'Marketing Assets',        
            'Signature Opportunities' => 'Signature Opportunities' ,
            'Premier Sponsorships' => 'Premier Sponsorships',
        ),
    ) );   
}

function cmb2_register_waste() {
	$cmb = new_cmb2_box( array(
        'id'           => 'waste_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity'), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_waste',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
          'Event' => 'Event',
					'Package' => 'Package',
					'Brand Exposure' => 'Brand Exposure',
					'Mobile App' => 'Mobile App',
					'A-la-carte' => 'A-la-carte',
					'Marketing' => 'Marketing'
        ),
    ) ); 
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_waste',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Platinum' => 'Platinum',
            'Silver' => 'Silver',
            'Bronze' => 'Bronze',
            'Green' => 'Green',
        ),
    ) );
}

function cmb2_register_naturalproducts() {
	$cmb = new_cmb2_box( array(
        'id'           => 'naturalproducts_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity' ), // Post type
    ) );
    /* no types for EE 17
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_np',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Marketing' => 'Marketing',
            'Awareness' => 'Awareness',
            'Sampling' => 'Sampling',
            'Event' => 'Event',
            'Exclusive' => 'Exclusive',
        ),
    ) );   */
 		$cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_np',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
            'Marketing' => 'Marketing',
            'Title Sponsor' => 'Title Sponsor', 
        ),
    ) );
}

function cmb2_register_worldtea() {
	$cmb = new_cmb2_box( array(
        'id'           => 'worldtea_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',	
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_wt',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Package' => 'Package',
            'Marketing' => 'Marketing',
            'Brand Awareness' => 'Brand Awareness',
            'Lead Generation' => 'Lead Generation',
        ),
    ) );
}

function cmb2_register_nbj() {
	$cmb = new_cmb2_box( array(
        'id'           => 'nbj_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',	
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_nbj',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Brand' => 'Brand',
            'Exclusive' => 'Exclusive',
            'Event' => 'Event',
            'Lead Generation' => 'Lead Generation',
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_nbj',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Premier Platinum' => 'Premier Platinum',
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
        ),
    ) );
}


function cmb2_register_mtce() {
	$cmb = new_cmb2_box( array(
        'id'           => 'mtce_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',	
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_mtce',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Premium' => 'Premium',
            'Content Related' => 'Content Related',
            'Hospitality' => 'Hospitality',
            'Product Branded' => 'Product Branded',
            'Exhibit Hall' => 'Exhibit Hall',
            'Tech-Focused' => 'Tech-Focused',
        ),
    ) );
}

/**
 * And/or can we handle this via the dom
 */
function add_admin_scripts( $hook ) {
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'opportunity' === $post->post_type ) {     
            wp_enqueue_script(  'myscript', get_stylesheet_directory_uri().'/js/myscript.js' );
        }
    }
}
// Update CSS within in Admin
function add_admin_styles() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'add_admin_styles');
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );


/**
 * Unserialize arrays for JSON ouput
 */
class unserialize_php_arrays_before_sending_json {
    function __construct() {
      add_action( 'json_api_import_wp_post',
      array( $this, 'json_api_import_wp_post' ), 10, 2 );
    }
	function json_api_import_wp_post( $JSON_API_Post, $wp_post ) {
		foreach ( $JSON_API_Post->custom_fields as $key => $custom_field ) {
			if (is_array($custom_field)) {
				$unserialized_array = array();
				foreach($custom_field as $field_key => $field_value) {
					$unserialized_array[$field_key] = maybe_unserialize( $field_value );
				}
				$JSON_API_Post->custom_fields->$key = $unserialized_array;
			} else {
				$JSON_API_Post->custom_fields->$key = maybe_unserialize( $custom_field );
			}
		}
	}
}
new unserialize_php_arrays_before_sending_json();


add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function cmb2_sample_metaboxes() {



    // Start with an underscore to hide fields from custom fields list
    $prefix = 'opp_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => $prefix . 'details',
        'title'         => __( 'Opportunity Details', 'cmb2' ),
        'object_types'  => array( 'opportunity', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
        'cmb_styles' => iot_types, // false to disable the CMB stylesheet
    ) );
    // Sold?
		$cmb->add_field( array(
			'name'             => '<strong style="color: #ff0000;">Sold</strong>',
			'id'               => $prefix . 'sold',
			'type'             => 'checkbox',
			'default' => '',
			'options'          => array(
					'sold'   => __( 'sold', 'cmb2' ),
			),
	) );
	// Enabled?
	$cmb->add_field( array(
			'name'             => '<span style="color:green">Enabled</span>',
			'id'               => $prefix . 'enabled',
			'type'             => 'checkbox',
			'default' => 'enabled',
			'options'          => array(
					'enabled' => __( 'Enabled', 'cmb2' ),
			),
	) );
	// Featured
		$cmb->add_field( array(
			'name'             => '<span style="color:#ffcd00">✩</span> Featured Opportunity?',
			'id'               => $prefix . 'featured',
			'type'             => 'checkbox',
			'default' => '',
			'options'          => array(
					'featured' => __( 'Featured', 'cmb2' ),
			),
	) );
	// Current Quantity Available
		$cmb->add_field( array(
			'name'    => 'Excerpt',
			'desc'    => 'Will display above the content. Provide one paragraph of text, do not include HTML',
			'default' => '',
			'id'      => $prefix . 'excerpt',
			'sanitization_cb' => 'sanitize_html',
			'type'    => 'textarea',
		) );
		// look @ column option for these fields or before_row, etc.
		// Current Quantity Available
		$cmb->add_field( array(
			'name'    => '<u>Current</u> Quantity Available',
			'default' => '',
			'id'      => $prefix . 'current_quantity',
			'type'    => 'text',
		) );
		// Totle Quantity Available
		$cmb->add_field( array(
			'name'    => '<u>Total</u> Quantity Available',
			'default' => '',
			'id'      => $prefix . 'total_quantity',
			'type'    => 'text',
		) );
		// look @ column option for these fields or before_row, etc.
		// Numeric Cost
		$cmb->add_field( array(
			'name'    => 'Cost',
			'id'      => $prefix . 'numeric_cost',
			'desc'    => 'Enter the minimum value for price sorting.',
			'type'    => 'text_money',
			'sanitization_cb' => 'sanitize_numeric',
		) );
		// Cost Override
		$cmb->add_field( array(
			'name'    => 'Text Cost',
			'desc'    => 'Enter a price range or include any necessary descriptors here.',
			'id'      => $prefix . 'total_cost',
			'type'    => 'text',
		) );	
		$cmb->add_field( array(
	    'name'    => 'Sponsor Logo Paths',
			'desc'    => 'Please enter the full URL for each sponsor logo stored in the Sponsor Tool. If one does not exist, please use the upload tool below.',
			'id'      => $prefix . 'logos_paths',
			'type'    => 'text',
			'repeatable' => true,
		) );
		$cmb->add_field( array(
	    'name'    => 'Upload Sponsor Logos',
			'desc'    => 'Upload sponsor logos when there is not already a logo on file.',
			'id'      => $prefix . 'sponsor_logos',
			'type'    => 'file_list',
			'options' => array(
        'url' => true,
    	),
			'repeatable' => true
		) );
		$cmb->add_field( array(
	    'name'    => 'Images',
			'id'      => $prefix . 'images',
			'type'    => 'file_list',
			'options' => array(
        'url' => true,
    	),
			'repeatable' => true
		) );
		$cmb->add_field( array(
	    'name'    => 'Supporting Document',
			'desc'    => 'Upload a file or enter a URL',
			'id'      => $prefix . 'document',
			'type'    => 'file_list',
			'text' => array(
        'add_upload_files_text' => 'Add Files', // default: "Add or Upload Files"
        'remove_image_text' => 'Remove Images', // default: "Remove Image"
        'file_text' => 'File:', // default: "File:"
        'file_download_text' => 'Download', // default: "Download"
        'remove_text' => 'Remove', // default: "Remove"
    	),
		) );
		$cmb->add_field( array(
	    'name'    => 'Supporting Document Labels',
			'desc'    => 'Please enter a label for each document uploaded',
			'id'      => $prefix . 'documentLabel',
			'type'    => 'text',
			'repeatable'  => true,
		) );
		$cmb->add_field( array(
			'name' => 'Sale Deadline',
			'id'   => $prefix . 'deadline',
			'type' => 'text_date',
			// 'timezone_meta_key' => 'wiki_test_timezone',
			// 'date_format' => 'l jS \of F Y',
		) );
		$cmb->add_field( array(
	    'name'    => 'Contact Information',
			'id'      => $prefix . 'contact',
			'type'    => 'text'
		) );
		$cmb->add_field( array(
	    'name'    => 'Contact Information #2',
			'id'      => $prefix . 'contact_2',
			'type'    => 'text'
		) );

	
	$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'admin_notes',
			'title'         => __( 'Admin Notes', 'cmb2' ),
			'object_types'  => array( 'opportunity', ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
	) );
	$cmb->add_field( array(
    'name' => 'Fulfillment Notes',
    'desc' => 'field description (optional)',
    'default' => '',
    'id' => $prefix . 'fulfillment',
    'type' => 'textarea_small'
	) );
	$cmb->add_field( array(
    'name' => 'Venue Information',
    'desc' => 'field description (optional)',
    'default' => '',
    'id' => $prefix . 'venue_info',
    'type' => 'textarea_small'
	) );
	//	1500 Characters
	//	XX Characters
}

/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function opps_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo $classes; ?>">
		<p><label for="<?php echo $id; ?>"><?php echo $label; ?></label></p>
		<p><input id="<?php echo $id; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo $description; ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function opps_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo $field->row_classes(); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo $field->args( 'description' ); ?></p>
	</div>
	<?php
}

add_action( 'cmb2_admin_init', 'opps_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function opps_register_repeatable_group_field_metabox() {
	$prefix = 'opps_group_';
	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'page', ),
	) );
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Entry', 'cmb2' ),
			'remove_button' => __( 'Remove Entry', 'cmb2' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );
	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Entry Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );
	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'cmb2' ),
		'description' => __( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );
	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Entry Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );
	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Image Caption', 'cmb2' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );
}

add_action( 'cmb2_admin_init', 'opps_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function opps_register_taxonomy_metabox() {
	$prefix = 'opps_term_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );
	$cmb_term->add_field( array(
		'name'             => __( 'Event Year', 'cmb2' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'2014' => __( '2014', 'cmb2' ),
			'2015' => __( '2015', 'cmb2' ),
			'2016' => __( '2016', 'cmb2' ),
			'2017' => __( '2017', 'cmb2' ),
			'2018' => __( '2018', 'cmb2' ),
			'2019' => __( '2019', 'cmb2' ),
			'2020' => __( '2020', 'cmb2' ),
			'2021' => __( '2021', 'cmb2' ),
			'2022' => __( '2023', 'cmb2' ),
			'2023' => __( '2023', 'cmb2' ),
			'2024' => __( '2024', 'cmb2' ),
			'2025' => __( '2025', 'cmb2' ),
			'2026' => __( '2026', 'cmb2' ),
			'2027' => __( '2027', 'cmb2' ),
			'2028' => __( '2028', 'cmb2' ),
			'2029' => __( '2029', 'cmb2' ),
			'2030' => __( '2030', 'cmb2' ),
		)
	) );
	// Date Range	
		$cmb_term->add_field( array(
        'name'       => __( 'Start Date', 'cmb2' ),
        'id'         => $prefix . 'text_datetime_timestamp_timezone',
        'type'       => 'text_datetime_timestamp_timezone',
    ) );
  	$cmb_term->add_field( array(
        'name'       => __( 'End Date', 'cmb2' ),
        'id'         => $prefix . 'text_datetime_timestamp',
        'type'       => 'text_datetime_timestamp',
    ) ); 
}

add_action( 'cmb2_admin_init', 'opps_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page
 */
function opps_register_theme_options_metabox() {

	$option_key = 'opps_theme_options';

	/**
	 * Metabox for an options page. Will not be added automatically, but needs to be called with
	 * the `cmb2_metabox_form` helper function. See wiki for more info.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'      => $option_key . 'page',
		'title'   => __( 'Theme Options Metabox', 'cmb2' ),
		'hookup'  => false, // Do not need the normal user/post hookup
		'show_on' => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( $option_key )
		),
	) );
	


	/**
	 * Options fields ids only need
	 * to be unique within this option group.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => __( 'Site Background Color', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}

function	sanitize_numeric($value, $field_args, $field) {
	$value = preg_replace('/[\$,]/', '', $value);
	$sanitized_value = floatval($value);
	return $sanitized_value;
}
/**
 * Handles sanitization for the wiki_custom_escaping_and_sanitization field.
 * Ensures a field's value is greater than 100 or nothing.
 *
 * @param  mixed      $value      The unsanitized value from the form.
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 *
 * @return mixed                  Sanitized value to be stored.
 */
function sanitize_html( $value, $field_args, $field ) {
		$sanitized_value = strip_tags($value);
  	return  $sanitized_value;
}


/**
 * trim the fat
 */
 function slug_get_post_meta_cb( $object, $field_name, $request ) {
	return get_post_meta( $object[ 'id' ], $field_name );
}
 
function slug_update_post_meta_cb( $value, $object, $field_name ) {
	return update_post_meta( $object[ 'id' ], $field_name, $value );
}

function renameCategory() {
    global $wp_taxonomies;
    $cat = $wp_taxonomies['category'];
    $cat->label = 'Events';
    $cat->label = 'Events';
    $cat->labels->singular_name = 'Event';
    $cat->labels->plural_name = 'Events';
    $cat->labels->menu_name = 'Events';
    $cat->labels->all_items = 'All Events';
    $cat->labels->edit_item = 'Edit Event';
    $cat->labels->view_item = 'View Event';
    $cat->labels->update_item = 'Update Event';
    $cat->labels->add_new_item = 'Add New Event';
    $cat->new_item_name = 'New Event Name';
    $cat->parent_item = 'Parent Event';
    $cat->parent_item_colon = 'New Event:';
    $cat->search_items = 'Search Events';
    $cat->popular_items = 'Popular Events';
    $cat->separate_items_with_commas = 'Separate events with commas';
    $cat->add_or_remove_items = 'Add or remove events';
    $cat->choose_from_most_used ='Choose from the most used events';
    $cat->not_found = 'No events found.';

    $cat->labels->name = $cat->label;
    $cat->labels->menu_name = $cat->label;
}
add_action('init', 'renameCategory');


remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );


//Remove dashboard widgets
function remove_dashboard_meta() {
        $user = wp_get_current_user();
        if (!$user -> has_cap ('manage_options'))
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
        remove_meta_box( 'cjt-statistics', 'dashboard', 'normal');
}
add_action( 'admin_init', 'remove_dashboard_meta' ); 
//add_action( 'add_meta_boxes', 'change_cat_meta_box', 0 );
//add_action( 'admin_menu', 'change_post_menu_label' );
    
    

/*
add_action( 'admin_menu', 'my_admin_menu' );

function my_admin_menu() {
	add_menu_page( 'Events', 'Events', 'manage_options', 'events-admin.php', 'events_admin', 'dashicons-tickets', 1 );
}

function events_admin() {
	?>
	<div class="wrap">
		<h2>Events</h2>
		<p>hello</p>
	</div>
	<?php
}
*/

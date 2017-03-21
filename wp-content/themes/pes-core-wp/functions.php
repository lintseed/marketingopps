<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */

 /**
 * Frontend post editing
 */
function frontend_update_cafe() {
	if ( empty($_POST['frontend']) || empty($_POST['ID']) || empty($_POST['post_type']) || $_POST['post_type'] != 'opportunity' ) {
		return;
  }
	// $post global is required so save_cafe_custom_fields() doesn't error out
	global $post;
	$post = get_post($_POST['ID']);
	global $wpdb;
	$post_id = wp_update_post( $_POST );
}
add_action('init', 'frontend_update_cafe');

function save_cafe_custom_fields(){
  global $post;

  if ($post) {
    update_post_meta($post->ID, "excerpt", @$_POST["excerpt"]);
    update_post_meta($post->ID, "sold", @$_POST["sold"]);
    update_post_meta($post->ID, "enabled", @$_POST["enabled"]);
    update_post_meta($post->ID, "featured", @$_POST["featured"]);
    update_post_meta($post->ID, "deadline", @$_POST["deadline"]);
    update_post_meta($post->ID, "current_quantity", @$_POST["opp_current_quantity"]);
    update_post_meta($post->ID, "total_quantity", @$_POST["total_quantity"]);
    update_post_meta($post->ID, "numeric_cost", @$_POST["numeric_cost"]);
    update_post_meta($post->ID, "total_cost", @$_POST["total_cost"]);

  }
}
add_action( 'admin_init', 'add_cafe_meta_boxes' );
add_action( 'save_post', 'save_cafe_custom_fields' );



$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

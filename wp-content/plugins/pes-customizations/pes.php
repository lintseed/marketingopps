<?php
/**
 * The WordPress Media Category Management Plugin.
 *
 * A plugin to provide bulk category management functionality for media in WordPress sites.
 *
 * @package   WP_PESCustomizations
 *
 * @wordpress-plugin
 * Plugin Name: PES Customizations
 * Description: A plugin to provide bulk category management functionality for media in WordPress sites.
 * Version:     1.0.0
 * Text Domain: wp-pes-customizations
 */
//====================================================================
// Main Plugin Configuration
//====================================================================
define( 'WP_PES_URL',					plugins_url('', __FILE__) );
define( 'WP_PES_DIR',					rtrim(plugin_dir_path(__FILE__), '/') );
define( 'WP_PES_BASENAME',				dirname(plugin_basename(__FILE__)) );
define( 'WP_PES_FILENAME',				basename(__FILE__) );
define( 'WP_PES_PLUGIN_FILE',			WP_PES_BASENAME . '/' . WP_PES_FILENAME );

// Our product prefix
//
if (defined('WP_PES_PREFIX') === false) {
	define('WP_PES_PREFIX', 'wp-pes');
}

if ( is_admin() ) {		// Allow use of admin functions in front-end
	require_once( WP_PES_DIR . '/inc/admin.php' );
}
require_once( WP_PES_DIR . '/inc/archives.php' );
require_once( WP_PES_DIR . '/inc/category.php' );
require_once( WP_PES_DIR . '/inc/index.php' );
require_once( WP_PES_DIR . '/inc/feeds.php' );
require_once( WP_PES_DIR . '/inc/metaboxes.php' );


// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'WP_PES_Plugin', 'activate' ) );

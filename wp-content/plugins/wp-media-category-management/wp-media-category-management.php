<?php
/**
 * The WordPress Media Category Management Plugin.
 *
 * A plugin to provide bulk category management functionality for media in WordPress sites.
 *
 * @package   WP_MediaCategoryManagement
 * @author    DeBAAT <wp-mcm@de-baat.nl>
 * @license   GPL-3.0+
 * @link      https://www.de-baat.nl/WP_MCM
 * @copyright 2014 - 2016 De B.A.A.T.
 * 
 * @wordpress-plugin
 * Plugin Name: WP Media Category Management
 * Plugin URI:  https://www.de-baat.nl/WP_MCM
 * Description: A plugin to provide bulk category management functionality for media in WordPress sites.
 * Version:     1.9.1
 * Author:      DeBAAT <wp-mcm@de-baat.nl>
 * Author URI:  https://www.de-baat.nl/WP_MCM
 * Text Domain: wp-media-category-management
 * License:     GPL-3.0
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Domain Path: /lang
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_MCM_LINK',					'https://www.de-baat.nl/WP_MCM' );
define( 'WP_MCM_VERSION',				'1.9.1' );
define( 'WP_MCM_OPTIONS_NAME',			'wp-media-category-management-options' ); // Option name for save settings
define( 'WP_MCM_OPTION_NONE',			'uncategorized' );
define( 'WP_MCM_POST_TAXONOMY',			'category' );
define( 'WP_MCM_TAGS_TAXONOMY',			'post_tag' );
define( 'WP_MCM_MEDIA_TAXONOMY',		'category_media' );
define( 'WP_MCM_ACTION_BULK_TOGGLE',	'bulk_toggle' );
define( 'WP_MCM_OPTION_ALL_CAT',		'0' );
define( 'WP_MCM_OPTION_NO_CAT',			'no_category' );

define( 'WP_MCM_URL',					plugins_url('', __FILE__) );
define( 'WP_MCM_DIR',					rtrim(plugin_dir_path(__FILE__), '/') );
define( 'WP_MCM_BASENAME',				dirname(plugin_basename(__FILE__)) );
define( 'WP_MCM_FILENAME',				basename(__FILE__) );
define( 'WP_MCM_PLUGIN_FILE',			WP_MCM_BASENAME . '/' . WP_MCM_FILENAME );

// Our product prefix
//
if (defined('WP_MCM_PREFIX') === false) {
	define('WP_MCM_PREFIX', 'wp-mcm');
}

//====================================================================
// Main Plugin Configuration
//====================================================================

require_once( WP_MCM_DIR . '/include/wp-mcm-functions.php' );
require_once( WP_MCM_DIR . '/include/class-wp-mcm-plugin.php' );
require_once( WP_MCM_DIR . '/include/class-wp-mcm-shortcodes.php' );
require_once( WP_MCM_DIR . '/include/wp-mcm-widgets.php' );

// load code that is only needed in the admin section
//if ( is_admin() ) {		// Allow use of admin functions in front-end
	require_once( WP_MCM_DIR . '/include/wp-mcm-admin-functions.php' );
//}

// Register hooks that are fired when the plugin is activated, deactivated, and uninstalled, respectively.
register_activation_hook( __FILE__, array( 'WP_MCM_Plugin', 'activate' ) );

/**
 * @var WP_MCM_Plugin $wp_mcm_plugin an global object for this plugin.
 */
global $wp_mcm_plugin;
$wp_mcm_plugin = WP_MCM_Plugin::get_instance();


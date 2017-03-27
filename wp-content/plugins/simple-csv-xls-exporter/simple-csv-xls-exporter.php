<?php
/*
Plugin Name: Simple CSV/XLS Export
Plugin URI: https://wordpress.org/plugins/simple-csv-xls-exporter/
Description: Export posts to CSV or XLS, through a link from backend/frontend. Supports custom post types, WooCommerce products, custom taxonomies and fields.
Author: Shambix
Author URI: http://www.shambix.com
Version: 1.4.3
*/

/*
Forked at https://github.com/Jany-M/simple-csv-xls-exporter
Original author 2013  Ethan Hinson  (email : ethan@bluetent.com)
*/

//define('SIMPLE_CSV_EXPORTER_VERSION', '1.4.3');

/*--------------------------------------
|                                      |
|  PATHS & FOLDERS                     |
|                                      |
---------------------------------------*/

// PLUGIN
$upload_dir = wp_upload_dir();
if (!defined('SIMPLE_CSV_XLS_EXPORTER_PLUGIN'))
    define('SIMPLE_CSV_XLS_EXPORTER_PLUGIN', plugin_dir_path(__FILE__));
if (!defined('SIMPLE_CSV_XLS_EXPORTER_PROCESS'))
    define('SIMPLE_CSV_XLS_EXPORTER_PROCESS', SIMPLE_CSV_XLS_EXPORTER_PLUGIN.'process/');

// OPTIONS
if (!defined('SIMPLE_CSV_XLS_EXPORTER_EXTRA_FILE_NAME'))
    define('SIMPLE_CSV_XLS_EXPORTER_EXTRA_FILE_NAME', '');

if(!class_exists('SIMPLE_CSV_EXPORTER')) {
    class SIMPLE_CSV_EXPORTER {

        public function __construct()   {
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            if ( isset( $_GET[ 'export' ] ) && ($_GET[ 'export' ] == 'csv' || $_GET[ 'export' ] == 'xls')) {
                add_action('wp_loaded', 'ccsve_export');
            }
            $SIMPLE_CSV_EXPORTER_SETTINGS = new SIMPLE_CSV_EXPORTER_SETTINGS();
        }

        public static function activate() { }

        public static function deactivate() {
            unregister_setting('wp_ccsve-group', 'ccsve_post_type');
            unregister_setting('wp_ccsve-group', 'ccsve_post_status');
            unregister_setting('wp_ccsve-group', 'ccsve_std_fields');
            unregister_setting('wp_ccsve-group', 'ccsve_tax_terms');
            unregister_setting('wp_ccsve-group', 'ccsve_custom_fields');
            unregister_setting('wp_ccsve-group', 'ccsve_woocommerce_fields');

            delete_option('wp_ccsve-group');
        }

    }
}

if(class_exists('SIMPLE_CSV_EXPORTER')) {

    register_activation_hook(__FILE__, array('SIMPLE_CSV_EXPORTER', 'activate'));
    register_deactivation_hook(__FILE__, array('SIMPLE_CSV_EXPORTER', 'deactivate'));

    require_once(sprintf("%s/exporter.php", dirname(__FILE__)));

    $SIMPLE_CSV_EXPORTER = new SIMPLE_CSV_EXPORTER();

    // Add a link to the settings page onto the plugin page

        function simple_csv_exporter_plugin_settings_link($links)  {
            $links[] = '<a href="tools.php?page=simple_csv_exporter_settings">Export</a>';
            return $links;
        }

        add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'simple_csv_exporter_plugin_settings_link');

}

<?php 
/*
	Plugin Name: Dashboard Widgets Suite
	Plugin URI: https://perishablepress.com/dashboard-widgets-suite/
	Description: Provides a suite of sweet widgets for your WP Dashboard.
	Tags: dashboard, widget, widgets, user notes, notes, todo, memo, rss, social, server, debug, log
	Author: Jeff Starr
	Contributors: specialk
	Author URI: http://monzilla.biz/
	Donate link: http://m0n.co/donate
	Requires at least: 4.1
	Tested up to: 4.5
	Stable tag: trunk
	Version: 1.1
	Text Domain: dws
	Domain Path: /lang/
	License: GPL v2 or later
*/

if (!defined('ABSPATH')) die();

if (!class_exists('Dashboard_Widgets_Suite')) {
	
	final class Dashboard_Widgets_Suite {
		
		private static $instance;
		
		public static function instance() {
			if (!isset(self::$instance) && !(self::$instance instanceof Dashboard_Widgets_Suite)) {
				
				self::$instance = new Dashboard_Widgets_Suite;
				self::$instance->constants();
				self::$instance->includes();
				
				add_action('admin_init',          array(self::$instance, 'check_suite'));
				add_action('admin_init',          array(self::$instance, 'check_version'));
				add_action('plugins_loaded',      array(self::$instance, 'load_i18n'));
				add_filter('plugin_action_links', array(self::$instance, 'action_links'), 10, 2);
				add_filter('plugin_row_meta',     array(self::$instance, 'plugin_links'), 10, 2);
				
				add_filter('get_user_option_screen_layout_dashboard', 'dashboard_widgets_suite_dashboard_columns');
				add_filter('screen_layout_columns',                   'dashboard_widgets_suite_dashboard_columns_max');
				add_action('admin_head-index.php',                    'dashboard_widgets_suite_dashboard_columns_style');
				add_action('admin_enqueue_scripts',                   'dashboard_widgets_suite_enqueue_resources_admin');
				add_action('admin_notices',                           'dashboard_widgets_suite_admin_notice');
				add_action('admin_menu',                              'dashboard_widgets_suite_menu_pages');
				
				add_action('admin_init',                              'dashboard_widgets_suite_control_panel_submit');
				add_action('admin_init',                              'dashboard_widgets_suite_register_settings');
				add_action('admin_init',                              'dashboard_widgets_suite_register_list_box');
				add_action('admin_init',                              'dashboard_widgets_suite_reset_options');
				add_action('admin_init',                              'dashboard_widgets_suite_delete_notes');
				
				add_action('wp_enqueue_scripts', 'dashboard_widgets_suite_enqueue_resources_frontend'); 
				add_action('widgets_init',       'dashboard_widgets_suite_register_widget_box');
				add_action('init',               'dashboard_widgets_suite_notes_user_submit');
				
				add_shortcode('dws_feed_box',    'dashboard_widgets_suite_feed_box_frontend');
				add_shortcode('dws_social_box',  'dashboard_widgets_suite_social_box_frontend');
				add_shortcode('dws_user_notes',  'dashboard_widgets_suite_user_notes_frontend');
				
			}
			return self::$instance;
		}
		
		public static function options_feed_box() {
			$options = array(
				
				'widget_feed_box'          => false, 
				'widget_feed_box_front'    => false, 
				'widget_feed_box_excerpt'  => false,
				'widget_feed_box_limit'    => 3, 
				'widget_feed_box_length'   => 133, 
				'widget_feed_box_feed'     => 'https://perishablepress.com/feed/', 
				'widget_feed_box_view'     => 'all', 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_feed_box', $options);
		}
		
		public static function options_general() {
			$options = array(
				
				'dashboard_columns'        => 0, 
				'widget_control_panel'     => true, 
				'widget_control_view'      => 'all', 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_general', $options);
		}
		
		public static function options_list_box() {
			$options = array(
				
				'widget_list_box'          => false, 
				'widget_list_box_view'     => 'all', 
				'widget_list_box_menu'     => false,
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_list_box', $options);
		}
		
		public static function options_log_debug() {
			$options = array(
				
				'widget_log_debug'         => false, 
				'widget_log_debug_limit'   => 20, 
				'widget_log_debug_length'  => 350, 
				'widget_log_debug_height'  => 200, 
				'widget_log_debug_view'    => 'administrator', 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_log_debug', $options);
		}
		
		public static function options_log_error() {
			$options = array(
				
				'widget_log_error'         => false, 
				'widget_log_error_limit'   => 20, 
				'widget_log_error_length'  => 350, 
				'widget_log_error_height'  => 200, 
				'widget_log_error_path'    => self::log_path(), 
				'widget_log_error_view'    => 'administrator', 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_log_error', $options);
		}
		
		public static function options_notes_user() {
			
			$options = array(
				
				'widget_notes_user'        => false, 
				'widget_notes_user_front'  => false, 
				'widget_notes_count'       => 1, 
				'widget_notes_edit'        => 'all', 
				'widget_notes_view'        => 'all', 
				'widget_notes_message'     => __('Congrats! No notes to display.', 'dws'), 
				'widget_notes_height'      => 0, 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_notes_user', $options);
		}
		
		public static function options_social_box() {
			$options = array(
				
				'widget_social_box'        => false, 
				'widget_social_box_front'  => false, 
				'widget_social_box_size'   => 50, 
				'widget_social_box_font'   => 24, 
				'widget_social_box_radius' => 0, 
				'widget_social_box_space'  => 10, 
				'widget_social_box_view'   => 'all', 
				'widget_social_box_twit1'  => '#', 
				'widget_social_box_face1'  => '#', 
				'widget_social_box_goog1'  => '#', 
				'widget_social_box_pint1'  => '#', 
				'widget_social_box_lnkd1'  => '#', 
				'widget_social_box_feed1'  => '#', 
				'widget_social_box_skyp1'  => '#', 
				'widget_social_box_yout1'  => '#', 
				'widget_social_box_vime1'  => '#', 
				'widget_social_box_inst1'  => '#', 
				'widget_social_box_word1'  => '#', 
				'widget_social_box_tumb1'  => '#', 
				'widget_social_box_four1'  => '#', 
				'widget_social_box_eml1'   => '#', 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_social_box', $options);
		}
		
		public static function options_system_info() {
			$options = array(
				
				'widget_system_info'       => false,
				'widget_system_info_adv'   => false, 
				'widget_system_info_view'  => 'administrator', 
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_system_info', $options);
		}
		
		public static function options_widget_box() {
			$options = array(
				
				'widget_widget_box'         => false, 
				'widget_widget_box_view'    => 'all', 
				'widget_widget_box_sidebar' => 'dws-widget-box',
				
			);
			
			return apply_filters('dashboard_widgets_suite_options_widget_box', $options);
		}
		
		public static function log_path() {
			$log_path = isset($_SERVER['DOCUMENT_ROOT']) ? dirname($_SERVER['DOCUMENT_ROOT']) : '/var/www/vhosts/example.com';
			return $log_path .'/logs/error_log';
		}
		
		private function constants() {
			if (!defined('DWS_VERSION')) define('DWS_VERSION', '1.1');
			if (!defined('DWS_REQUIRE')) define('DWS_REQUIRE', '4.1');
			if (!defined('DWS_NAME'))    define('DWS_NAME',    'Dashboard Widgets Suite');
			if (!defined('DWS_AUTHOR'))  define('DWS_AUTHOR',  'Jeff Starr');
			if (!defined('DWS_HOME'))    define('DWS_HOME',    'https://perishablepress.com/dashboard-widgets-suite/');
			if (!defined('DWS_URL'))     define('DWS_URL',     plugin_dir_url(__FILE__));
			if (!defined('DWS_DIR'))     define('DWS_DIR',     plugin_dir_path(__FILE__));
			if (!defined('DWS_FILE'))    define('DWS_FILE',    plugin_basename(__FILE__));
			if (!defined('DWS_SLUG'))    define('DWS_SLUG',    basename(dirname(__FILE__)));
		}
		
		private function includes() {
			require_once DWS_DIR .'inc/dashboard-functions.php';
			require_once DWS_DIR .'inc/resources-enqueue.php';
			require_once DWS_DIR .'inc/settings-callbacks.php';
			require_once DWS_DIR .'inc/settings-display.php';
			require_once DWS_DIR .'inc/settings-process.php';
			require_once DWS_DIR .'inc/settings-register.php';
			require_once DWS_DIR .'inc/settings-reset.php';
			require_once DWS_DIR .'inc/settings-validate.php';
			require_once DWS_DIR .'inc/widgets-enable.php';
			require_once DWS_DIR .'inc/widgets-helper.php';
			require_once DWS_DIR .'inc/widgets-shortcodes.php';
		}
		
		public function action_links($links, $file) {
			if ($file == DWS_FILE) {
				
				$dws_links = '<a href="'. admin_url('options-general.php?page=dashboard_widgets_suite') .'">'. __('Settings', 'dws') .'</a>';
				array_unshift($links, $dws_links);
				
			}
			return $links;
		}
		
		public function plugin_links($links, $file) {
			if ($file == plugin_basename(__FILE__)) {
				
				$rate_href  = 'http://wordpress.org/support/view/plugin-reviews/'. DWS_SLUG .'?rate=5#postform';
				$rate_title = __('Click here to rate and review this plugin on WordPress.org', 'dws');
				$rate_text  = __('Rate this plugin', 'dws');
				
				$pro_href   = 'https://plugin-planet.com/dws-pro/?plugin';
				$pro_title  = __('Get Widgets Suite Pro!', 'dws');
				$pro_text   = __('Go&nbsp;Pro', 'dws');
				$pro_style  = 'padding:1px 5px;color:#eee;background:#333;border-radius:1px;';
				
				$links[]    = '<a target="_blank" href="'. $rate_href .'" title="'. $rate_title .'">'. $rate_text .'</a>';
				// $links[]    = '<a target="_blank" href="'. $pro_href .'" title="'. $pro_title .'" style="'. $pro_style .'">'. $pro_text .'</a>';
				
			}
			return $links;
		}
		
		public function check_suite() {
			if (class_exists('Widgets_Suite_Pro')) {
				if (is_plugin_active(DWS_FILE)) {
					deactivate_plugins(DWS_FILE);
					
					$msg  = '<strong>'. __('Warning:', 'dws') .'</strong> '. __('Pro version of Dashboard Widgets Suite currently active. Free and Pro versions cannot be activated at the same time. ', 'dws') .'</br />';
					$msg .= __('Please return to the', 'dws') .' <a href="'. admin_url() .'">'. __('WP Admin Area', 'dws') .'</a> '. __('and try again.', 'dws');
					
					wp_die($msg);
				}
			}
		}
		
		public function check_version() {
			global $wp_version;
			if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
				if (version_compare($wp_version, DWS_REQUIRE, '<')) {
					if (is_plugin_active(DWS_FILE)) {
						deactivate_plugins(DWS_FILE);
						$msg  = '<strong>'. DWS_NAME .'</strong> '. __('requires WordPress ', 'dws') . DWS_REQUIRE . __(' or higher, and has been deactivated!', 'dws') .'<br />';
						$msg .= __('Please return to the', 'dws') .' <a href="'. admin_url() .'">'. __('WP Admin Area', 'dws') .'</a> '. __('to upgrade WordPress and try again.', 'dws');
						wp_die($msg);
					}
				}
			}
		}
		
		public function load_i18n() {
			load_plugin_textdomain('dws', false, DWS_DIR .'lang/');
		}
		
		public function __clone() {
			_doing_it_wrong(__FUNCTION__, __('Cheatin&rsquo; huh?', 'dws'), DWS_VERSION);
		}
		
		public function __wakeup() {
			_doing_it_wrong(__FUNCTION__, __('Cheatin&rsquo; huh?', 'dws'), DWS_VERSION);
		}
		
	}
}

if (class_exists('Dashboard_Widgets_Suite')) {
	
	$dws_options_feed_box  = get_option('dws_options_feed_box', Dashboard_Widgets_Suite::options_feed_box());
	$dws_options_feed_box  = apply_filters('dashboard_widgets_suite_get_options_feed_box',  $dws_options_feed_box);
	
	$dws_options_notes_user = get_option('dws_options_notes_user', Dashboard_Widgets_Suite::options_notes_user());
	$dws_options_notes_user = apply_filters('dashboard_widgets_suite_get_options_notes_user', $dws_options_notes_user);
	
	$dws_options_social_box = get_option('dws_options_social_box', Dashboard_Widgets_Suite::options_social_box());
	$dws_options_social_box = apply_filters('dashboard_widgets_suite_get_options_social_box', $dws_options_social_box);
	
	if (is_admin()) {
		
		$dws_options_general     = get_option('dws_options_general',     Dashboard_Widgets_Suite::options_general());
		$dws_options_list_box    = get_option('dws_options_list_box',    Dashboard_Widgets_Suite::options_list_box());
		$dws_options_log_debug   = get_option('dws_options_log_debug',   Dashboard_Widgets_Suite::options_log_debug());
		$dws_options_log_error   = get_option('dws_options_log_error',   Dashboard_Widgets_Suite::options_log_error());
		$dws_options_system_info = get_option('dws_options_system_info', Dashboard_Widgets_Suite::options_system_info());
		$dws_options_widget_box  = get_option('dws_options_widget_box',  Dashboard_Widgets_Suite::options_widget_box());
		
		$dws_options_general     = apply_filters('dashboard_widgets_suite_get_options_general',     $dws_options_general);
		$dws_options_list_box    = apply_filters('dashboard_widgets_suite_get_options_list_box',    $dws_options_list_box);
		$dws_options_log_debug   = apply_filters('dashboard_widgets_suite_get_options_log_debug',   $dws_options_log_debug);
		$dws_options_log_error   = apply_filters('dashboard_widgets_suite_get_options_log_error',   $dws_options_log_error);
		$dws_options_system_info = apply_filters('dashboard_widgets_suite_get_options_system_info', $dws_options_system_info);
		$dws_options_widget_box  = apply_filters('dashboard_widgets_suite_get_options_widget_box',  $dws_options_widget_box);
		
	}
	
	if (!function_exists('dashboard_widgets_suite')) {
		
		function dashboard_widgets_suite() {
			
			do_action('dashboard_widgets_suite');
			
			return Dashboard_Widgets_Suite::instance();
		}
	}
	
	dashboard_widgets_suite();
	
}

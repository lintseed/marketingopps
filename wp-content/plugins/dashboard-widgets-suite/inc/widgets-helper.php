<?php // Dashboard Widgets Suite - Widget Helper Functions

if (!defined('ABSPATH')) exit;

function dashboard_widgets_suite_check_role($role) {
	
	if ($role === 'all') {
		
		return true;
		
	} else {
		
		return current_user_can($role) ? true : false;
		
	}
	
}

function dashboard_widgets_suite_get_date() {
	
	$date = date_i18n(get_option('date_format'), current_time('timestamp'));
	$time = date_i18n(get_option('time_format'), current_time('timestamp'));
	
	$date_time = array($date, $time);
	$date_time = apply_filters('dashboard_widgets_suite_get_date', $date_time);
	
	return $date_time;
	
}

function dashboard_widgets_suite_get_id($data) {
	
	$id = 1;
	
	$array = array();
	
	if (isset($data[0])) $array = $data[0];
	
	if (array_key_exists('id', $array)) {
		
		$ids = array_column($data, 'id');
		$max = max($ids);
		$id  = $max + 1;
		
	}
	
	return $id;
}

function dashboard_widgets_suite_get_ip() {
	
	$ip_address = getenv('REMOTE_ADDR') !== false ? getenv('REMOTE_ADDR') : false;
	
	if (isset($_SERVER)) {
		
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) $ip_address = $_SERVER["HTTP_X_FORWARDED_FOR"];
			
		elseif (isset($_SERVER["HTTP_CLIENT_IP"])) $ip_address = $_SERVER["HTTP_CLIENT_IP"];
		
	} else {
		
		if (getenv('HTTP_X_FORWARDED_FOR')) $ip_address = getenv('HTTP_X_FORWARDED_FOR');
			
		elseif (getenv('HTTP_CLIENT_IP')) $ip_address = getenv('HTTP_CLIENT_IP');
		
	}
	
	return sanitize_text_field($ip_address);
	
}

function dashboard_widgets_suite_register_widget_box() {
	
	$widget_args = array(
		
		'name'          => __('Dashboard Widgets Suite', 'dws'), 
		'description'   => __('Add widgets to the WordPress Dashboard', 'dws'), 
		'id'            => 'dws-widget-box', 
		'class'         => 'dws-widget-box', 
		'before_widget' => '<div id="%1$s" class="widget %2$s">', 
		'after_widget'  => '</div>', 
		'before_title'  => '<p class="widgettitle"><strong>', 
		'after_title'   => '</strong></p>', 
		
	);
	
	register_sidebar($widget_args);
	
}

function dashboard_widgets_suite_register_list_box() {
	
	$menu = 'Dashboard Widgets Suite';
	
	$menu_exists = wp_get_nav_menu_object($menu);
	
	if (!$menu_exists) {
		
		$menu_id = wp_create_nav_menu($menu);
		
		$menu_item_1 = array(
			'menu-item-attr-title'  => __('Home Page', 'dws'), 
			'menu-item-classes'     => 'dws-list-box-menu-item', 
			'menu-item-description' => __('This is an example link, edit as desired or delete if not needed.', 'dws'), 
			'menu-item-status'      => 'publish', 
			'menu-item-target'      => '_blank', 
			'menu-item-title'       =>  __('Home Page'), 
			'menu-item-url'         => home_url('/'), 
		);
		
		wp_update_nav_menu_item($menu_id, 0, $menu_item_1);
		
		$menu_item_2 = array(
			'menu-item-attr-title'  => __('Example Page', 'dws'), 
			'menu-item-classes'     => 'dws-list-box-menu-item', 
			'menu-item-description' => __('This is an example link, edit as desired or delete if not needed.', 'dws'), 
			'menu-item-status'      => 'publish', 
			'menu-item-target'      => '_blank', 
			'menu-item-title'       =>  __('Example Page'), 
			'menu-item-url'         => 'http://example.com/', 
		);
		
		wp_update_nav_menu_item($menu_id, 0, $menu_item_2);
		
		$menu_item_3 = array(
			'menu-item-attr-title'  => __('Custom Page', 'dws'), 
			'menu-item-classes'     => 'dws-list-box-menu-item', 
			'menu-item-description' => __('This is an example link, edit as desired or delete if not needed.', 'dws'), 
			'menu-item-status'      => 'publish', 
			'menu-item-target'      => '_blank', 
			'menu-item-title'       =>  __('Custom Page'), 
			'menu-item-url'         => 'http://example.com/custom/', 
		);
		
		wp_update_nav_menu_item($menu_id, 0, $menu_item_3);
		
	}
	
}

// Source: http://m0n.co/u
function dashboard_widgets_suite_get_log($path, $line_count, $block_size = 512) {
	
	$lines = array();
	
	$leftover = '';
	
	$fh = fopen($path, 'r');
	fseek($fh, 0, SEEK_END);
	
	do {
		
		$can_read = $block_size;
		
		if (ftell($fh) <= $block_size) $can_read = ftell($fh);
		
		if (empty($can_read)) break;
		
		fseek($fh, - $can_read, SEEK_CUR);
		
		$data  = fread($fh, $can_read);
		$data .= $leftover;
		
		fseek($fh, - $can_read, SEEK_CUR);
		
		$split_data = array_reverse(explode("\n", $data));
		$new_lines  = array_slice($split_data, 0, - 1);
		$lines      = array_merge($lines, $new_lines);
		$leftover   = $split_data[count($split_data) - 1];
		
	} while (count($lines) < $line_count && ftell($fh) != 0);
	
	if (ftell($fh) == 0) $lines[] = $leftover;
	
	fclose($fh);
	
	$lines = array_filter($lines);
	
	return array_slice($lines, 0, $line_count);
	
}

function dashboard_widgets_suite_allowed_tags() {

	$allowed_tags = array(
		'a' => array(
			'class' => array(),
			'href'  => array(),
			'rel'   => array(),
			'title' => array(),
		),
		'abbr' => array(
			'title' => array(),
		),
		'b' => array(),
		'blockquote' => array(
			'cite'  => array(),
		),
		'cite' => array(
			'title' => array(),
		),
		'code' => array(),
		'del' => array(
			'datetime' => array(),
			'title' => array(),
		),
		'dd' => array(),
		'div' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'dl' => array(),
		'dt' => array(),
		'em' => array(),
		'h1' => array(),
		'h2' => array(),
		'h3' => array(),
		'h4' => array(),
		'h5' => array(),
		'h6' => array(),
		'i' => array(),
		'img' => array(
			'alt'    => array(),
			'class'  => array(),
			'height' => array(),
			'src'    => array(),
			'width'  => array(),
		),
		'li' => array(
			'class' => array(),
		),
		'ol' => array(
			'class' => array(),
		),
		'p' => array(
			'class' => array(),
		),
		'q' => array(
			'cite' => array(),
			'title' => array(),
		),
		'span' => array(
			'class' => array(),
			'title' => array(),
			'style' => array(),
		),
		'strike' => array(),
		'strong' => array(),
		'ul' => array(
			'class' => array(),
		),
	);
	
	$allowed_tags = apply_filters('dashboard_widgets_suite_allowed_tags', $allowed_tags);
	
	return $allowed_tags;
}

if (!function_exists('boolval')) {
	
	function boolval($val) {
		
		return (bool) $val;
		
	}
	
}

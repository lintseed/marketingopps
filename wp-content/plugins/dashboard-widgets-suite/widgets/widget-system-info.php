<?php // Dashboard Widgets Suite - System Infos

if (!defined('ABSPATH')) exit;

/*
	
	Thanks to:
		
		johnregan3's Send System Info @ https://wordpress.org/plugins/send-system-info/
		cstrosser's TPC! Memory Usage @ https://wordpress.org/plugins/tpc-memory-usage/
	
*/

function dashboard_widgets_suite_system_info() {
	
	global $dws_options_system_info;
	
	$advanced = isset($dws_options_system_info['widget_system_info_adv']) ? $dws_options_system_info['widget_system_info_adv'] : false;
	
	do_action('dashboard_widgets_suite_system_info', $dws_options_system_info);
	
	echo '<div id="dws-system-info">';
	
	if ($advanced) {
		
		echo '<ul class="dws-system-info-menu">';
		
		echo '<li><a href="#dws-system-info-overview" data-rel="dws-system-info-overview" class="selected">'. __('Overview', 'dws') .'</a></li>';
		echo '<li><a href="#dws-system-info-wordpress" data-rel="dws-system-info-wordpress">'. __('WordPress', 'dws') .'</a></li>';
		echo '<li><a href="#dws-system-info-client"    data-rel="dws-system-info-client">'.    __('Client',    'dws') .'</a></li>';
		echo '<li><a href="#dws-system-info-server"    data-rel="dws-system-info-server">'.    __('Server',    'dws') .'</a></li>';
		echo '<li><a href="#dws-system-info-database"  data-rel="dws-system-info-database">'.  __('Database',  'dws') .'</a></li>';
		echo '<li><a href="#dws-system-info-php"       data-rel="dws-system-info-php">'.       __('PHP',       'dws') .'</a></li>';
		echo '<li><a href="#dws-system-info-security"  data-rel="dws-system-info-security">'.  __('Security',  'dws') .'</a></li>';
		
		echo '</ul>';
		
	}
	
	echo '<div class="dws-system-info" id="dws-system-info-overview">';
	dashboard_widgets_suite_get_overview();
	echo '</div>';
	
	if ($advanced) {
		
		echo '<div class="dws-system-info dws-hidden" id="dws-system-info-wordpress">';
		dashboard_widgets_suite_get_wordpress_infos();
		echo '</div>';
		
		echo '<div class="dws-system-info dws-hidden" id="dws-system-info-client">';
		dashboard_widgets_suite_get_client_infos();
		echo '</div>';
		
		echo '<div class="dws-system-info dws-hidden" id="dws-system-info-server">';
		dashboard_widgets_suite_get_server_infos();
		echo '</div>';
		
		echo '<div class="dws-system-info dws-hidden" id="dws-system-info-database">';
		dashboard_widgets_suite_get_database_infos();
		echo '</div>';
		
		echo '<div class="dws-system-info dws-hidden" id="dws-system-info-php">';
		dashboard_widgets_suite_get_php_info();
		echo '</div>';
		
		echo '<div class="dws-system-info dws-hidden" id="dws-system-info-security">';
		dashboard_widgets_suite_check_security();
		echo '</div>';
		
	}
	
	echo '</div>';
	
}





function dashboard_widgets_suite_get_overview() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('System Overview', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('WP Version: ',          'dws'); echo dashboard_widgets_suite_get_wp_version(); ?></li>
		<li><?php _e('PHP Version: ',         'dws'); echo dashboard_widgets_suite_get_php_version(); ?></li>
		<li><?php _e('Database Version: ',    'dws'); echo dashboard_widgets_suite_get_database_version(); ?></li>
		<li><?php _e('Client IP Address: ',   'dws'); echo dashboard_widgets_suite_get_ip(); ?></li>
		<li><?php _e('Server IP Address: ',   'dws'); echo dashboard_widgets_suite_get_server_address(); ?></li>
		<li><?php _e('Server Load: ',         'dws'); echo dashboard_widgets_suite_get_server_load(); ?></li>
		<li><?php _e('Server Load Average: ', 'dws'); echo dashboard_widgets_suite_get_server_load_average(); ?></li>
		<li><?php _e('PHP Memory Usage: ',    'dws'); echo dashboard_widgets_suite_get_memory_usage(); ?></li>
	</ul>
	
	<?php
}





/*
	
	WORDPRESS INFOS
	
*/

function dashboard_widgets_suite_get_wordpress_infos() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('WordPress Info', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('WP Version: ',             'dws'); echo dashboard_widgets_suite_get_wp_version(); ?></li>
		<li><?php _e('Active Theme: ',           'dws'); echo dashboard_widgets_suite_get_theme_info(); ?></li>
		<li><?php _e('WP Memory Limit: ',        'dws'); echo dashboard_widgets_suite_get_wp_memory_limit(); ?></li>
		<li><?php _e('WP Remote Post: ',         'dws'); echo dashboard_widgets_suite_check_remote_post(); ?></li>
		<li><?php _e('WP Debug Mode: ',          'dws'); echo dashboard_widgets_suite_get_wp_debug_mode(); ?></li>
		<li><?php _e('WP Debug Log: ',           'dws'); echo dashboard_widgets_suite_get_wp_debug_log(); ?></li>
		<li><?php _e('WP Debug Display: ',       'dws'); echo dashboard_widgets_suite_get_wp_debug_display(); ?></li>
		<li><?php _e('WP Debug Script: ',        'dws'); echo dashboard_widgets_suite_get_wp_script_debug(); ?></li>
		<li><?php _e('Query Logging: ',          'dws'); echo dashboard_widgets_suite_get_wp_save_queries(); ?></li>
		<li><?php _e('Disallow File Edit: ',     'dws'); echo dashboard_widgets_suite_get_wp_file_edit(); ?></li>
		<li><?php _e('Allow Core Auto Update: ', 'dws'); echo dashboard_widgets_suite_get_wp_core_update(); ?></li>
		<li><?php _e('WP DB Hostname: ',         'dws'); echo dashboard_widgets_suite_get_wp_db_hostname(); ?></li>
		<li><?php _e('WP DB Name: ',             'dws'); echo dashboard_widgets_suite_get_wp_db_name(); ?></li>
		<li><?php _e('Active Plugins: ',         'dws'); echo dashboard_widgets_suite_get_wp_active_plugins(); ?></li>
		<li><?php _e('WP Language: ',            'dws'); echo dashboard_widgets_suite_get_wp_language(); ?></li>
		<li><?php _e('Advanced Caching: ',       'dws'); echo dashboard_widgets_suite_get_wp_advanced_cache(); ?></li>
		<li><?php _e('External Object Cache: ',  'dws'); echo dashboard_widgets_suite_get_wp_object_cache(); ?></li>
		<li><?php _e('WordPress Time: ',         'dws'); echo dashboard_widgets_suite_get_wp_time(); ?></li>
		<li><?php _e('Update Method: ',          'dws'); echo dashboard_widgets_suite_get_wp_update_methods(); ?></li>
	</ul>
	
	<?php
}

function dashboard_widgets_suite_get_wp_version() {
	
	return get_bloginfo('version');
	
}

function dashboard_widgets_suite_get_theme_info() {
	
	$theme_data = wp_get_theme();
	
	$theme_info = $theme_data->Name . __(', Version ', 'dws') . $theme_data->Version;
	
	return $theme_info;
		
}

function dashboard_widgets_suite_get_wp_memory_limit() {
	
	$v   = WP_MEMORY_LIMIT;
	
	$l   = substr($v, -1);
	$ret = substr($v, 0, -1);
	
	switch (strtoupper($l)) {
		case 'P':
		case 'T':
		case 'G':
		case 'M':
		case 'K': $ret *= 1024;
		break;
		default:
		break;
	}
	
	return ($ret / 1024) .' MB';
}

function dashboard_widgets_suite_check_remote_post() {
	
	$test_url = 'https://www.paypal.com/cgi-bin/webscr';
	$request['cmd'] = '_notify-validate';
	
	$params = array(
		'method'    => 'POST',
		'sslverify' => true,
		'timeout'   => 60,
		'body'      => $request,
	);
	
	$response = wp_remote_post($test_url, $params);
	
	if (!is_wp_error($response) && $response['response']['code'] >= 200 && $response['response']['code'] < 300) {
		
		$result = __('Enabled', 'dws');
		
	} else {
		
		$result = __('Disabled', 'dws');
		
	}
	
	return $result;
	
}

function dashboard_widgets_suite_get_wp_debug_mode() {
	
	return defined('WP_DEBUG') && WP_DEBUG ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_debug_log() {
	
	return defined('WP_DEBUG_LOG') && WP_DEBUG_LOG ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_debug_display() {
	
	return defined('WP_DEBUG_DISPLAY') && WP_DEBUG_DISPLAY ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_script_debug() {
	
	return defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_save_queries() {
	
	return defined('SAVEQUERIES') && SAVEQUERIES ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_file_edit() {
	
	return defined('DISALLOW_FILE_EDIT') && DISALLOW_FILE_EDIT ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_core_update() {
	
	return defined('WP_AUTO_UPDATE_CORE') && WP_AUTO_UPDATE_CORE ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_db_hostname() {
	
	return sanitize_text_field(DB_HOST);
	
}

function dashboard_widgets_suite_get_wp_db_name() {
	
	return sanitize_text_field(DB_NAME);
	
}

function dashboard_widgets_suite_get_wp_active_plugins() {
	
	return count(get_option('active_plugins'));
	
}

function dashboard_widgets_suite_get_wp_language() {
	
	return defined('WPLANG') && WPLANG !== '' ? WPLANG : __('English', 'dws') .' / '. get_locale();
	
}

function dashboard_widgets_suite_get_wp_advanced_cache() {
	
	return defined('WP_CACHE') && WP_CACHE ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_object_cache() {
	
	global $_wp_using_ext_object_cache;
	
	return $_wp_using_ext_object_cache ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_wp_time() {
	
	return sanitize_text_field(current_time('mysql'));
	
}

function dashboard_widgets_suite_get_wp_update_methods() {
	
	$filesystem_method = get_filesystem_method(array());
	$filesystem_message = $filesystem_method !== 'direct' ? __('FTP/SSH access only', 'usp') : __('Direct access allowed', 'usp');
	
	return $filesystem_message;
	
}





/*
	
	CLIENT INFOS
	
*/

function dashboard_widgets_suite_get_client_infos() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('Client Info', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('Platform: ',        'dws'); echo dashboard_widgets_suite_get_platform(); ?></li>
		<li><?php _e('Browser: ',         'dws'); echo dashboard_widgets_suite_get_browser(); ?></li>
		<li><?php _e('IP Address: ',      'dws'); echo dashboard_widgets_suite_get_ip(); ?></li>
		<li><?php _e('User Agent: ',      'dws'); echo dashboard_widgets_suite_get_user_agent(); ?></li>
		<li><?php _e('Hostname: ',        'dws'); echo dashboard_widgets_suite_get_host_name(); ?></li>
		<li><?php _e('Client Port: ',     'dws'); echo dashboard_widgets_suite_get_client_port(); ?></li>
	</ul>
	
	<?php
}

function dashboard_widgets_suite_get_platform() {
	
	$user_agent  = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'n/a';
	
	$os_platform = __('Unknown OS Platform', 'dws');
	
	$os_array    = array(
		
		'/windows nt 6.2/i'     =>  'Windows 8',
		'/windows nt 6.1/i'     =>  'Windows 7',
		'/windows nt 6.0/i'     =>  'Windows Vista',
		'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
		'/windows nt 5.1/i'     =>  'Windows XP',
		'/windows xp/i'         =>  'Windows XP',
		'/windows nt 5.0/i'     =>  'Windows 2000',
		'/windows me/i'         =>  'Windows ME',
		'/win98/i'              =>  'Windows 98',
		'/win95/i'              =>  'Windows 95',
		'/win16/i'              =>  'Windows 3.11',
		'/macintosh|mac os x/i' =>  'Mac OS X',
		'/mac_powerpc/i'        =>  'Mac OS 9',
		'/linux/i'              =>  'Linux',
		'/ubuntu/i'             =>  'Ubuntu',
		'/iphone/i'             =>  'iPhone',
		'/ipod/i'               =>  'iPod',
		'/ipad/i'               =>  'iPad',
		'/android/i'            =>  'Android',
		'/blackberry/i'         =>  'BlackBerry',
		'/webos/i'              =>  'Mobile'
		
	);
	
	foreach ($os_array as $regex => $value) {
		
		if (preg_match($regex, $user_agent)) {
			
			$os_platform = $value;
			
			break;
			
		}
	
	}
	
	return $os_platform;
	
}

function dashboard_widgets_suite_get_browser() {
	
	$user_agent    = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'n/a';
	
	$browser       = __('Unknown Browser', 'dws');
	
	$browser_array = array(
		
		'/msie/i'      =>  'Internet Explorer',
		'/firefox/i'   =>  'Firefox',
		'/chrome/i'    =>  'Chrome',
		'/safari/i'    =>  'Safari',
		'/opera/i'     =>  'Opera',
		'/netscape/i'  =>  'Netscape',
		'/maxthon/i'   =>  'Maxthon',
		'/konqueror/i' =>  'Konqueror',
		'/mobile/i'    =>  'Handheld Browser'
		
	);
	
	foreach ($browser_array as $regex => $value) {
		
		if (preg_match($regex, $user_agent)) {
			
			$browser = $value;
			
			break;
			
		}
		
	}
	
	return $browser;
	
}

function dashboard_widgets_suite_get_user_agent() {
	
	return isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field($_SERVER['HTTP_USER_AGENT']) : 'n/a';
	
}

function dashboard_widgets_suite_get_host_name() {
	
	return isset($_SERVER['REMOTE_ADDR']) ? sanitize_text_field(gethostbyaddr($_SERVER['REMOTE_ADDR'])) : 'n/a';
	
}

function dashboard_widgets_suite_get_client_port() {
	
	return isset($_SERVER['REMOTE_PORT']) ? sanitize_text_field($_SERVER['REMOTE_PORT']) : 'n/a';
	
}





/*
	
	SERVER INFOS
	
*/

function dashboard_widgets_suite_get_server_infos() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('Server Info', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('OS/Server: ',        'dws'); echo dashboard_widgets_suite_get_server_name(); ?></li>
		<li><?php _e('Server Software: ',  'dws'); echo dashboard_widgets_suite_get_server_software(); ?></li>
		<li><?php _e('Server Version: ',   'dws'); echo dashboard_widgets_suite_get_server_version(); ?></li>
		<li><?php _e('Server Address: ',   'dws'); echo dashboard_widgets_suite_get_server_address(); ?></li>
		<li><?php _e('Server Port: ',      'dws'); echo dashboard_widgets_suite_get_server_port(); ?></li>
		<li><?php _e('Document Root: ',    'dws'); echo dashboard_widgets_suite_get_document_root(); ?></li>
		<li><?php _e('Server Name: ',      'dws'); echo dashboard_widgets_suite_get_hostname(); ?></li>
		<li><?php _e('Server Load: ',      'dws'); echo dashboard_widgets_suite_get_server_load(); ?></li>
		<li><?php _e('Load Average: ',     'dws'); echo dashboard_widgets_suite_get_server_load_average(); ?></li>
		<li><?php _e('Server Signature: ', 'dws'); echo dashboard_widgets_suite_get_serversignature(); ?></li>
		<li><?php _e('Apache Modules: ',   'dws'); echo dashboard_widgets_suite_get_apache_modules(); ?></li>
		<li><?php _e('Server Protocol: ',  'dws'); echo dashboard_widgets_suite_get_server_protocol(); ?></li>
		<li><?php _e('HTTP Connection: ',  'dws'); echo dashboard_widgets_suite_get_http_connection(); ?></li>
		<li><?php _e('Server Gateway: ',   'dws'); echo dashboard_widgets_suite_get_server_gateway(); ?></li>
		<li><?php _e('Server Time: ',      'dws'); echo dashboard_widgets_suite_get_server_time(); ?></li>
	</ul>
	
	<?php
}

function dashboard_widgets_suite_get_server_name() {
	
	return sanitize_text_field(php_uname());
	
}

function dashboard_widgets_suite_get_server_software() {
	
	return isset($_SERVER['SERVER_SOFTWARE']) ? sanitize_text_field($_SERVER['SERVER_SOFTWARE']) : 'n/a';
	
}

function dashboard_widgets_suite_get_server_version() {
	
	return sanitize_text_field(PHP_INT_SIZE * 8) . __('Bit', 'dws');
	
}

function dashboard_widgets_suite_get_server_address() {
	
	return isset($_SERVER['SERVER_ADDR']) ? sanitize_text_field($_SERVER['SERVER_ADDR']) : 'n/a';
	
}

function dashboard_widgets_suite_get_server_port() {
	
	return isset($_SERVER['SERVER_PORT']) ? sanitize_text_field($_SERVER['SERVER_PORT']) : 'n/a';
	
}

function dashboard_widgets_suite_get_document_root() {
	
	return isset($_SERVER['DOCUMENT_ROOT']) ? sanitize_text_field($_SERVER['DOCUMENT_ROOT']) : 'n/a';
	
}

function dashboard_widgets_suite_get_server_load_average() {
	
	if (stristr(PHP_OS, 'win')) {
		
		$wmi = new COM("Winmgmts://");
		$server = $wmi->execquery("SELECT LoadPercentage FROM Win32_Processor");
		
		$cpu_num = 0;
		$load_total = 0;
		
		foreach($server as $cpu) {
			$cpu_num++;
			$load_total += $cpu->loadpercentage;
		}
		
		$load = round($load_total / $cpu_num);
		
	} else {
		
		$sys_loadavg = sys_getloadavg();
		$sys_load = (is_array($sys_loadavg)) ? $sys_loadavg : array(0);
		$load = array_sum($sys_load) / count($sys_load);
		
		// $load = $sys_load[0];
		
	}
	
	return round($load, 3);
	
}

function dashboard_widgets_suite_get_server_load() {
	
	if (!function_exists('sys_getloadavg')) return 'n/a';
	
	$avgs = sys_getloadavg();
	
	if (!is_array($avgs)) return 'n/a';
	
	$load = '';
	
	foreach ($avgs as $avg) {
		
		$class = 'dws-color-good';
		
		if     ($avg >= 2 && $avg < 3) $class = 'dws-color-fair';
		elseif ($avg >= 3)             $class = 'dws-color-poor';      
		
		$load .= ' <span class="'. $class .'">'. $avg .'</span>, ';
		
	}
	
	$load = rtrim(trim($load), ',');
	
	return $load;
	
}

function dashboard_widgets_suite_get_hostname() {
	
	return sanitize_text_field($_SERVER['SERVER_NAME']);
	
}

function dashboard_widgets_suite_get_serversignature() {
	
	$disabled  = __('Disabled', 'dws');
	$signature = $disabled;
	
	if (isset($_SERVER['SERVER_SIGNATURE'])) {
		
		$signature = trim($_SERVER['SERVER_SIGNATURE']) !== '' ? $_SERVER['SERVER_SIGNATURE'] : $disabled;
		
	}
	
	return sanitize_text_field($signature);
	
}

function dashboard_widgets_suite_get_apache_modules() {
	
	$modules = function_exists('apache_get_modules') ? implode(', ', (array) apache_get_modules()) : 'n/a';
	
	return sanitize_text_field($modules);
}

function dashboard_widgets_suite_get_server_protocol() {
	
	return isset($_SERVER['SERVER_PROTOCOL']) ? sanitize_text_field($_SERVER['SERVER_PROTOCOL']) : 'n/a';
	
}

function dashboard_widgets_suite_get_http_connection() {
	
	return isset($_SERVER['HTTP_CONNECTION']) ? sanitize_text_field($_SERVER['HTTP_CONNECTION']) : 'n/a';
	
}

function dashboard_widgets_suite_get_server_gateway() {
	
	return isset($_SERVER['GATEWAY_INTERFACE']) ? $_SERVER['GATEWAY_INTERFACE'] : 'n/a';
	
}

function dashboard_widgets_suite_get_server_time() {
	
	return date('Y-m-d H:i:s');
	
}





/*
	
	DATABASE INFOS
	
*/

function dashboard_widgets_suite_get_database_infos() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('Database Info', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('Database: ', 'dws'); echo dashboard_widgets_suite_get_database_name(); ?></li>
		<li><?php _e('Version: ',  'dws'); echo dashboard_widgets_suite_get_database_version(); ?></li>
		<li><?php _e('SQL: ',      'dws'); echo dashboard_widgets_suite_get_database_client_version(); ?></li>
		<li><?php _e('Uptime: ',   'dws'); echo dashboard_widgets_suite_get_database_uptime(); ?></li>
		<li><?php _e('Hostname: ', 'dws'); echo dashboard_widgets_suite_get_database_hostname(); ?></li>
		<li><?php _e('Charset: ',  'dws'); echo dashboard_widgets_suite_get_database_charset(); ?></li>
	</ul>
	
	<?php
}

if (!function_exists('mysql_get_client_info')) {
	
	function mysql_get_client_info() {
		
		// need replacement for PHP 7.0+
		
		echo 'n/a';
		
	}
	
}

function dashboard_widgets_suite_get_database_vars() {
	
	global $wpdb;
	
	if (!$results = $wpdb->get_results('SHOW GLOBAL VARIABLES')) return false;
	
	$mysql_vars = array();
	
	foreach ($results as $result) {
		
		$mysql_vars[$result->Variable_name] = $result->Value;
		
	}
	
	return $mysql_vars;
	
}

function dashboard_widgets_suite_get_database_status() {
	
	global $wpdb;
	
	if (!$results = $wpdb->get_results('SHOW GLOBAL STATUS')) return false;
	
	$mysql_status = array();
	
	foreach ($results as $result) {
		
		$mysql_status[$result->Variable_name] = $result->Value;
		
	}
	
	return $mysql_status;
	
}

function dashboard_widgets_suite_get_database_name() {
	
	$vars = dashboard_widgets_suite_get_database_vars();
	
	return (isset($vars['version_comment']) && !empty($vars['version_comment'])) ? sanitize_text_field($vars['version_comment']) : 'n/a';
	
}

function dashboard_widgets_suite_get_database_version() {
	
	$vars = dashboard_widgets_suite_get_database_vars();
	
	return (isset($vars['version']) && !empty($vars['version'])) ? sanitize_text_field($vars['version']) : 'n/a';
	
}

function dashboard_widgets_suite_get_database_client_version() {
	
	return sanitize_text_field(mysql_get_client_info());
	
}

function dashboard_widgets_suite_get_database_uptime() {
	
	$mysql_uptime = dashboard_widgets_suite_get_database_status();
	
	$uptime = (isset($mysql_uptime['Uptime']) && !empty($mysql_uptime['Uptime'])) ? $mysql_uptime['Uptime'] : 0;
	
	$uptime_seconds = $uptime % 60;
	$uptime_minutes = (int) (($uptime % 3600) / 60);
	$uptime_hours   = (int) (($uptime % 86400) / 3600);
	$uptime_days    = (int) ($uptime / 86400);
	
	if ($uptime_days > 0) {
		
		$uptime_string = "{$uptime_days} days, {$uptime_hours} hours, {$uptime_minutes} minutes, {$uptime_seconds} seconds";
		
	} elseif ($uptime_hours > 0) {
		
		$uptime_string = "{$uptime_hours} hours, {$uptime_minutes} minutes, {$uptime_seconds} seconds";
		
	} elseif ($uptime_minutes > 0) {
		
		$uptime_string = "{$uptime_minutes} minutes, {$uptime_seconds} seconds";
		
	} else {
		
		$uptime_string = "{$uptime_seconds} seconds";
		
	}
	
	return sanitize_text_field($uptime_string);
	
}

function dashboard_widgets_suite_get_database_hostname() {
	
	$vars = dashboard_widgets_suite_get_database_vars();
	
	return (isset($vars['hostname']) && !empty($vars['hostname'])) ? sanitize_text_field($vars['hostname']) : 'n/a';
	
}

function dashboard_widgets_suite_get_database_charset() {
	
	return defined('DB_CHARSET') ? sanitize_text_field(DB_CHARSET) : 'n/a';
	
}





/*
	
	PHP INFOS
	
*/

function dashboard_widgets_suite_get_php_info() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('PHP Info', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('PHP Version: ',                         'dws'); echo dashboard_widgets_suite_get_php_version(); ?></li>
		<li><?php _e('Zend Engine: ',                         'dws'); echo dashboard_widgets_suite_get_php_zend_engine(); ?></li>
		<li><?php _e('PHP Memory Limit (runtime / server): ', 'dws'); echo dashboard_widgets_suite_get_php_memory(); ?></li>
		<li><?php _e('PHP Memory Usage: ',                    'dws'); echo dashboard_widgets_suite_get_memory_usage(); ?></li>
		<li><?php _e('PHP Peak Memory Usage: ',               'dws'); echo dashboard_widgets_suite_get_peak_memory_usage(); ?></li>
		<li><?php _e('PHP Post Max Size: ',                   'dws'); echo dashboard_widgets_suite_get_php_post_max_size(); ?></li>
		<li><?php _e('PHP Upload Max File Size: ',            'dws'); echo dashboard_widgets_suite_get_php_upload_max_size(); ?></li>
		<li><?php _e('PHP Execution Time Limit: ',            'dws'); echo dashboard_widgets_suite_get_php_exec_limit(); ?></li>
		<li><?php _e('PHP Input Time Limit: ',                'dws'); echo dashboard_widgets_suite_get_php_input_limit(); ?></li>
		<li><?php _e('PHP Max Input Vars: ',                  'dws'); echo dashboard_widgets_suite_get_php_max_vars(); ?></li>
		<li><?php _e('PHP Include Path: ',                    'dws'); echo dashboard_widgets_suite_get_php_include_path(); ?></li>
		<li><?php _e('PHP Allow URL File Open: ',             'dws'); echo dashboard_widgets_suite_get_php_file_open(); ?></li>
		<li><?php _e('PHP File Uploads: ',                    'dws'); echo dashboard_widgets_suite_get_php_file_uploads(); ?></li>
		<li><?php _e('Session: ',                             'dws'); echo dashboard_widgets_suite_get_php_session_info(); ?></li>
		<li><?php _e('Session Name: ',                        'dws'); echo dashboard_widgets_suite_get_php_session_name(); ?></li>
		<li><?php _e('Cookie Path: ',                         'dws'); echo dashboard_widgets_suite_get_php_cookie_path(); ?></li>
		<li><?php _e('Save Path: ',                           'dws'); echo dashboard_widgets_suite_get_php_save_path(); ?></li>
		<li><?php _e('Use Cookies: ',                         'dws'); echo dashboard_widgets_suite_get_php_use_cookies(); ?></li>
		<li><?php _e('Use Only Cookies: ',                    'dws'); echo dashboard_widgets_suite_get_php_only_cookies(); ?></li>
		<li><?php _e('Loaded Extensions: ',                   'dws'); echo dashboard_widgets_suite_get_php_loaded_extensions(); ?></li>
		<li><?php _e('open_basedir: ',                        'dws'); echo dashboard_widgets_suite_get_php_open_basedir(); ?></li>
		<li><?php _e('fsockopen: ',                           'dws'); echo dashboard_widgets_suite_get_php_fsockopen(); ?></li>
		<li><?php _e('cURL: ',                                'dws'); echo dashboard_widgets_suite_get_php_curl(); ?></li>
		<li><?php _e('SOAP Client: ',                         'dws'); echo dashboard_widgets_suite_get_php_soap_client(); ?></li>
		<li><?php _e('Short Open Tag: ',                      'dws'); echo dashboard_widgets_suite_get_php_short_open_tag(); ?></li>
	</ul>
	
	<?php
}

function dashboard_widgets_suite_get_php_version() {
	
	return defined('PHP_VERSION') ? sanitize_text_field(PHP_VERSION) : 'n/a';
	
}

function dashboard_widgets_suite_get_php_zend_engine() {
	
	return sanitize_text_field(zend_version());
	
}

/*
	
	ini_get()     : returns runtime config value (i.e., values set by ini_set(), .htaccess, local php.ini file, and other functions at runtime)
	get_cfg_var() : returns strictly the server php.ini
	
*/
function dashboard_widgets_suite_get_php_memory() {
	
	$memory_runtime = ini_get('memory_limit');
	$memory_server  = get_cfg_var('memory_limit');
	
	return sanitize_text_field($memory_runtime .' / '. $memory_server);
		
}

function dashboard_widgets_suite_get_memory_usage() {
	
	$load = function_exists('memory_get_usage') ? round(memory_get_usage() / 1024 / 1024, 2) : 0;
	
	$limit = (int) ini_get('memory_limit'); // get_cfg_var('memory_limit');
	
	$usage = round($load / $limit * 100, 0);
	
	return $usage .'% <span class="dws-color-grey">('. $load .'M '.  __('of ', 'dws') . $limit .'M)</span>'; 
	
}

function dashboard_widgets_suite_get_peak_memory_usage() {
	
	$mem = function_exists('memory_get_peak_usage') ? memory_get_peak_usage(true) : 0;
	
	if ($mem < 1024) {
		
		$$memory = $mem .'B'; 
		
	} elseif ($mem < 1048576) {
		
		$memory = round($mem / 1024, 2) .'K';
		
	} else {
		
		$memory = round($mem / 1048576, 2) .'M';
		
	}
	
	return $memory;
	
}

function dashboard_widgets_suite_get_php_post_max_size() {
	
	return sanitize_text_field(ini_get('post_max_size'));
	
}

function dashboard_widgets_suite_get_php_upload_max_size() {
	
	return sanitize_text_field(ini_get('upload_max_filesize'));
	
}

function dashboard_widgets_suite_get_php_exec_limit() {
	
	return sanitize_text_field(ini_get('max_execution_time')) .'s';
		
}

function dashboard_widgets_suite_get_php_input_limit() {
	
	return sanitize_text_field(ini_get('max_input_time')) .'s';
	
}

function dashboard_widgets_suite_get_php_max_vars() {
	
	return sanitize_text_field(ini_get('max_input_vars'));
	
}

function dashboard_widgets_suite_get_php_include_path() {
	
	return sanitize_text_field(ini_get('include_path'));
	
}

function dashboard_widgets_suite_get_php_file_open() {
	
	return ini_get('allow_url_fopen') ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_file_uploads() {
	
	return ini_get('file_uploads') ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_session_info() {
	
	return isset($_SESSION) ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_session_name() {
	
	return sanitize_text_field(ini_get('session.name'));
	
}

function dashboard_widgets_suite_get_php_cookie_path() {
	
	return sanitize_text_field(ini_get('session.cookie_path'));
	
}

function dashboard_widgets_suite_get_php_save_path() {
	
	return sanitize_text_field(ini_get('session.save_path'));
	
}

function dashboard_widgets_suite_get_php_use_cookies() {
	
	return sanitize_text_field(ini_get('session.use_cookies')) ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_only_cookies() {
	
	return sanitize_text_field(ini_get('session.use_only_cookies')) ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_loaded_extensions() {
	
	return sanitize_text_field(implode(', ', get_loaded_extensions()));
	
}

function dashboard_widgets_suite_get_php_open_basedir() {
	
	return sanitize_text_field(ini_get('open_basedir'));
	
}

function dashboard_widgets_suite_get_php_fsockopen() {
	
	return function_exists('fsockopen') ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_curl() {
	
	return function_exists('curl_init') ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_soap_client() {
	
	return class_exists('SoapClient') ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}

function dashboard_widgets_suite_get_php_short_open_tag() {
	
	return ini_get('short_open_tag') ? __('Enabled', 'dws') : __('Disabled', 'dws');
	
}





/*
	
	SECURITY INFOS
	
*/

function dashboard_widgets_suite_check_security() { ?>
	
	<p><span class="fa fa-info-circle"></span> <strong><?php _e('Security Info', 'dws'); ?></strong></p>
	<ul>
		<li><?php _e('Register Globals: ',  'dws'); echo dashboard_widgets_suite_check_register_globals(); ?></li>
		<li><?php _e('Safe Mode: ',         'dws'); echo dashboard_widgets_suite_check_safe_mode(); ?></li>
		<li><?php _e('Display Errors: ',    'dws'); echo dashboard_widgets_suite_check_display_errors(); ?></li>
		<li><?php _e('allow_url_include: ', 'dws'); echo dashboard_widgets_suite_check_url_include(); ?></li>
		<li><?php _e('allow_url_fopen: ',   'dws'); echo dashboard_widgets_suite_check_url_fopen(); ?></li>
		<li><?php _e('Magic Quotes: ',      'dws'); echo dashboard_widgets_suite_check_magic_quotes(); ?></li>
		<li><?php _e('Server Signature: ',  'dws'); echo dashboard_widgets_suite_check_serversignature(); ?></li>
		<li><?php _e('WP Unique Keys: ',    'dws'); echo dashboard_widgets_suite_check_uniquekeys(); ?></li>
		<li><?php _e('mod_security: ',      'dws'); echo dashboard_widgets_suite_check_modsecurity(); ?></li>
		<li><?php _e('open_basedir: ',      'dws'); echo dashboard_widgets_suite_check_openbasedir(); ?></li>
		<li><?php _e('upload_tmp_dir: ',    'dws'); echo dashboard_widgets_suite_check_upload_tmp_dir(); ?></li>
		<li><?php _e('expose_php: ',        'dws'); echo dashboard_widgets_suite_check_expose_php(); ?></li>
	</ul>
	
	<?php	
}

function dashboard_widgets_suite_check_register_globals() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('register_globals') ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_safe_mode() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('safe_mode') ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_display_errors() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('display_errors') ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_url_include() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('allow_url_include') ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_url_fopen() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('allow_url_fopen') ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_magic_quotes() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return get_magic_quotes_gpc() ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_serversignature() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return isset($_SERVER['SERVER_SIGNATURE']) && trim($_SERVER['SERVER_SIGNATURE']) !== '' ? $enabled_poor : $disabled_good;
	
}

function dashboard_widgets_suite_check_uniquekeys() {
	
	$enabled_good  = '<span class="dws-color-good">'. __('Enabled', 'dws') .'</span>';
	$disabled_poor = '<span class="dws-color-poor">'. __('Disabled', 'dws') .'</span>';
	
	$keys = array('AUTH_KEY', 'SECURE_AUTH_KEY', 'LOGGED_IN_KEY', 'NONCE_KEY');
	
	foreach ($keys as $key) {
		
		if (defined($key)) {
			
			if ('put your unique phrase here' == constant($key)) return $disabled_poor;
			
		} else {
			
			return $disabled_poor;
			
		}
		
	}
	
	return $enabled_good;
}

function dashboard_widgets_suite_check_modsecurity() {
	
	$enabled_good  = '<span class="dws-color-good">'. __('Enabled', 'dws') .'</span>';
	$disabled_poor = '<span class="dws-color-poor">'. __('Disabled', 'dws') .'</span>';
	$unknown_warn  = '<span class="dws-color-warn">'. __('Not Installed', 'dws') .'</span>';
	
	if (function_exists('apache_get_modules')) {
		
		$apache_mods = apache_get_modules(); // note: apache_get_modules() does not work if running PHP as CGI
		
		$mod_security = in_array('mod_security', $apache_mods) || in_array('mod_security2', $apache_mods) ? $enabled_good : $disabled_poor;
		
		if (!$mod_security && in_array('security2_module', $apache_mods)) $mod_security = $unknown_warn;
		
	} else {
		
		$mod_security = $unknown_warn;
		
	}
	
	return $mod_security;
	
}

function dashboard_widgets_suite_check_openbasedir() {
	
	$enabled_good  = '<span class="dws-color-good">'. __('Enabled', 'dws') .'</span>';
	$disabled_poor = '<span class="dws-color-poor">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('open_basedir') && trim(ini_get('open_basedir')) !== '' ? $enabled_good : $disabled_poor;
	
}

// php.ini : upload_tmp_dir = /tmp
function dashboard_widgets_suite_check_upload_tmp_dir() {
	
	$dir = ini_get('upload_tmp_dir') ? ini_get('upload_tmp_dir') : null;
	
	if (function_exists('sys_get_temp_dir')) {
		
		$dir = sys_get_temp_dir();
		
	} else {
		
		$vars = array('TMP', 'TMPDIR', 'TEMP');
		
		foreach ($vars as $var) {
			
			$tmp = getenv($var);
			
			if (!empty($tmp)) {
				
				$dir = realpath($tmp);
				
			}
			
		}
		
	}
	
	$result = $dir ? '<span class="dws-color-good">'. $dir .'</span>' : '<span class="dws-color-poor">n/a</span>';
	
	return $result;
	
}

// php.ini : expose_php = Off
function dashboard_widgets_suite_check_expose_php() {
	
	$enabled_poor  = '<span class="dws-color-poor">'. __('Enabled', 'dws') .'</span>';
	$disabled_good = '<span class="dws-color-good">'. __('Disabled', 'dws') .'</span>';
	
	return ini_get('expose_php') ? $enabled_poor : $disabled_good;
	
}



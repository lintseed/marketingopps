<?php // Dashboard Widgets Suite - Display Settings

if (!defined('ABSPATH')) exit;

function dashboard_widgets_suite_menu_pages() {
	
	// add_options_page( $page_title, $menu_title, $capability, $menu_slug, $function )
	add_options_page('Widgets Suite', 'Dashboard Widgets', 'manage_options', 'dashboard_widgets_suite', 'dashboard_widgets_suite_display_settings');
	
}

function dashboard_widgets_suite_get_tabs() {
	
	$tabs = array(
		'tab1' => __('General Settings', 'dws'), 
		'tab2' => __('User Notes',       'dws'), 
		'tab3' => __('Feed Box',         'dws'), 
		'tab4' => __('Social Box',       'dws'), 
		'tab5' => __('List Box',         'dws'), 
		'tab6' => __('Widget Box',       'dws'), 
		'tab7' => __('System Info',      'dws'), 
		'tab8' => __('Debug Log',        'dws'), 
		'tab9' => __('Error Log',        'dws'),
	);
	
	return $tabs;
	
}

function dashboard_widgets_suite_display_settings() { 
	
	$tab_active = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'tab1'; 
	
	$tab_href = admin_url('options-general.php?page=dashboard_widgets_suite');
	
	$tab_names = dashboard_widgets_suite_get_tabs();
	
	?>
	
	<div class="wrap wrap-<?php echo $tab_active; ?>">
		<h1><span class="fa fa-pad fa-th"></span> <?php echo DWS_NAME; ?> <span class="dws-version"><?php echo DWS_VERSION; ?></span></h1>
		<h2 class="nav-tab-wrapper">
			
			<?php 
				
				foreach ($tab_names as $key => $value) {
					
					$active = ($tab_active === $key) ? ' nav-tab-active' : '';
					
					echo '<a href="'. $tab_href .'&tab='. $key .'" class="nav-tab nav-'. $key . $active .'">'. $value .'</a>';
					
				}
				
			?>
			
		</h2>
		<form method="post" action="options.php">
			
			<?php
				
				if ($tab_active === 'tab1') {
					
					settings_fields('dws_options_general');
					do_settings_sections('dws_options_general');
				
				} elseif ($tab_active === 'tab2') {
					
					settings_fields('dws_options_notes_user');
					do_settings_sections('dws_options_notes_user');
					
				} elseif ($tab_active === 'tab3') {
					
					settings_fields('dws_options_feed_box');
					do_settings_sections('dws_options_feed_box');
					
				} elseif ($tab_active === 'tab4') {
					
					settings_fields('dws_options_social_box');
					do_settings_sections('dws_options_social_box');
					
				} elseif ($tab_active === 'tab5') {
					
					settings_fields('dws_options_list_box');
					do_settings_sections('dws_options_list_box');
					
				} elseif ($tab_active === 'tab6') {
					
					settings_fields('dws_options_widget_box');
					do_settings_sections('dws_options_widget_box');
					
				} elseif ($tab_active === 'tab7') {
					
					settings_fields('dws_options_system_info');
					do_settings_sections('dws_options_system_info');
					
				} elseif ($tab_active === 'tab8') {
					
					settings_fields('dws_options_log_debug');
					do_settings_sections('dws_options_log_debug');
					
				} elseif ($tab_active === 'tab9') {
					
					settings_fields('dws_options_log_error');
					do_settings_sections('dws_options_log_error');
				
				}
				
				submit_button();
				
			?>
			
		</form>
	</div>
	
<?php }

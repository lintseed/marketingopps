<?php // Dashboard Widgets Suite - Register Settings

if (!defined('ABSPATH')) exit;

function dashboard_widgets_suite_register_settings() {
	
	
	// register_setting( $option_group, $option_name, $sanitize_callback )
	register_setting('dws_options_general', 'dws_options_general', 'dashboard_widgets_suite_validate_general');
	
	// add_settings_section( $id, $title, $callback, $page )
	add_settings_section('settings_general', 'General Settings', 'dashboard_widgets_suite_section_general', 'dws_options_general');
	
	// add_settings_field( $id, $title, $callback, $page, $section, $args )
	add_settings_field('dashboard_columns',    'Dashboard Columns', 'dashboard_widgets_suite_callback_number',   'dws_options_general', 'settings_general', array('id' => 'dashboard_columns',    'section' => 'general', 'label' => __('Number of columns for the Dashboard (use 0 for WP defaults)', 'dws')));
	add_settings_field('widget_control_panel', 'Control Panel',     'dashboard_widgets_suite_callback_checkbox', 'dws_options_general', 'settings_general', array('id' => 'widget_control_panel', 'section' => 'general', 'label' => __('Enable the Control Panel Widget (lets you enable/disable widgets directly from the Dashboard)', 'dws')));
	add_settings_field('widget_control_view',  'View Role',         'dashboard_widgets_suite_callback_select',   'dws_options_general', 'settings_general', array('id' => 'widget_control_view',  'section' => 'general', 'label' => __('User role required to view the Control Panel', 'dws')));
	add_settings_field('null_reset_options',   'Reset Options',     'dashboard_widgets_suite_callback_reset',    'dws_options_general', 'settings_general', array('id' => 'null_reset_options',   'section' => 'general', 'label' => __('Restore default options', 'dws')));
	
	
	// user notes
	register_setting('dws_options_notes_user', 'dws_options_notes_user', 'dashboard_widgets_suite_validate_notes_user');
	
	add_settings_section('settings_notes_user', 'User Notes', 'dashboard_widgets_suite_section_notes_user', 'dws_options_notes_user');
	
	add_settings_field('widget_notes_user',       'Enable Widget',   'dashboard_widgets_suite_callback_checkbox', 'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_notes_user',       'section' => 'notes_user', 'label' => __('Enable the User Notes Widget', 'dws')));
	add_settings_field('widget_user_notes_front', 'Enable Frontend', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_user_notes_front', 'section' => 'notes_user', 'label' => __('Enable the User Notes on the frontend (via shortcode)', 'dws')));
	add_settings_field('widget_notes_count',      'Number of Notes', 'dashboard_widgets_suite_callback_number',   'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_notes_count',      'section' => 'notes_user', 'label' => __('Number of notes to display', 'dws')));
	add_settings_field('widget_notes_height',     'Note Height',     'dashboard_widgets_suite_callback_number',   'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_notes_height',     'section' => 'notes_user', 'label' => __('Height of each note in pixels (use 0 for auto-height)', 'dws')));
	add_settings_field('widget_notes_edit',       'Edit Role',       'dashboard_widgets_suite_callback_select',   'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_notes_edit',       'section' => 'notes_user', 'label' => __('User role required to add/edit/delete notes', 'dws')));
	add_settings_field('widget_notes_view',       'View Role',       'dashboard_widgets_suite_callback_select',   'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_notes_view',       'section' => 'notes_user', 'label' => __('Default role to view notes (can be overridden when adding new notes)', 'dws')));
	add_settings_field('widget_notes_message',    'Custom Message',  'dashboard_widgets_suite_callback_text',     'dws_options_notes_user', 'settings_notes_user', array('id' => 'widget_notes_message',    'section' => 'notes_user', 'label' => __('Custom message when there are no notes', 'dws')));
	add_settings_field('null_delete_notes',       'Delete Notes',    'dashboard_widgets_suite_callback_delete',   'dws_options_notes_user', 'settings_notes_user', array('id' => 'null_delete_notes',       'section' => 'notes_user', 'label' => __('Delete all User Notes', 'dws')));
	
	// feed box
	register_setting('dws_options_feed_box', 'dws_options_feed_box', 'dashboard_widgets_suite_validate_feed_box');
	
	add_settings_section('settings_feed_box', 'Feed Box', 'dashboard_widgets_suite_section_feed_box', 'dws_options_feed_box');
	
	add_settings_field('widget_feed_box',         'Enable Widget',   'dashboard_widgets_suite_callback_checkbox', 'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box',         'section' => 'feed_box', 'label' => __('Enable the Feed Box Widget', 'dws')));
	add_settings_field('widget_feed_box_front',   'Enable Frontend', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box_front',   'section' => 'feed_box', 'label' => __('Enable the Feed Box Widget on the frontend (via shortcode)', 'dws')));
	add_settings_field('widget_feed_box_excerpt', 'Feed Excerpt',    'dashboard_widgets_suite_callback_checkbox', 'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box_excerpt', 'section' => 'feed_box', 'label' => __('Include excerpts for each feed item', 'dws')));
	add_settings_field('widget_feed_box_length',  'Item Length',     'dashboard_widgets_suite_callback_number',   'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box_length',  'section' => 'feed_box', 'label' => __('Number of characters for each excerpt', 'dws')));
	add_settings_field('widget_feed_box_limit',   'Number of Items', 'dashboard_widgets_suite_callback_number',   'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box_limit',   'section' => 'feed_box', 'label' => __('Number of feed items to display', 'dws')));
	add_settings_field('widget_feed_box_view',    'View Role',       'dashboard_widgets_suite_callback_select',   'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box_view',    'section' => 'feed_box', 'label' => __('User role required to view the Feed Box', 'dws')));
	add_settings_field('widget_feed_box_feed',    'Feed URL',        'dashboard_widgets_suite_callback_text',     'dws_options_feed_box', 'settings_feed_box', array('id' => 'widget_feed_box_feed',    'section' => 'feed_box', 'label' => __('URL of the feed that you want to display', 'dws')));
	
	
	// social box
	register_setting('dws_options_social_box', 'dws_options_social_box', 'dashboard_widgets_suite_validate_social_box');
	
	add_settings_section('settings_social_box', 'Social Box', 'dashboard_widgets_suite_section_social_box', 'dws_options_social_box');
	
	add_settings_field('widget_social_box',        'Enable Widget',   'dashboard_widgets_suite_callback_checkbox', 'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box',        'section' => 'social_box', 'label' => __('Enable the Social Box Widget', 'dws')));
	add_settings_field('widget_social_box_front',  'Enable Frontend', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_front',  'section' => 'social_box', 'label' => __('Enable the Social Box on the frontend (via shortcode)', 'dws')));
	add_settings_field('widget_social_box_size',   'Icon Size',       'dashboard_widgets_suite_callback_number',   'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_size',   'section' => 'social_box', 'label' => __('Size of icon box (in pixels)', 'dws')));
	add_settings_field('widget_social_box_font',   'Font Size',       'dashboard_widgets_suite_callback_number',   'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_font',   'section' => 'social_box', 'label' => __('Size of icon (in pixels)', 'dws')));
	add_settings_field('widget_social_box_radius', 'Icon Radius',     'dashboard_widgets_suite_callback_number',   'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_radius', 'section' => 'social_box', 'label' => __('Radius of icons (in pixels)', 'dws')));
	add_settings_field('widget_social_box_space',  'Icon Spacing',    'dashboard_widgets_suite_callback_number',   'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_space',  'section' => 'social_box', 'label' => __('Space between icons (in pixels)', 'dws')));
	add_settings_field('widget_social_box_view',   'View Role',       'dashboard_widgets_suite_callback_select',   'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_view',   'section' => 'social_box', 'label' => __('User role required to view the Social Box', 'dws')));
	add_settings_field('widget_social_box_twit1',  'Twitter',         'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_twit1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_face1',  'Facebook',        'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_face1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_goog1',  'Google+',         'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_goog1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_pint1',  'Pinterest',       'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_pint1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_lnkd1',  'LinkedIn',        'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_lnkd1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_feed1',  'RSS Feed',        'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_feed1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_skyp1',  'Skype',           'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_skyp1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_yout1',  'YouTube',         'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_yout1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_vime1',  'Vimeo',           'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_vime1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_inst1',  'Instagram',       'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_inst1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_word1',  'WordPress',       'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_word1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_tumb1',  'Tumblr',          'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_tumb1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_four1',  'Foursquare',      'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_four1',  'section' => 'social_box', 'label' => __('', 'dws')));
	add_settings_field('widget_social_box_eml1',   'Email',           'dashboard_widgets_suite_callback_text',     'dws_options_social_box', 'settings_social_box', array('id' => 'widget_social_box_eml1',   'section' => 'social_box', 'label' => __('', 'dws')));
	
	
	// list box
	register_setting('dws_options_list_box', 'dws_options_list_box', 'dashboard_widgets_suite_validate_list_box');
	
	add_settings_section('settings_list_box', 'List Box', 'dashboard_widgets_suite_section_list_box', 'dws_options_list_box');
	
	add_settings_field('widget_list_box',      'Enable Widget', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_list_box', 'settings_list_box', array('id' => 'widget_list_box',      'section' => 'list_box', 'label' => __('Enable the List Box Widget', 'dws')));
	add_settings_field('widget_list_box_view', 'View Role',     'dashboard_widgets_suite_callback_select',   'dws_options_list_box', 'settings_list_box', array('id' => 'widget_list_box_view', 'section' => 'list_box', 'label' => __('User role required to view the List Box', 'dws')));
	add_settings_field('widget_list_box_menu', 'Menu/List',     'dashboard_widgets_suite_callback_select',   'dws_options_list_box', 'settings_list_box', array('id' => 'widget_list_box_menu', 'section' => 'list_box', 'label' => __('Menu (List) to display in the List Box Widget', 'dws')));
	
	// widget box
	register_setting('dws_options_widget_box', 'dws_options_widget_box', 'dashboard_widgets_suite_validate_widget_box');
	
	add_settings_section('settings_widget_box', 'Widget Box', 'dashboard_widgets_suite_section_widget_box', 'dws_options_widget_box');
	
	add_settings_field('widget_widget_box',         'Enable Widget', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_widget_box', 'settings_widget_box', array('id' => 'widget_widget_box',         'section' => 'widget_box', 'label' => __('Enable the Widget Box', 'dws')));
	add_settings_field('widget_widget_box_view',    'View Role',     'dashboard_widgets_suite_callback_select',   'dws_options_widget_box', 'settings_widget_box', array('id' => 'widget_widget_box_view',    'section' => 'widget_box', 'label' => __('User role required to view the Widget Box', 'dws')));
	add_settings_field('widget_widget_box_sidebar', 'Sidebar',       'dashboard_widgets_suite_callback_select',   'dws_options_widget_box', 'settings_widget_box', array('id' => 'widget_widget_box_sidebar', 'section' => 'widget_box', 'label' => __('Sidebar (Widget Area) to display in Widget Box', 'dws')));
	
	
	// system info
	register_setting('dws_options_system_info', 'dws_options_system_info', 'dashboard_widgets_suite_validate_system_info');
	
	add_settings_section('settings_system_info', 'System Info', 'dashboard_widgets_suite_section_system_info', 'dws_options_system_info');
	
	add_settings_field('widget_system_info',      'Enable Widget', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_system_info', 'settings_system_info', array('id' => 'widget_system_info',      'section' => 'system_info', 'label' => __('Enable the System Info Widget', 'dws')));
	add_settings_field('widget_system_info_adv',  'Advanced Info', 'dashboard_widgets_suite_callback_checkbox', 'dws_options_system_info', 'settings_system_info', array('id' => 'widget_system_info_adv',  'section' => 'system_info', 'label' => __('Display advanced server information', 'dws')));
	add_settings_field('widget_system_info_view', 'View Role',     'dashboard_widgets_suite_callback_select',   'dws_options_system_info', 'settings_system_info', array('id' => 'widget_system_info_view', 'section' => 'system_info', 'label' => __('User role required to view System Info', 'dws')));
	
	
	// debug log
	register_setting('dws_options_log_debug', 'dws_options_log_debug', 'dashboard_widgets_suite_validate_log_debug');
	
	add_settings_section('settings_log_debug', 'Debug Log Widget', 'dashboard_widgets_suite_section_log_debug', 'dws_options_log_debug');
	
	add_settings_field('widget_log_debug',        'Enable Widget',  'dashboard_widgets_suite_callback_checkbox', 'dws_options_log_debug', 'settings_log_debug', array('id' => 'widget_log_debug',        'section' => 'log_debug', 'label' => __('Enable the WP Debug Log Widget', 'dws')));
	add_settings_field('widget_log_debug_limit',  'Max Errors',     'dashboard_widgets_suite_callback_number',   'dws_options_log_debug', 'settings_log_debug', array('id' => 'widget_log_debug_limit',  'section' => 'log_debug', 'label' => __('Max number of errors to display', 'dws')));
	add_settings_field('widget_log_debug_length', 'Max Characters', 'dashboard_widgets_suite_callback_number',   'dws_options_log_debug', 'settings_log_debug', array('id' => 'widget_log_debug_length', 'section' => 'log_debug', 'label' => __('Max number of characters for each error', 'dws')));
	add_settings_field('widget_log_debug_height', 'Log Height',     'dashboard_widgets_suite_callback_number',   'dws_options_log_debug', 'settings_log_debug', array('id' => 'widget_log_debug_height', 'section' => 'log_debug', 'label' => __('Height of log display (in pixels)', 'dws')));
	add_settings_field('widget_log_debug_view',   'View Role',      'dashboard_widgets_suite_callback_select',   'dws_options_log_debug', 'settings_log_debug', array('id' => 'widget_log_debug_view',   'section' => 'log_debug', 'label' => __('User role required to view the Debug Log', 'dws')));
	
	
	// error log
	register_setting('dws_options_log_error', 'dws_options_log_error', 'dashboard_widgets_suite_validate_log_error');
	
	add_settings_section('settings_log_error', 'Error Log Widget', 'dashboard_widgets_suite_section_log_error', 'dws_options_log_error');
	
	add_settings_field('widget_log_error',        'Enable Widget',  'dashboard_widgets_suite_callback_checkbox', 'dws_options_log_error', 'settings_log_error', array('id' => 'widget_log_error',        'section' => 'log_error', 'label' => __('Enable the Error Log Widget', 'dws')));
	add_settings_field('widget_log_error_limit',  'Max Errors',     'dashboard_widgets_suite_callback_number',   'dws_options_log_error', 'settings_log_error', array('id' => 'widget_log_error_limit',  'section' => 'log_error', 'label' => __('Max number of errors to display', 'dws')));
	add_settings_field('widget_log_error_length', 'Max Characters', 'dashboard_widgets_suite_callback_number',   'dws_options_log_error', 'settings_log_error', array('id' => 'widget_log_error_length', 'section' => 'log_error', 'label' => __('Max number of characters for each error', 'dws')));
	add_settings_field('widget_log_error_height', 'Log Height',     'dashboard_widgets_suite_callback_number',   'dws_options_log_error', 'settings_log_error', array('id' => 'widget_log_error_height', 'section' => 'log_error', 'label' => __('Height of log display (in pixels)', 'dws')));
	add_settings_field('widget_log_error_view',   'View Role',      'dashboard_widgets_suite_callback_select',   'dws_options_log_error', 'settings_log_error', array('id' => 'widget_log_error_view',   'section' => 'log_error', 'label' => __('User role required to view the Error Log', 'dws')));
	add_settings_field('widget_log_error_path',   'Log Location',   'dashboard_widgets_suite_callback_text',     'dws_options_log_error', 'settings_log_error', array('id' => 'widget_log_error_path',   'section' => 'log_error', 'label' => __('Enter the absolute path to your error log (ask host if unsure)', 'dws')));
	
	
	// 
	
}



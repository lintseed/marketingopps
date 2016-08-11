<?php // Dashboard Widgets Suite - Social Box

if (!defined('ABSPATH')) exit;

function dashboard_widgets_suite_social_box() {
	
	$items = dashboard_widgets_suite_social_box_content();
	
	echo $items;
	
	do_action('dashboard_widgets_suite_social_box', $items);
	
}

function dashboard_widgets_suite_social_box_content() {
	
	global $dws_options_social_box;
	
	$items = array(
		
		'widget_social_box_twit1' => 'soc-twitter', 
		'widget_social_box_face1' => 'soc-facebook', 
		'widget_social_box_goog1' => 'soc-google', 
		'widget_social_box_pint1' => 'soc-pinterest', 
		'widget_social_box_lnkd1' => 'soc-linkedin', 
		'widget_social_box_feed1' => 'soc-rss', 
		'widget_social_box_skyp1' => 'soc-skype', 
		'widget_social_box_yout1' => 'soc-youtube', 
		'widget_social_box_vime1' => 'soc-vimeo', 
		'widget_social_box_inst1' => 'soc-instagram', 
		'widget_social_box_word1' => 'soc-wordpress', 
		'widget_social_box_tumb1' => 'soc-tumblr', 
		'widget_social_box_four1' => 'soc-foursquare', 
		'widget_social_box_eml1'  => 'soc-email1', 
		
	);
	
	$return  = '<div id="dws-social-box">';
	$return .= '<ul>';
	
	foreach ($items as $key => $value) {
		
		if (isset($key) && isset($value)) {
			
			$href  = isset($dws_options_social_box[$key]) ? $dws_options_social_box[$key] : '';
			$class = isset($value) ? $value : '';
			
			if (!empty($href) && !empty($class)) {
				
				$target = ($value === 'soc-email1') ? '' : 'target="_blank"';
				
				$return .= '<li><a '. $target .' class="'. $class .'" href="'. $href .'"></a></li>';
				
			}
			
		}
		
	}
	
	$return .= '</ul>';
	$return .= '</div>';
	
	apply_filters('dashboard_widgets_suite_social_box_output', $return);
	
	return $return;
	
}

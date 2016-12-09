<?php
// Remove Posts & Pages from Dashboard as to not confuse the Authors
function remove_menus(){
  remove_menu_page( 'edit.php' );                   //Posts
	remove_menu_page( 'edit.php?post_type=page' );    //Pages
  remove_menu_page( 'edit-comments.php' );          //Comments
	// remove_menu_page( 'themes.php' );                 //Appearance
}
add_action( 'admin_menu', 'remove_menus' );

remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

//Remove dashboard widgets
function remove_dashboard_meta() {
  $user = wp_get_current_user();
  if (!$user -> has_cap ('manage_options'))
  remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
  remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
  remove_meta_box( 'dashboard_activity', 'dashboard', 'normal');
  remove_meta_box( 'cjt-statistics', 'dashboard', 'normal');
}
add_action( 'admin_init', 'remove_dashboard_meta' );
//add_action( 'add_meta_boxes', 'change_cat_meta_box', 0 );
//add_action( 'admin_menu', 'change_post_menu_label' );


// Update CSS within in Admin
function add_admin_styles() {
  wp_enqueue_style('admin-styles', get_template_directory_uri().'/css/admin.css');
}
add_action('admin_enqueue_scripts', 'add_admin_styles');
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

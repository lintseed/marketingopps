<?php
/**
 * Display category archive page for custom post types
 */
function themeprefix_show_cpt_archives( $query ) {
	if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {
		$query->set( 'post_type', array(
			'post', 'nav_menu_item', 'opportunity'
		));
		return $query;
	}
}
add_filter( 'pre_get_posts', 'themeprefix_show_cpt_archives' );

/**
 * Display all dem for now
 */
function set_posts_per_page_for_opportunity_cpt( $query ) {
  if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'opportunity' ) || is_category() ) {
    $query->set( 'posts_per_page', '3000' );
  }
}
add_action( 'pre_get_posts', 'set_posts_per_page_for_opportunity_cpt' );

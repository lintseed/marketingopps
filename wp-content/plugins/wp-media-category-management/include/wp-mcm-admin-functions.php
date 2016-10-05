<?php
/**
 * The WordPress Media Category Management Plugin.
 *
 * @package   WP_MediaCategoryManagement\AdminFunctions
 * @author    De B.A.A.T. <wp-mcm@de-baat.nl>
 * @license   GPL-3.0+
 * @link      https://www.de-baat.nl/WP_MCM
 * @copyright 2014 - 2016 De B.A.A.T.
 */


/** Add a category filter */
function mcm_add_category_filter( $media_taxonomy = '') {

	// Validate input
	if ($media_taxonomy == '') {
		return;
	}

	global $pagenow;
	if ( 'upload.php' == $pagenow ) {

		// Set options depending on type of taxonomy chosen
		switch ($media_taxonomy) {
			case WP_MCM_POST_TAXONOMY:
				$selected_value = isset( $_GET['cat'] ) ? $_GET['cat'] : '';
				break;
			default:
				$selected_value = isset( $_GET[$media_taxonomy] ) ? $_GET[$media_taxonomy] : '';
				break;
		}

		echo "<label for='{$media_taxonomy}' class='screen-reader-text'>" . __('Filter by', 'wp-media-category-management') . " {$media_taxonomy}</label>";

		$dropdown_options = mcm_get_media_category_options($media_taxonomy, $selected_value);
		wp_dropdown_categories( $dropdown_options );
	}
}

/** Add a filter for restrict_manage_posts to add a filter for categories and process the toggle actions */
function mcm_restrict_manage_posts() {


	// Get media taxonomy
	$media_taxonomy = mcm_get_media_taxonomy();
	mcm_debugMP('pr',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy);

	// Add a filter for the WP_MCM_POST_TAXONOMY
	if (($media_taxonomy != WP_MCM_POST_TAXONOMY) && (mcm_get_option_bool('wp_mcm_use_post_taxonomy'))) {
		mcm_add_category_filter( WP_MCM_POST_TAXONOMY );
	}

	// Add a filter for the selected category
	mcm_add_category_filter( $media_taxonomy );

}
add_action( 'restrict_manage_posts', 'mcm_restrict_manage_posts' );


/** Custom update_count_callback */
function mcm_update_count_callback( $terms = array(), $media_taxonomy = 'category' ) {
	global $wpdb;

	// Get media taxonomy
	$media_taxonomy = mcm_get_media_taxonomy();
	mcm_debugMP('msg',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy);

	// select id & count from taxonomy
	$query = "SELECT term_taxonomy_id, MAX(total) AS total FROM ((
	SELECT tt.term_taxonomy_id, COUNT(*) AS total FROM $wpdb->term_relationships tr, $wpdb->term_taxonomy tt WHERE tr.term_taxonomy_id = tt.term_taxonomy_id AND tt.taxonomy = %s GROUP BY tt.term_taxonomy_id
	) UNION ALL (
	SELECT term_taxonomy_id, 0 AS total FROM $wpdb->term_taxonomy WHERE taxonomy = %s
	)) AS unioncount GROUP BY term_taxonomy_id";
	$rsCount = $wpdb->get_results( $wpdb->prepare( $query, $media_taxonomy, $media_taxonomy ) );
	mcm_debugMP('msg',__FUNCTION__ . ' query = ' . $query);
	mcm_debugMP('pr',__FUNCTION__ . ' rsCount = ', $rsCount);

	// update all count values from taxonomy
	foreach ( $rsCount as $rowCount ) {
		$wpdb->update( $wpdb->term_taxonomy, array( 'count' => $rowCount->total ), array( 'term_taxonomy_id' => $rowCount->term_taxonomy_id ) );
	}
}

function mcm_create_sendback_url() {

	// Create a sendback url to report the results
	$sendback = remove_query_arg( array('exported', 'untrashed', 'deleted', 'ids'), wp_get_referer() );
	if ( ! $sendback || false === strpos(wp_get_referer(), 'upload.php') ) {
		$sendback = admin_url( "upload.php" );
	}

	// Remove some superfluous arguments
	$sendback = remove_query_arg( array('action', 'action2', 'tags_input', 'post_author', 'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );

	// remember pagenumber
	$pagenum = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0;
	$sendback = add_query_arg( 'paged', $pagenum, $sendback );

	// remember orderby
	if ( isset( $_REQUEST['orderby'] ) ) {
		$sOrderby = $_REQUEST['orderby'];
		$sendback = add_query_arg( 'orderby', $sOrderby, $sendback );
	}
	// remember order
	if ( isset( $_REQUEST['order'] ) ) {
		$sOrder = $_REQUEST['order'];
		$sendback = add_query_arg( 'order', $sOrder, $sendback );
	}

	// remember filter settings
	if ( isset( $_REQUEST['mode'] ) ) {
		$sMode = $_REQUEST['mode'];
		$sendback = add_query_arg( 'mode', $sMode, $sendback );
	}
	if ( isset( $_REQUEST['mode'] ) ) {
		$sMode = $_REQUEST['mode'];
		$sendback = add_query_arg( 'mode', $sMode, $sendback );
	}
	if ( isset( $_REQUEST['m'] ) ) {
		$sM = $_REQUEST['m'];
		$sendback = add_query_arg( 'm', $sM, $sendback );
	}
	if ( isset( $_REQUEST['s'] ) ) {
		$sS = $_REQUEST['s'];
		$sendback = add_query_arg( 's', $sS, $sendback );
	}
	if ( isset( $_REQUEST['attachment-filter'] ) ) {
		$sAttachmentFilter = $_REQUEST['attachment-filter'];
		$sendback = add_query_arg( 'attachment-filter', $sAttachmentFilter, $sendback );
	}
	if ( isset( $_REQUEST['filter_action'] ) ) {
		$sFilterAction = $_REQUEST['filter_action'];
		$sendback = add_query_arg( 'filter_action', $sFilterAction, $sendback );
	}

	// Get media taxonomy
	$media_taxonomy = mcm_get_media_taxonomy();
	if ( isset( $_REQUEST[$media_taxonomy] ) ) {
		$sMediaTaxonomy = $_REQUEST[$media_taxonomy];
		$sendback = add_query_arg( $media_taxonomy, $sMediaTaxonomy, $sendback );
	}


	return $sendback;

}


/**
 *  mcm_get_terms_values
 *
 *  Get an array of term values, which type is determined by the parameter
 *
 *  @since    1.4.0
 *  @created  13/12/14
 */
function mcm_get_terms_values( $keys = 'ids') { 

		// Get media taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
		mcm_debugMP('msg',__FUNCTION__ . ' media_taxonomy = ' . $media_taxonomy);

		$media_terms = get_terms($media_taxonomy, array(
			'hide_empty'       => 0,
			'fields'           => 'id=>slug',
			));
		mcm_debugMP('pr', __FUNCTION__ . ' media_terms for :' . $media_taxonomy, $media_terms);

		$media_values = array();
		foreach ($media_terms as $key => $value) {
			if ($keys == 'ids') {
				$media_values[] = $key;
			} else {
				$media_values[] = $value;
			}
		}
		return $media_values;

}

/**
 *  mcm_media_row_actions
 *
 *  Add the filter to supply bulk actions
 *
 *  @since    0.1.0
 *  @created  24/01/14
 */
function mcm_media_row_actions($row_actions, $media, $detached) { 

	// Check whether the toggle_assign is desired
	if (mcm_get_option_bool('wp_mcm_toggle_assign') ) {

		// Get media taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
//		mcm_debugMP('msg',__FUNCTION__ . ' media_taxonomy = ' . $media_taxonomy);

		$media_terms = get_terms($media_taxonomy, array('hide_empty' => 0));
//		mcm_debugMP('pr', __FUNCTION__ . ' media_terms for :' . $media->ID, $media_terms);

		$actionlink_url    = mcm_create_sendback_url();
		$actionlink_url    = add_query_arg( 'media', $media->ID, $actionlink_url );
		$actionlink_url    = add_query_arg( 'action', WP_MCM_ACTION_BULK_TOGGLE, $actionlink_url );
		$actionlink_prefix = __( 'Toggle', 'wp-media-category-management' ) . ' ';

		// Generate an action text and link for each term
		foreach ($media_terms as $term) {
			// Finish creating the action link for each media_term
			$actionlink  = add_query_arg( 'bulk_tax_cat', $media_taxonomy, $actionlink_url );
			$actionlink  = add_query_arg( 'bulk_tax_id', $term->slug, $actionlink );
			// Create a clickable label for the generated url
			$actionlink  = '<a class="submitdelete" href="' . wp_nonce_url( $actionlink );
			$actionlink .= '">' . $actionlink_prefix;
			$actionlink_prefix = ' ';
			$actionlink .= '[<em>' . $term->name . '</em>]';
			$actionlink .= '</a>';
			$row_actions[] = $actionlink;
		}
	}
	return $row_actions;
}

add_filter('media_row_actions','mcm_media_row_actions', 10, 3);

/**
 * Check the current action selected from the bulk actions dropdown.
 *
 * @since 3.1.0
 *
 * @return bool Whether WP_MCM_ACTION_BULK_TOGGLE was selected or not
 */
function mcm_is_action_bulk_toggle() {

	if ( isset( $_REQUEST['action'] ) && WP_MCM_ACTION_BULK_TOGGLE == $_REQUEST['action'] ) {
		return true;
	}

	if ( isset( $_REQUEST['action2'] ) && WP_MCM_ACTION_BULK_TOGGLE == $_REQUEST['action2'] ) {
		return true;
	}

	return false;
}

/*
 * This work is based on the plugin FoxRunSoftware Custom Bulk Action Demo
 * Plugin URI: https://www.foxrunsoftware.net/articles/wordpress/add-custom-bulk-action/
 * Description: A working demonstration of a custom bulk action
 * Author: Justin Stern
 * Author URI: https://www.foxrunsoftware.net
 * Version: 0.1

 * 	Copyright: © 2012 Justin Stern (email : justin@foxrunsoftware.net)
 * 	License: GNU General Public License v3.0
 * 	License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

add_action( 'admin_footer-upload.php',	'mcm_custom_bulk_admin_footer');
add_action( 'load-upload.php',			'mcm_custom_bulk_action');
add_action( 'admin_notices',			'mcm_custom_bulk_admin_notices');

/**
 * Step 1: add the custom Bulk Action to the select menus
 * For Media Category Management, the actual category should be used as parameter
 */
function mcm_custom_bulk_admin_footer() {
	global $post_type;

	// Make an array of post_type
	if (is_array($post_type)) {
		$mcm_post_type = $post_type;
	} else {
		$mcm_post_type = array();
		$mcm_post_type[] = $post_type;
	}

	// Check whether the post_type array contains attachment
	if ( in_array('attachment',$mcm_post_type) ) {

		// Get media taxonomy and corresponding terms
		$media_taxonomy = mcm_get_media_taxonomy();
		$media_terms = get_terms( $media_taxonomy, 'hide_empty=0' );

		// If terms found ok then generate the additional bulk_actions
		if ( $media_terms && ! is_wp_error( $media_terms ) ) {

			// Create the box div string.
			//
			$onChangeTxtTop    = "jQuery(\'#bulk_tax_id\').val(jQuery(\'#bulk-action-selector-top option:selected\').attr(\'option_slug\'));";
			$onChangeTxtBottom = "jQuery(\'#bulk_tax_id\').val(jQuery(\'#bulk-action-selector-bottom option:selected\').attr(\'option_slug\'));";

			// Start the script to add bulk code
			$mcm_footer_script  = "";
			$mcm_footer_script .= " <script type=\"text/javascript\">";
			$mcm_footer_script .= "jQuery(document).ready(function(){";

			// Add new hidden field to store the term_slug
			$mcm_footer_script .=	"jQuery('#posts-filter').prepend('<input type=\"hidden\" id=\"bulk_tax_cat\" name=\"bulk_tax_cat\" value=\"" . $media_taxonomy . "\" />');";
			$mcm_footer_script .=	"jQuery('#posts-filter').prepend('<input type=\"hidden\" id=\"bulk_tax_id\" name=\"bulk_tax_id\" value=\"\" />');";

			// Add new action to #bulk-action-selector-top
			$mcm_footer_script .=	"jQuery('#bulk-action-selector-top')";
			$mcm_footer_script .=	".attr('onChange','" . $onChangeTxtTop . "')";
//				$mcm_footer_script .=	".attr('onClick','" . $onChangeTxt . "')";
			$mcm_footer_script .=	";";

			// Add new action to #bulk-action-selector-bottom
			$mcm_footer_script .=	"jQuery('#bulk-action-selector-bottom')";
			$mcm_footer_script .=	".attr('onChange','" . $onChangeTxtBottom . "')";
//				$mcm_footer_script .=	".attr('onClick','" . $onChangeTxt . "')";
			$mcm_footer_script .=	";";

			// add bulk_actions for each category term
			foreach ( $media_terms as $term ) {
				$optionTxt = esc_js( __( 'Toggle', 'wp-media-category-management' ) . ' ' . $term->name );
				$mcm_footer_script .= " jQuery('<option>').val('" . WP_MCM_ACTION_BULK_TOGGLE . "').attr('option_slug','" . $term->slug . "').text('" . $optionTxt . "').appendTo(\"select[name='action']\");";
				$mcm_footer_script .= " jQuery('<option>').val('" . WP_MCM_ACTION_BULK_TOGGLE . "').attr('option_slug','" . $term->slug . "').text('" . $optionTxt . "').appendTo(\"select[name='action2']\");";
			}
			$mcm_footer_script .= '});';
			$mcm_footer_script .= '</script>';

			echo $mcm_footer_script;
		}
	}
}

/**
 * Step 2: handle the custom Bulk Action
 * 
 * Based on the post https://wordpress.stackexchange.com/questions/29822/custom-bulk-action
 */
function mcm_custom_bulk_action() {

	// Check parameters provided
	if (!isset( $_REQUEST['bulk_tax_cat'] ))	{ return; }
	if (!isset( $_REQUEST['bulk_tax_id'] ))		{ return; }
	if (!isset( $_REQUEST['media'] ))			{ return; }
	if (!mcm_is_action_bulk_toggle() )			{ return; }

	// Set some variables
	$num_bulk_toggled = 0;
	$media_taxonomy = $_REQUEST['bulk_tax_cat'];
	$bulk_media_category_id = $_REQUEST['bulk_tax_id'];

	// Process all media_id s found in the request
	foreach ( (array) $_REQUEST['media'] as $media_id ) {
		$media_id = (int) $media_id;

		// Check whether this user can edit this post
		if ( !current_user_can( 'edit_post', $media_id ) ) continue;


		// Check whether this post has the media_category already set or not
		if (has_term($bulk_media_category_id, $media_taxonomy, $media_id)) {

			// Set so remove the $bulk_media_category taxonomy from this media post
			$bulk_result = wp_remove_object_terms($media_id, $bulk_media_category_id, $media_taxonomy);

		} else {

			// Not set so add the $bulk_media_category taxonomy to this media post
			$bulk_result = wp_set_object_terms($media_id, $bulk_media_category_id, $media_taxonomy, true);
		}
		if ( is_wp_error( $bulk_result ) ) {
			return $bulk_result;
		}

		// Keep track of the number toggled
		$num_bulk_toggled++;

	}

	// Create a sendback url to refresh the screen and report the results
	$sendback = mcm_create_sendback_url();
	$sendback = add_query_arg( array('bulk_toggled' => $num_bulk_toggled), $sendback );
	wp_redirect( $sendback );
	exit();

}


/**
 * Step 3: display an admin notice on the Posts page after exporting
 */
function mcm_custom_bulk_admin_notices() {
	global $pagenow;

	if($pagenow == 'upload.php' && isset($_REQUEST['bulk_toggled']) && (int) $_REQUEST['bulk_toggled']) {
		$message = sprintf( _n( 'Media bulk toggled.', '%s media bulk toggled.', $_REQUEST['bulk_toggled'], 'wp-media-category-management' ), number_format_i18n( $_REQUEST['bulk_toggled'] ) );
		echo "<div class=\"updated\"><p>{$message}</p></div>";
	}
}

/** Handle default category of attachments without category */
function mcm_set_attachment_category( $post_ID ) {

	// Check whether this user can edit this post
	if ( !current_user_can( 'edit_post', $post_ID ) ) {
		return;
	}

	// Check whether to use the default or not
	if ( ! mcm_get_option_bool( 'wp_mcm_use_default_category' )) {
		return;
	}

	// Check $media_taxonomy
	$media_taxonomy = mcm_get_media_taxonomy();

	// Only add default if attachment doesn't have WP_MCM_MEDIA_TAXONOMY categories
	if ( ! wp_get_object_terms( $post_ID, $media_taxonomy ) ) {

		// Get the default value
		$default_category = mcm_get_option('wp_mcm_default_media_category');

		// Check for valid $default_category
		if ($default_category != WP_MCM_OPTION_NONE) {

			// Not set so add the $media_category taxonomy to this media post
			$add_result = wp_set_object_terms($post_ID, $default_category, $media_taxonomy, true);

			// Check for error
			if ( is_wp_error( $add_result ) ) {
				return $add_result;
			}
		}

	}

//	// Check WP_MCM_POST_TAXONOMY
//	// Only add default if attachment doesn't have WP_MCM_POST_TAXONOMY categories
//	if ( ! wp_get_object_terms( $post_ID, WP_MCM_POST_TAXONOMY ) ) {
//
//		// Get the default value
//		$default_category = mcm_get_option('wp_mcm_default_post_category');
//
//		// Check for valid $default_category
//		if ($default_category != '') {
//
//			// Not set so add the $media_category taxonomy to this media post
//			$add_result = wp_set_object_terms($post_ID, $default_category, WP_MCM_POST_TAXONOMY, true);
//
//			// Check for error
//			if ( is_wp_error( $add_result ) ) {
//				return $add_result;
//			}
//		}
//
//	}

}
add_action( 'add_attachment',  'mcm_set_attachment_category' );
add_action( 'edit_attachment', 'mcm_set_attachment_category' );

/** Changing categories in the 'grid view' */
function mcm_ajax_query_attachments() {

	if ( ! current_user_can( 'upload_files' ) ) {
		wp_send_json_error();
	}

	$taxonomies = get_object_taxonomies( 'attachment', 'names' );

	$query = isset( $_REQUEST['query'] ) ? (array) $_REQUEST['query'] : array();

	$defaults = array(
		's', 'order', 'orderby', 'posts_per_page', 'paged', 'post_mime_type',
		'post_parent', 'post__in', 'post__not_in'
	);
	$query = array_intersect_key( $query, array_flip( array_merge( $defaults, $taxonomies ) ) );

	$query['post_type'] = 'attachment';
	$query['post_status'] = 'inherit';
	if ( current_user_can( get_post_type_object( 'attachment' )->cap->read_private_posts ) ) {
		$query['post_status'] .= ',private';
	}

	$query['tax_query'] = array( 'relation' => 'AND' );

	foreach ( $taxonomies as $taxonomy ) {
		if ( isset( $query[$taxonomy] ) ) {
			// Filter a specific category
			if ( is_numeric( $query[$taxonomy] ) ) {
				array_push( $query['tax_query'], array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $query[$taxonomy]
				));	
			}
			// Filter No category
			if ( $query[$taxonomy] == WP_MCM_OPTION_NO_CAT ) {
				$all_terms_ids = mcm_get_terms_values('ids');
				array_push( $query['tax_query'], array(
					'taxonomy' => $taxonomy,
					'field'    => 'id',
					'terms'    => $all_terms_ids,
					'operator' => 'NOT IN',
				));	
			}
		}
		unset ( $query[$taxonomy] );
	}

	$query = apply_filters( 'ajax_query_attachments_args', $query );
	$query = new WP_Query( $query );

	$posts = array_map( 'wp_prepare_attachment_for_js', $query->posts );
	$posts = array_filter( $posts );

	wp_send_json_success( $posts );
}
add_action( 'wp_ajax_query-attachments', 'mcm_ajax_query_attachments', 0 );

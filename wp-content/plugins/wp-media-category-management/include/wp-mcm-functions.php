<?php
/**
 * The WordPress Media Category Management Plugin.
 *
 * @package   WP_MediaCategoryManagement\Functions
 * @author    De B.A.A.T. <wp-mcm@de-baat.nl>
 * @license   GPL-3.0+
 * @link      https://www.de-baat.nl/WP_MCM
 * @copyright 2014 - 2016 De B.A.A.T.
 */


function mcm_init_option_defaults() {
	$wp_mcm_options = get_option(WP_MCM_OPTIONS_NAME);

	// Only set defaults when the options are not set yet
	if ( mcm_get_option('wp_mcm_version') === false ) {
		$wp_mcm_options['wp_mcm_toggle_assign']					= '1';
		$wp_mcm_options['wp_mcm_media_taxonomy_to_use']			= WP_MCM_MEDIA_TAXONOMY;
		$wp_mcm_options['wp_mcm_custom_taxonomy_name']			= '';
		$wp_mcm_options['wp_mcm_custom_taxonomy_name_single']	= '';
		$wp_mcm_options['wp_mcm_use_post_taxonomy']				= '';
		$wp_mcm_options['wp_mcm_search_media_library']			= '';
		$wp_mcm_options['wp_mcm_use_default_category']			= '';
		$wp_mcm_options['wp_mcm_default_media_category']		= WP_MCM_OPTION_NONE;
		$wp_mcm_options['wp_mcm_default_post_category']			= '';
	} else {
		// Compare previous version to migrate the options
		$version_on_start = mcm_get_option('wp_mcm_version');
		if ( version_compare($version_on_start,'1.2','<') ) {
			// Check whether POST or MEDIA taxonomy was used before
			if (mcm_get_option_bool('wp_mcm_use_post_taxonomy')) {
				$wp_mcm_options['wp_mcm_media_taxonomy_to_use']		= WP_MCM_POST_TAXONOMY;
				$wp_mcm_options['wp_mcm_default_media_category']	= $wp_mcm_options['wp_mcm_default_post_category'];
			} else {
				$wp_mcm_options['wp_mcm_media_taxonomy_to_use']		= WP_MCM_MEDIA_TAXONOMY;
			}
			$wp_mcm_options['wp_mcm_custom_taxonomy_name']		= '';
		}
		if ( version_compare($version_on_start,'1.3','<') ) {
			$wp_mcm_options['wp_mcm_custom_taxonomy_name_single']	= '';
		}
		if ( version_compare($version_on_start,'1.6','<') ) {
			$wp_mcm_options['wp_mcm_search_media_library']	= '';
		}
	}

	// Always set the current version
	$wp_mcm_options['wp_mcm_version'] = WP_MCM_VERSION;

	return update_option(WP_MCM_OPTIONS_NAME, $wp_mcm_options);
}

function mcm_get_option($option_key = '') {
	$wp_mcm_options = get_option(WP_MCM_OPTIONS_NAME);
	return isset( $wp_mcm_options[$option_key] ) ? $wp_mcm_options[$option_key] : false;
}

function mcm_update_option($option_key = '', $option_value = '') {
	$wp_mcm_options = get_option(WP_MCM_OPTIONS_NAME);
	if ( isset( $wp_mcm_options[$option_key] ) ) {
		$wp_mcm_options[$option_key] = $option_value;
	}
	return update_option(WP_MCM_OPTIONS_NAME, $wp_mcm_options);
}

function mcm_get_option_bool($option_key = '') {
	$wp_mcm_options = get_option(WP_MCM_OPTIONS_NAME);
	if ( isset( $wp_mcm_options[$option_key] ) ) {
		return ( mcm_string_to_bool( $wp_mcm_options[$option_key] ) );
	} else {
		return false;
	}
}

function mcm_string_to_bool($value) {
	if ($value === true || $value === 'true' || $value === 'TRUE' || $value === '1') {
		return true;
	}
	else if ($value === false || $value === 'false' || $value === 'FALSE' || $value === '0') {
		return false;
	}
	else {
		return $value;
	}
}

// Add values to query vars to extend the query
function mcm_query_vars_add_values( $query_vars = '', $values_to_add = '' ) {

	// Make input into array
	$new_query_vars    = $query_vars;
	$new_values_to_add = $values_to_add;
	if (!is_array($query_vars))    { $new_query_vars    = array($query_vars); }
	if (!is_array($values_to_add)) { $new_values_to_add = array($values_to_add); }

	// Merge inputs to return
	$new_query_vars = array_merge($new_query_vars, $new_values_to_add);
	return $new_query_vars;
}

function mcm_get_posts_for_media_taxonomy( $taxonomy = '' ) {

	global $wpdb;

	// Validate input
	if ($taxonomy == '') {
		return array();
	}

	// Get the terms for this taxonomy
	$query  = "SELECT * FROM $wpdb->term_taxonomy AS tt ";
	$query .= " WHERE tt.taxonomy = '$taxonomy' ";
	$taxonomyTerms = $wpdb->get_results( $query );
	//mcm_debugMP('pr',__FUNCTION__ . ' taxonomy found ' . count($taxonomyTerms) . ' with query = ' . $query, $taxonomyTerms);

	// Validate $taxonomyTerms found
	if ( is_wp_error($taxonomyTerms) || (count($taxonomyTerms) == 0)) {
		return array();
	}

	// Create a list of taxonomyTermIDs to be used for the query
	$taxonomyTermIDs = array();
	foreach ($taxonomyTerms as $term) {
		$taxonomyTermIDs[] = $term->term_taxonomy_id;
	}
	$taxonomyTermIDs = implode( ',', $taxonomyTermIDs );

	$query  = "SELECT $wpdb->posts.* FROM $wpdb->posts ";
	$query .= " INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) ";
	$query .= " WHERE 1=1 ";
	$query .= "   AND $wpdb->posts.post_type = 'attachment' ";
	$query .= "   AND ($wpdb->term_relationships.term_taxonomy_id IN ($taxonomyTermIDs)) ";
	$query .= " GROUP BY $wpdb->posts.ID";
	$taxonomyPosts = $wpdb->get_results( $query );
	mcm_debugMP('msg',__FUNCTION__ . ' taxonomy found ' . count($taxonomyPosts) . ' with query = ', $query);

	return $taxonomyPosts;

}

function mcm_get_media_taxonomies() {

	global $wpdb;

	$query  = "SELECT taxonomy FROM $wpdb->term_taxonomy ";
	$query .= " GROUP BY taxonomy";
	$taxonomiesFound = $wpdb->get_results( $query, 'ARRAY_A' );
	$mediaTaxonomiesFound = get_taxonomies( array( 'object_type' => array( 'attachment' ) ), 'names' );
	// Merge both lists found
	foreach ($taxonomiesFound as $taxonomyObject) {
		$mediaTaxonomiesFound[$taxonomyObject['taxonomy']] = $taxonomyObject['taxonomy'];
	}
	mcm_debugMP('pr',__FUNCTION__  . ' query = ' . $query . ', mediaTaxonomiesFound = ', $mediaTaxonomiesFound);

	// Create an element for each taxonomy found
	$mediaTaxonomies = array();
	foreach ($mediaTaxonomiesFound as $taxonomyObject) {
		$taxonomySlug = $taxonomyObject;
		//mcm_debugMP('pr',__FUNCTION__  . ' taxonomySlug found:' . $taxonomySlug . ', taxonomyObject found:', $taxonomyObject);

		// Get the objects belonging to these terms
		$mediaTermPosts = mcm_get_posts_for_media_taxonomy($taxonomySlug);
		//mcm_debugMP('pr',__FUNCTION__  . ' taxonomySlug found:' . count($mediaTermPosts) . ' mediaTermPosts found:', $mediaTermPosts);
		$countMediaPosts = count($mediaTermPosts);

		// Get the taxonomy information
		$mediaTaxonomy = get_taxonomy($taxonomySlug);
		mcm_debugMP('pr',__FUNCTION__  . ' taxonomySlug found:' . $taxonomySlug . ', mediaTaxonomy found:', $mediaTaxonomy);
		$mediaTaxonomyData = array();
		if ($mediaTaxonomy) {
			$mediaTaxonomyData['object'] = $mediaTaxonomy;
			$mediaTaxonomyData['name']   = $mediaTaxonomy->name;
			$mediaTaxonomyData['label']  = $mediaTaxonomy->label . ' [#' . $countMediaPosts . ']';
			// Add indication to label
			switch ($taxonomySlug) {
				case WP_MCM_MEDIA_TAXONOMY:
					break;
				case WP_MCM_POST_TAXONOMY:
					$mediaTaxonomyData['label'] = '(P) ' . $mediaTaxonomyData['label'];
					break;
				case WP_MCM_TAGS_TAXONOMY:
					$mediaTaxonomyData['label'] = '(T) ' . $mediaTaxonomyData['label'];
					break;
				default:
					if (is_object_in_taxonomy('post', $taxonomySlug)) {
						$mediaTaxonomyData['label'] = '(P.) ' . $mediaTaxonomyData['label'];
					} else {
						$mediaTaxonomyData['label'] = '(.) ' . $mediaTaxonomyData['label'];
					}
					break;
			}
		} else {
			$mediaTaxonomyData['object'] = false;
			$mediaTaxonomyData['name']   = $taxonomySlug;
			$mediaTaxonomyData['label']  = '(*) ' . $taxonomySlug . ' [#' . $countMediaPosts . ']';
		}
		// Only add taxonomy when either attachments found OR it is for attachments
		//mcm_debugMP('msg',__FUNCTION__  . ' taxonomySlug: ' . $taxonomySlug . ', tested for attachment with is_object_in_taxonomy found:' . is_object_in_taxonomy('attachment', $taxonomySlug));
		if (($countMediaPosts > 0) || (is_object_in_taxonomy(array('post','attachment'), $taxonomySlug))) {
			$mediaTaxonomies[$taxonomySlug] = $mediaTaxonomyData;
		}
	}

	//mcm_debugMP('pr',__FUNCTION__  . ' mediaTaxonomies found:', $mediaTaxonomies);
	return $mediaTaxonomies;

}

function mcm_get_media_taxonomy() {

	return mcm_get_option('wp_mcm_media_taxonomy_to_use');

}

function mcm_get_attachment_ids( $mcm_atts = array() ) {

	// Get media taxonomy and use default category value
	$media_taxonomy = mcm_get_media_taxonomy();
	if (isset($mcm_atts['taxonomy']) && $mcm_atts['taxonomy'] != '') {
		$media_taxonomy = $mcm_atts['taxonomy'];
	}

	// Get media category and default
	$media_categories = mcm_get_option( 'wp_mcm_default_media_category' );
	if (isset($mcm_atts['category']) && $mcm_atts['category'] != '') {
		$media_categories = explode(',', $mcm_atts['category']);
	}
	if ( !is_array($media_categories)) {
		$media_categories = array ( $media_categories );
	}
	mcm_debugMP('pr',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy . ' categories = ', $media_categories);

	// Get the posts associated with the media_taxonomy
	$attachments_args = array(	'showposts' => -1,
								'post_type' => 'attachment',
								'post_parent' => null,
								'tax_query' => array(
									array(
										'taxonomy' => $media_taxonomy,
										'field' => 'slug',
										'terms' => $media_categories
									)
								),
	);

	// Use gallery options if available
	if (isset($mcm_atts['orderby']) && $mcm_atts['orderby'] != '') {
		$attachments_args['orderby'] = $mcm_atts['orderby'];
	}
	if (isset($mcm_atts['order']) && $mcm_atts['order'] != '') {
		$attachments_args['order'] = $mcm_atts['order'];
	}

	// Get the attachments for these arguments
	$attachments = get_posts($attachments_args);
	mcm_debugMP('pr',__FUNCTION__ . ' attachments found = ' . count($attachments) . ' with attachments_args = ', $attachments_args);

	// Get the post IDs for the attachments found for POST
	$attachment_ids = array();
	if ( $attachments ) {
		foreach ( $attachments as $post ) {
			setup_postdata( $post );
			$attachment_ids[] = $post->ID;
		}
		wp_reset_postdata();
	}

	$attachment_ids_result = implode(',', $attachment_ids);
	mcm_debugMP('pr',__FUNCTION__ . ' attachment_ids_result = ' . $attachment_ids_result . ' attachment_ids = ', $attachment_ids);

	return $attachment_ids_result;

}

/** Custom walker for wp_dropdown_categories, based on https://gist.github.com/stephenh1988/2902509 */
class mcm_walker_category_filter extends Walker_CategoryDropdown{

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {

		$pad = str_repeat( '&nbsp;', $depth * 3 );
		$cat_name = apply_filters( 'list_cats', $category->name, $category );

		if( ! isset( $args['value'] ) ) {
			$args['value'] = 'slug';
		}

		$value = ( $args['value']=='slug' ? $category->slug : $category->term_id );

		$output .= '<option class="level-' . $depth . '" value="' . $value . '"';
		if ( $value === (string) $args['selected'] ) {
			$output .= ' selected="selected"';
		}
		$output .= '>';
		$output .= $pad . $cat_name;
		if ( $args['show_count'] ) {
			$output .= '&nbsp;&nbsp;(' . $category->count . ')';
		}

		$output .= "</option>\n";
	}

}

/** Custom walker for wp_dropdown_categories for media grid view filter */
class mcm_walker_category_mediagridfilter extends Walker_CategoryDropdown {

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		$pad = str_repeat( '&nbsp;', $depth * 3 );
		$cat_name = apply_filters( 'list_cats', $category->name, $category );

		// {"term_id":"1","term_name":"no category"}
		$output .= ',{"term_id":"' . $category->term_id . '",';

		$output .= '"term_name":"' . $pad . esc_attr( $cat_name );
		if ( $args['show_count'] ) {
			$output .= '&nbsp;&nbsp;('. $category->count .')';
		}
		$output .= '"}';
	}

}

/**
 *  mcm_walker_category_mediagrid_checklist
 *
 *  Based on /wp-includes/category-template.php
 *
 *  @since    1.3.0
 *  @created  12/11/14
 */

class mcm_walker_category_mediagrid_checklist extends Walker 
{
	var $tree_type = 'category';
	var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); 

	function start_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent<ul class='children'>\n";
	}

	function end_lvl( &$output, $depth = 0, $args = array() ) {
		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul>\n";
	}

	function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
		extract($args);

		if ( empty($taxonomy) ) {
			$taxonomy = 'category';
		}

		$name = 'tax_input['.$taxonomy.']';

		$output .= "\n<li id='{$taxonomy}-{$category->term_id}'>";
		$output .= '<label class="selectit">';
		$output .= '<input value="' . $category->slug . '" ';
		$output .= 'type="checkbox" ';
		$output .= 'name="'.$name.'['. $category->slug.']" ';
		$output .= 'id="in-'.$taxonomy.'-' . $category->term_id . '"';
		$output .= checked( in_array( $category->term_id, $selected_cats ), true, false );
		$output .= disabled( empty( $args['disabled'] ), false, false );
		$output .= ' /> ';
		$output .= esc_html( apply_filters('the_category', $category->name ));
		$output .= '</label>';
	}

	function end_el( &$output, $category, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

/** Get the label to show in the list of media_category */
function mcm_get_media_category_label( $media_taxonomy = '' ) {

	switch ($media_taxonomy) {
		case WP_MCM_TAGS_TAXONOMY:
			return __( 'tags', 'wp-media-category-management' );
			break;
		case WP_MCM_POST_TAXONOMY:
			return __( 'Post categories', 'wp-media-category-management' );
			break;
		default:
			return __( 'MCM categories', 'wp-media-category-management' );
			break;
	}
}

/** Get the options to determine the list of media_category */
function mcm_get_media_category_options( $media_taxonomy = '', $selected_value = '') {

	// Set options depending on type of taxonomy chosen
	$dropdown_options = array(
		'taxonomy'           => $media_taxonomy,
		'option_none_value'  => WP_MCM_OPTION_NO_CAT,
		'selected'           => $selected_value,
		'hide_empty'         => false,
		'hierarchical'       => true,
		'orderby'            => 'name',
		'walker'             => new mcm_walker_category_filter(),
	);

	// Get some labels
	$mcm_label     = mcm_get_media_category_label($media_taxonomy);
	$mcm_label_all = __( 'View all', 'wp-media-category-management' ) . ' ' . $mcm_label;
	$mcm_label_no  = __( 'No',       'wp-media-category-management' ) . ' ' . $mcm_label;

	switch ($media_taxonomy) {
		case WP_MCM_TAGS_TAXONOMY:
			$dropdown_options_extra = array(
				'name'               => $media_taxonomy,
				'show_option_all'    => $mcm_label_all,
				'show_option_none'   => $mcm_label_no,
				'show_count'         => false,
				'value'              => 'slug'
			);
			break;
		case WP_MCM_POST_TAXONOMY:
			$dropdown_options_extra = array(
				'show_option_all'    => $mcm_label_all,
				'show_option_none'   => $mcm_label_no,
				'show_count'         => false,
				'value'              => 'id'
			);
			break;
		default:
			$dropdown_options_extra = array(
				'name'               => $media_taxonomy,
				'show_option_all'    => $mcm_label_all,
				'show_option_none'   => $mcm_label_no,
				'show_count'         => true,
				'value'              => 'slug'
			);
			break;
	}
	mcm_debugMP('pr',__FUNCTION__ . ' selected_value = ' . $selected_value . ', dropdown_options', array_merge($dropdown_options, $dropdown_options_extra));
	return array_merge($dropdown_options, $dropdown_options_extra);
}

/**
 * Simplify the plugin debugMP interface.
 *
 * Typical start of function call: $this->debugMP('msg',__FUNCTION__);
 *
 * @param string $type
 * @param string $hdr
 * @param string $msg
 */
function mcm_debugMP($type,$hdr,$msg='') {

	global $wp_mcm_plugin;
	if (!is_object($wp_mcm_plugin)) { return; }

	if (($type === 'msg') && ($msg!=='')) {
		$msg = esc_html($msg);
	}
	if (($hdr!=='')) {
		$hdr = 'Func:: ' . $hdr;
	}

	$wp_mcm_plugin->debugMP($type,$hdr,$msg,NULL,NULL,true);
}


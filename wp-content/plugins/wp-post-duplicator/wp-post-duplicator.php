<?php 
/*
Plugin Name: WP Post Duplicator
Plugin URI: http://desirepress.com
Description: Duplicating posts, pages & custom post types along with meta fields & category/taxonomy in WordPress.
Author: DesirePress
Version: 1.0.0
Author URI: http://desirepress.com
License: GPL2
-------------------------------------------------*/

if ( !class_exists( 'WPDuplicator' ) and is_admin()) :
 
class WPDuplicator{
	
	public function __construct() {

		// add admin actions and filters
		add_action( 'admin_footer-edit.php', array( &$this, 'wpd_admin_footer' ));
		add_action( 'load-edit.php',         array( &$this, 'wpd_action' ));
		add_action( 'admin_notices',         array( &$this, 'wpd_admin_notices' ));
		add_filter( 'post_row_actions', 	 array( &$this, 'wpd_post_row_actions' ), 10, 2);
		add_filter( 'page_row_actions', 	 array( &$this, 'wpd_post_row_actions' ), 10, 2);
		add_action( 'wp_loaded', 			 array( &$this, 'wpd_wp_loaded' ));
	}
	
	/**
	 * Add the custom Bulk Action to the select menus
	 */
	function wpd_admin_footer() {
		?>
		<script type="text/javascript">
			jQuery(function () {
				jQuery('<option>').val('duplicate').text('<?php _e('WP Duplicate Post')?>').appendTo("select[name='action']");
				jQuery('<option>').val('duplicate').text('<?php _e('WP Duplicate Post')?>').appendTo("select[name='action2']");
			});
		</script>
		<?php
	}
	
	/**
	 * Handle the custom Bulk Action
	 */
	function wpd_action() 
	{
		global $typenow;
		$post_type = $typenow;

		// get the action
		$wp_list_table = _get_list_table('WP_Posts_List_Table'); 
		$action = $wp_list_table->current_action();
		
		$allowed_actions = array("duplicate");
		if ( ! in_array( $action, $allowed_actions )) {
			return;
		}
		
		// security check
		check_admin_referer('bulk-posts');
		
		// make sure ids are submitted.  depending on the resource type, this may be 'media' or 'ids'
		if ( isset( $_REQUEST['post'] )) {
			$post_ids = array_map( 'intval', $_REQUEST['post'] );
		}
		
		if ( empty( $post_ids )) {
			return;
		}
		
		// this is based on wp-admin/edit.php
		$sendback = remove_query_arg( array( 'duplicated', 'untrashed', 'deleted', 'ids' ), wp_get_referer() );
		if ( ! $sendback ) {
			$sendback = admin_url( "edit.php?post_type=$post_type" );
		}
		
		$pagenum = $wp_list_table->get_pagenum();
		$sendback = add_query_arg( 'paged', $pagenum, $sendback );
		
		switch ( $action ) {
			case 'duplicate':
				
				$duplicated = 0;
				foreach ( $post_ids as $post_id ) {

					if ( !current_user_can('edit_post', $post_id) ) {
						wp_die( __('You are not allowed to duplicate this post.') );
					}
					
					if ( ! $this->wpd_duplicate_single_post( $post_id )) {
						wp_die( __('Error cloning post.') );
					}
	
					$duplicated++;
				}
				
				$sendback = add_query_arg( array( 'duplicated' => $duplicated, 'ids' => join(',', $post_ids) ), $sendback );
				break;
			
			default: 
				return;
		}
		
		$sendback = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author','comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $sendback );
		
		wp_redirect($sendback);
		exit();
	}
	
	/**
	 * Step 3: display an admin notice on the Posts page after duplicating
	 */
	function wpd_admin_notices() 
	{
		global $pagenow;
		
		if ($pagenow == 'edit.php' && ! isset($_GET['trashed'] )) {
			$duplicated = 0;
			if ( isset( $_REQUEST['duplicated'] ) && (int) $_REQUEST['duplicated'] ) {
				$duplicated = (int) $_REQUEST['duplicated'];
			} elseif ( isset($_GET['duplicated']) && (int) $_GET['duplicated'] ) {
				$duplicated = (int) $_GET['duplicated'];
			}
			if ($duplicated) {
				$message = sprintf( _n( 'Post Duplicated Successfully.', '%s posts duplicated.', $duplicated ), number_format_i18n( $duplicated ) );
				echo "<div class=\"updated\"><p>{$message}</p></div>";
			}
		}
	}

	function wpd_post_row_actions( $actions, $post ) {
		global $post_type;

		$url = remove_query_arg( array( 'duplicated', 'untrashed', 'deleted', 'ids' ), "" );
		if ( ! $url ) {
			$url = admin_url( "?post_type=$post_type" );
		}
		$url = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author', 
			'comment_status', 'ping_status', '_status',  'post', 'bulk_edit', 'post_view'), $url );
		$url = add_query_arg( array( 'action' => 'duplicate-single', 'post' => $post->ID, 'redirect' => $_SERVER['REQUEST_URI'] ), $url );
		
		$post_type_labels = get_post_type_object( $post_type );

		$actions['duplicate'] =  '<a href=\''.$url.'\'>'.__('Copy '.ucwords($post_type_labels->labels->singular_name).'').'</a>';
		return $actions;
	}

	function wpd_wp_loaded() 
	{
		global $post_type;

		if ( ! isset($_GET['action']) || $_GET['action'] !== "duplicate-single") {
			return;
		}

		$post_id = (int) $_GET['post'];

		if ( !current_user_can('edit_post', $post_id )) {
			wp_die( __('You are not allowed to duplicate this post.') );
		}

		if ( !$this->wpd_duplicate_single_post( $post_id )) {
			wp_die( __('Error cloning post.') );
		}

		$sendback = remove_query_arg( array( 'duplicated', 'untrashed', 'deleted', 'ids' ), $_GET['redirect'] );
		if ( ! $sendback ) {
			$sendback = admin_url( "edit.php?post_type=$post_type" );
		}
		
		$sendback = add_query_arg( array( 'duplicated' => 1 ), $sendback );
		$sendback = remove_query_arg( array( 'action', 'action2', 'tags_input', 'post_author','comment_status', 'ping_status', '_status', 'post', 'bulk_edit', 'post_view'), $sendback );
		wp_redirect($sendback);
		exit();
	}

	function wpd_duplicate_single_post( $id ) 
	{
    	$p = get_post( $id );
	    if ($p == null) return false;

		$newpost = array(
			'post_name'				=> $p->post_name,
			'post_type'				=> $p->post_type,
			'ping_status'			=> $p->ping_status,
			'post_parent'			=> $p->post_parent,
			'menu_order'			=> $p->menu_order,
			'post_password'			=> $p->post_password,
			'post_excerpt'			=> $p->post_excerpt,
			'comment_status'		=> $p->comment_status,
			'post_title'			=> $p->post_title . __(''),
			'post_content'			=> $p->post_content,
			'post_author'			=> $p->post_author,
			'to_ping'				=> $p->to_ping,
			'pinged'				=> $p->pinged,
			'post_content_filtered' => $p->post_content_filtered,
			'post_category'			=> array('52'),
			'tags_input'			=> $p->tags_input,
			'page_template'			=> $p->page_template
		);
		
		// Add New post
		$newid  = wp_insert_post($newpost);
		$format = get_post_format( $id );
		set_post_format($newid, $format);
		
		// Fetch all meta field for selected post
		$post_meta_data = get_post_meta( $id );
		
		if($newid)
		{
			// Loop over returned metadata, and re-assign them to the new post_type
			if( $post_meta_data ) {
				foreach( $post_meta_data as $meta_data => $value ) {
					if( is_array( $value ) ) {
						foreach( $value as $meta_value => $meta_text ) {
							/* 
							* - Check for serialized data in some meta field
							*/
							if( is_serialized( $meta_text ) ) {
								update_post_meta( $newid, $meta_data,  unserialize( $meta_text ) );
							} else {
								update_post_meta( $newid, $meta_data,  $meta_text );
							}
						}
					} else {
						update_post_meta( $newid, $meta_data, $value );
					}
				}
			}
			
			// Get post type info from created new post ID
			$postType = get_post_type( $newid );

			// If created post is not a page/post.
			if($postType != 'page' && $postType !="post")
			{
				// Fetch all registered taxonomies with selected post
				$regst_taxonomies = get_post_taxonomies( $id );
			
				if(!empty($regst_taxonomies))
				{
					foreach($regst_taxonomies as $taxonomy){	
						// Create array of assosicated taxonomy terms with selected post
						$taxonomyTerms[$taxonomy] = wp_get_post_terms( $id, $taxonomy, array("fields" => "ids"));
					}
					
					foreach($taxonomyTerms as $key => $taxterm){
						$term[$key] = $taxterm;
					}
					
					foreach($term as $taxokey => $termID){
						wp_set_post_terms( $newid, $termID, $taxokey );
					}
				}
			}
		}
		
		return true;
	}
}

new WPDuplicator();
endif;
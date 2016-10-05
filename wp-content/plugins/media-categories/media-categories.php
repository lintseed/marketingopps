<?php
/*
Plugin Name: Media Categories
Plugin URI: 
Description: Categorize media in the same way you categorize posts and links.
Author: Iain Porter
Version: 0.2
Author URI: http://www.intraspin.com/	
*/

/*  Copyright 2009 Iain Porter  (email : iporter@intraspin.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


/*
	- Attachments are stored like posts in wp_posts
	- Names of Categories/Post Tags/Media Tags are stored in wp_terms
	- The taxonomy(s) to which terms belong is stored in wp_term_taxonomy
	- The relationship between Posts/Pages/Attachments and Terms (of specific taxonomies) is specified in wp_term_relationships - object_id is from wp_posts, and term_taxonomy_id from wp_term_taxonomies
*/

if (!class_exists("MediaCategories")) :
	class MediaCategories {
		
		var $page = 'media-categories';		// ADMIN_MENU_KEY
		var $taxonomy = 'media-category';	// MEDIA_TAGS_TAXONOMY
		var $messages = array();
		
		
		function MediaCategories() {
			// install
			add_action('activate_media_categories/media_categories.php', array(&$this,'install'));
			add_action('init', array(&$this, 'register_taxonomy'));
			
			// add menu to manage categories
			add_action('admin_menu', array(&$this, 'add_to_menu'));
			
			// add fields to media management interface
			add_filter('attachment_fields_to_edit',array(&$this,'add_fields_to_media_management_interface'), 11, 2);
			add_filter('attachment_fields_to_save', array(&$this,'save_media_categories'), 11, 2);
			
			$this->messages[1] = __('Media Category added.');
			$this->messages[2] = __('Media Category deleted.');
			$this->messages[3] = __('Media Category updated.');
			$this->messages[4] = __('Media Category not added.');
			$this->messages[5] = __('Media Category not updated.');
			$this->messages[6] = __('Media Category deleted.');
			
			if ((isset($_REQUEST['page'])) && ($_REQUEST['page'] == $this->page)) {
				$this->register_taxonomy();
				$this->select_action();
//				add_action('admin_head', array(&$this,'admin_head'));
			}
		}
		
		function install() {
			// Register the Taxonomy
			if ((isset($_REQUEST['page'])) && ($_REQUEST['page'] == "media-categories/media-categories.php"))	 $this->register_taxonomy();	
		}
		
		function register_taxonomy() {
			register_taxonomy($this->taxonomy, $this->taxonomy, array());
		}
		
		function add_to_menu() {
			add_media_page( "Categories", "Categories", 8, 'media-categories', array(&$this,'draw_admin_menu_page'));
		}
		
		function admin_head() {
			?><script type="text/javascript" src="<?php echo get_bloginfo('wpurl') . "/wp-content/plugins/".dirname(plugin_basename(__FILE__)) ?>/media-categories-inline-edit.js"></script><?php
		}
		
		function add_fields_to_media_management_interface($form_fields, $post) {
			$categories = (array) get_terms($this->taxonomy, 'hide_empty=0');
			$item_categories = (array)wp_get_object_terms($post->ID, $this->taxonomy);
			$item_category_slugs = array();
			if ($item_categories)	foreach ($item_categories as $item_category)	$item_category_slugs[] = $item_category->slug;

			if ($categories) {
				$options = '';
				foreach($categories as $cat) {
					$selected = '';
					if (in_array($cat->slug, $item_category_slugs) !== FALSE)	$selected = ' selected="selected"';
					$options.= "<option value='$cat->slug'$selected>".__($cat->name)."</option>";
				}

				 $form_fields['media-categories'] = array(
					'label' => __('Categories:'),
					'input' => 'html',
					'html' => "<select multiple='multiple' name='attachments[$post->ID][media-categories][]' id='attachments[$post->ID][media-categories]'>$options</select>"
				);
			}
			return $form_fields;
		}
		
		function save_media_categories($post, $attachment) {
			$categories = array();
			if (isset($attachment['media-categories'])) {
				foreach($attachment['media-categories'] as $cat) {
					$categories[] = $cat;
				}
			}
			wp_set_object_terms($post['ID'], $categories, $this->taxonomy);
			
			return $post;
		}
		
		function draw_admin_menu_page() {
			require_once(ABSPATH . 'wp-includes/pluggable.php');
			$this->register_columns();
			if ( ! current_user_can( 'manage_categories' ) )	return;
?>
<div class="wrap nosubsub">

	<?php screen_icon(); ?>
	<h2>
		Media Categories
		<?php if ( isset($_GET['s']) && $_GET['s'] )	printf( '<span class="subtitle">' . __('Search results for &#8220;%s&#8221;') . '</span>', wp_specialchars( stripslashes($_GET['s']) ) ); ?>
	</h2>
	
	<?php if ( isset($_GET['message']) && ( $msg = (int) $_GET['message'] ) ) : ?>
	<div id="message" class="updated fade"><p><?php echo $this->messages[$msg]; ?></p></div>
	<?php $_SERVER['REQUEST_URI'] = remove_query_arg(array('message'), $_SERVER['REQUEST_URI']);
	endif; ?>
	
<?php 		if ((isset($_GET['action'])) && ($_GET['action'] == 'editmediacategory')) :
				$id = (int) $_GET['category_id'];
				$this->edit_category($id);
			else:
?>
	<form class="search-form" method="get" action="<?php echo get_option('siteurl') ?>/wp-admin/upload.php">
		<p class="search-box">
			<input type="hidden" name="page" value="<?php echo $this->page; ?>" />
			<input type="hidden" name="action" value="searchmediacategories" />
			<label class="hidden" for="media-categories-search-input"><?php _e( 'Search Media Categories' ); ?>:</label>
			<input type="text" class="search-input" id="media-categories-search-input" name="s" value="<?php _admin_search_query(); ?>" />
			<input type="submit" value="<?php _e( 'Search Media Categories' ); ?>" class="button" />
		</p>
	</form>

	<br class="clear" />

	<div id="col-container">
		
		<div id="col-right">
			<div class="col-wrap">
				<form id="posts-filter" method="get" action="<?php echo get_option('siteurl') ?>/wp-admin/upload.php">
					<div class="tablenav">
						<?php
							$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 0;
							if ( empty($pagenum) )	$pagenum = 1;
					
							$tagsperpage = apply_filters("tagsperpage",20);

							$page_links = paginate_links( array(
								'base' => add_query_arg( 'pagenum', '%#%' ),
								'format' => '',
									'prev_text' => __('&laquo;'),
									'next_text' => __('&raquo;'),
									'total' => ceil(wp_count_terms($this->taxonomy) / $tagsperpage),
									'current' => $pagenum
							));

							if ( $page_links )
								echo "<div class='tablenav-pages'>$page_links</div>";
						?>
						<div class="alignleft actions">
							<select name="action">
								<option value="" selected="selected"><?php _e('Bulk Actions'); ?></option>
								<option value="deletemediatagsbulk"><?php _e('Delete'); ?></option>
							</select>
							<input type="hidden" name="page" value="<?php echo $this->page ?>" />
							<input type="submit" value="<?php _e('Apply'); ?>" name="doaction" 
								id="doaction" class="button-secondary action" />
							<?php wp_nonce_field('media-tags-bulk'); ?>
						</div>
						<br class="clear" />
					</div>
					<div class="clear"></div>
					<table class="widefat tag fixed" cellspacing="0">
						<thead>
							<tr><?php print_column_headers('edit-media-categories'); ?></tr>
						</thead>

						<tfoot>
						<tr><?php print_column_headers('edit-media-categories', false); ?></tr>
						</tfoot>

						<tbody id="the-list" class="list:tag">
						<?php
							$searchterms = isset( $_GET['s'] ) ? trim( $_GET['s'] ) : '';
							$count = $this->display_rows($pagenum, $tagsperpage, $searchterms);
						?>
						</tbody>
					</table>

					<div class="tablenav">
						<?php if ( $page_links )	echo "<div class='tablenav-pages'>$page_links</div>"; ?>
						<div class="alignleft actions">
							<select name="action2">
								<option value="" selected="selected"><?php _e('Bulk Actions'); ?></option>
								<option value="deletemediatagsbulk"><?php _e('Delete'); ?></option>
							</select>
							<input type="submit" value="<?php _e('Apply'); ?>" name="doaction2" id="doaction2" class="button-secondary action" />
						</div>
						<br class="clear" />
					</div>
					<br class="clear" />
				</form>
			</div>
		</div><!-- /col-right -->

		<div id="col-left">
			<div class="col-wrap">
				<?php do_action('add_tag_form_pre'); ?>
				<div class="form-wrap">
					<h3><?php _e('Add a New Category'); ?></h3>
					<div id="ajax-response"></div>
					<form name="addcategory" id="addcategory" method="post" class="add:the-list: validate" action="<?php echo get_option('siteurl') ?>/wp-admin/upload.php?page=<?php echo $this->page; ?>">
						<input type="hidden" name="action" value="addmediacategory" />
						<div class="form-field form-required">
							<label for="name"><?php _e('Category Name') ?></label>
							<input name="name" id="name" type="text" value="" size="40" aria-required="true" />
							<p><?php _e('The name is how the category appears on your site.'); ?></p>
						</div>
						<div class="form-field">
							<label for="slug"><?php _e('Category Slug') ?></label>
							<input name="slug" id="slug" type="text" value="" size="40" />
							<p><?php _e('The &#8220;slug&#8221; is the URL-friendly version of the name.  It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?></p>
						</div>
						<p class="submit"><input type="submit" class="button" name="submit" value="<?php _e('Add Category'); ?>" /></p>
					</form>
				</div>
			</div>
		</div><!-- /col-left -->
	
	</div><!-- /col-container -->
	<?php endif; ?>
	
</div><!-- /wrap -->
<?php 
//			$this->draw_inline_edit('edit-media-categories');
		}
		
		function register_columns() {
			if (!function_exists('register_column_headers'))	require_once(ABSPATH . 'wp-admin/includes/template.php');
			$columns = array(	'cb' => '<input type="checkbox" />',
							'name' => __('Name'),
							'slug' => __('Slug'),
							'posts' => __('Used')
			);
			register_column_headers('edit-media-categories', $columns );
		}
	
		function display_rows($page = 1, $pagesize = 20, $searchterms = '' ) {
			// Get a page worth of tags
			$start = ($page - 1) * $pagesize;
			$args = array('offset' => $start, 'number' => $pagesize, 'hide_empty' => 0);
			if (!empty($searchterms))	$args['search'] = $searchterms;
			$categories = get_terms($this->taxonomy, $args );
			//echo "tags<pre>"; print_r($tags); echo "</pre>";
			// convert it to table rows
			$out = '';
			$count = 0;
			foreach( $categories as $category) {
				$out .= $this->display_row( $category, ++$count % 2 ? ' class="iedit alternate"' : ' class="iedit"' );
			}
			// filter and send to screen
			echo $out;
			return $count;
		}
		
		function display_row($category, $class = '') {
			$base_url = get_option('siteurl')."/wp-admin/upload.php?page=".$this->page;

			$count = number_format_i18n( $category->count );
			$count = ( $count > 0 ) ? "<a href='".get_option('siteurl')."/wp-admin/upload.php?category_id=$category->term_id'>$count</a>" : $count;

			$name = apply_filters( 'term_name', $category->name );
			$qe_data = get_term($category->term_id, $this->taxonomy, object, 'edit');
			$edit_link = $base_url ."&action=editmediacategory&amp;category_id=$category->term_id";

			$out = '';
			$out .= '<tr id="tag-' . $category->term_id . '"' . $class . '>';
			
			$columns = get_column_headers('edit-media-categories');
			$hidden = get_hidden_columns('edit-media-categories');
			foreach ($columns as $column_name => $column_display_name) {
				$class = "class=\"$column_name column-$column_name\"";
				$style = '';
				if (in_array($column_name, $hidden))	$style = ' style="display:none;"';
				$attributes = "$class$style";
				switch ($column_name) {
					case 'cb':
						$out .= '<th scope="row" class="check-column"> <input type="checkbox" name="delete_media_tags[]" value="' . $category->term_id . '" /></th>';
						break;
					case 'name':
						$out .= '<td ' . $attributes . '><strong><a class="row-title" href="' . $edit_link . '" title="' . attribute_escape(sprintf(__('Edit "%s"'), $name)) . '">' . $name . '</a></strong><br />';
						$actions = array();
						$actions['edit'] = '<a href="' . $edit_link . '">' . __('Edit') . '</a>';
//						$actions['inline hide-if-no-js'] = '<a href="#" class="editinline-mediacategory">' . __('Quick&nbsp;Edit') . '</a>';
						$actions['delete'] = "<a class='submitdelete' href='" . wp_nonce_url(get_option('siteurl') . "/wp-admin/upload.php?page=" . $this->page . "&amp;action=deletemediacategory&amp;category_id=$category->term_id", 'delete-tag_' . $category->term_id) . "' onclick=\"if ( confirm('" . js_escape(sprintf(__("You are about to delete this media category '%s'\n 'Cancel' to stop, 'OK' to delete."), $name )) . "') ) { return true;}return false;\">" . __('Delete') . "</a>";
						$action_count = count($actions);
						$i = 0;
						$out .= '<div class="row-actions">';
						foreach ( $actions as $action => $link ) {
							++$i;
							( $i == $action_count ) ? $sep = '' : $sep = ' | ';
							$out .= "<span class='$action'>$link$sep</span>";
						}
						$out .= '</div>';
						$out .= '<div class="hidden" id="inline_' . $qe_data->term_id . '">';
						$out .= '<div class="name">' . $qe_data->name . '</div>';
						$out .= '<div class="slug">' . $qe_data->slug . '</div></div></td>';
						break;
					case 'slug':
						$out .= "<td $attributes>$category->slug</td>";
						break;
					case 'posts':
						$attributes = 'class="posts column-posts num"' . $style;
						$out .= "<td $attributes>$count</td>";
						break;
				}
			}
			$out .= '</tr>';
			return $out;
		}
		
		function select_action() {
			if (!isset($_REQUEST['action']))	return;

			if (strlen($_REQUEST['action']) == 0) {
				if ((isset($_REQUEST['action2'])) && (strlen($_REQUEST['action2']) > 0))	{
					$_REQUEST['action'] = $_REQUEST['action2'];
				} else {
					return;
				}
			}
			
			switch($_REQUEST['action']) {
				case 'inline-save-mediacategory':
					$this->inline_update();//mediatags_process_inline_save();
					exit;
					break;
				case 'updatemediacategory':
					$this->update_category();
					break;
				case 'deletemediacategory':
					$this->delete_category();
					break;
				case 'deletemediatagsbulk':
					mediatags_process_delete_bulk();
					break;
				case 'addmediacategory':
					$this->add_category();
					break;
				default:
					break;
			}
		}
		
		function add_category() {
			if (!isset($_REQUEST['name']))	return;

			$name = trim($_REQUEST['name']);
			if ((isset($_REQUEST['slug'])) && (strlen($_REQUEST['slug']))) {
				$slug = trim($_REQUEST['slug']);
			} else {
				$slug = trim($_REQUEST['name']);
			}
			$slug = sanitize_title_with_dashes($slug);
			if ( '' === $slug )	return;

			if (!function_exists('wp_redirect'))	require_once(ABSPATH . 'wp-includes/pluggable.php');
			
			if (!is_term($name, $this->taxonomy))  {
				$ret = wp_insert_term($name, $this->taxonomy, array('slug' => $slug));
				if ( $ret && !is_wp_error( $ret ) ) {
					wp_redirect(get_option('siteurl') ."/wp-admin/upload.php?page=" . $this->page . "&message=1");
				} else {
					wp_redirect(get_option('siteurl') ."/wp-admin/upload.php?page=" . $this->page . "&message=4");
				}
				exit;
			}
		}
		function delete_category() {
			if (!isset($_REQUEST['category_id']))	return;

			$categoryID = intval($_REQUEST['category_id']);
			wp_delete_term( $categoryID, $this->taxonomy);

			$redirect_url = get_option('siteurl') ."/wp-admin/upload.php?page=".$this->page."&message=2";
			if (isset($_REQUEST['pagenum']))	$redirect_url .= "pagenum=".$_REQUEST['pagenum'];

			if (!function_exists('wp_redirect'))	require_once(ABSPATH . 'wp-includes/pluggable.php');

			wp_redirect($redirect_url);
			exit;	
		}
		function edit_category($catID) {
			if ( empty($catID) ) { 
?>
				<div id="message" class="updated fade"><p><strong><?php _e('A category was not selected for editing.'); ?></strong></p></div>
<?php 			return;
			}
			$category = get_term($catID, $this->taxonomy, OBJECT, 'edit');			
			do_action('edit_tag_form_pre', $category); 
?>
			<div class="wrap">
				<?php //screen_icon(); ?>
				<h2><?php _e('Edit Category'); ?></h2>
				<div id="ajax-response"></div>
				<form name="edittag" id="edittag" method="post" class="validate" action="<?php echo get_option('siteurl') ?>/wp-admin/upload.php?page=<?php echo $this->page; ?>">
					<input type="hidden" name="action" value="updatemediacategory" />
					<input type="hidden" name="category_ID" value="<?php echo $category->term_id ?>" />
					<?php wp_original_referer_field(true, 'previous'); wp_nonce_field('update-tag_' . $catID); ?>
					<table class="form-table">
						<tr class="form-field form-required">
							<th scope="row" valign="top"><label for="name"><?php _e('Category name') ?></label></th>
							<td><input name="name" id="name" type="text" value="<?php if ( isset( $category->name ) ) echo attribute_escape($category->name); ?>" size="40" aria-required="true" />
							<p><?php _e('The name is how the category appears on your site.'); ?></p></td>
						</tr>
						<tr class="form-field">
							<th scope="row" valign="top"><label for="slug"><?php _e('Category slug') ?></label></th>
							<td><input name="slug" id="slug" type="text" value="<?php if ( isset( $category->slug ) ) echo attribute_escape(apply_filters('editable_slug', $category->slug)); ?>" size="40" />
							<p><?php _e('The &#8220;slug&#8221; is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.'); ?></p></td>
						</tr>
					</table>
					<p class="submit"><input type="submit" class="button-primary" name="submit" value="<?php _e('Update Category'); ?>" /></p>
					<?php do_action('edit_tag_form', $tag); ?>
				</form>
			</div>
<?php
		}
		function update_category() {
			if (!isset($_REQUEST['category_ID']))	return;
			
			$id = intval($_REQUEST['category_ID']);
			$name = trim($_REQUEST['name']);
			
			if ((isset($_REQUEST['slug'])) && (strlen($_REQUEST['slug']))) {
				$slug = trim($_REQUEST['slug']);
			} else {
				$slug = trim($_REQUEST['name']);
			}
			$slug = sanitize_title_with_dashes($slug);

			if ( '' === $slug )	return;

			if (!function_exists('wp_redirect'))	require_once(ABSPATH . 'wp-includes/pluggable.php');

			$ret = wp_update_term($id, $this->taxonomy, array('slug' => $slug, 'name' => $name));
			if ( $ret && !is_wp_error( $ret ) ) {
				wp_redirect(get_option('siteurl') ."/wp-admin/upload.php?page=" . $this->page . "&message=3");
			} else {
				wp_redirect(get_option('siteurl') ."/wp-admin/upload.php?page=" . $this->page . "&message=5");
			}
			exit;
		}
		function inline_update() {
			require_once(ABSPATH . 'wp-includes/pluggable.php');
			$this->register_columns();
			if ( ! isset($_POST['tax_ID']) || ! ( $id = (int) $_POST['tax_ID'] ) )	die(-1);
				
			$updated = wp_update_term($id, $this->taxonomy, $_POST);
			if ($updated && !is_wp_error($updated)) {
				$tag = get_term( $updated['term_id'], $this->taxonomy );
				if ( !$tag || is_wp_error( $tag ) )	die( __('Tag not updated.') );
				echo $this->display_row($tag);
			} else {
				die( __('Tag not updated.') );
			}
		}
		function draw_inline_edit($type) {
			if ( ! current_user_can( 'manage_categories' ) )	return;

			$is_tag = $type == 'edit-media-categories';
			$columns = get_column_headers($type);
			$hidden = array_intersect( array_keys( $columns ), array_filter( get_hidden_columns($type) ) );
			$col_count = count($columns) - count($hidden);
?>
			<form method="get" action="">
				<table style="display: none">
					<tbody id="inlineedit">
						<tr id="inline-edit-media-category" class="inline-edit-row" style="display: none">
							<td colspan="<?php echo $col_count; ?>">
								<fieldset>
									<div class="inline-edit-col">
										<h4><?php _e( 'Quick Edit' ); ?></h4>
										<label>
											<span class="title"><?php _e( 'Name' ); ?></span>
											<span class="input-text-wrap"><input type="text" name="name" class="ptitle" value="" /></span>
										</label>
										<label>
											<span class="title"><?php _e( 'Slug' ); ?></span>
											<span class="input-text-wrap"><input type="text" name="slug" class="ptitle" value="" /></span>
										</label>
									</div>
								</fieldset>
<?php
			$core_columns = array( 'cb' => true, 'description' => true, 'name' => true, 'slug' => true, 'posts' => true );
			foreach ( $columns as $column_name => $column_display_name ) {
				if ( isset( $core_columns[$column_name] ) )
					continue;
				do_action( 'quick_edit_custom_box', $column_name, $type );
			}
?>
								<p class="inline-edit-save submit">
									<a accesskey="c" href="#inline-edit-media-category" title="<?php _e('Cancel'); ?>" class="cancel button-secondary alignleft"><?php _e('Cancel'); ?></a>
									<?php $update_text = ( $is_tag ) ? __( 'Update Tag' ) : __( 'Update Category' ); ?>
									<a accesskey="s" href="#inline-edit-media-category" title="<?php echo attribute_escape( $update_text ); ?>" class="save button-primary alignright"><?php echo $update_text; ?></a>
									<img class="waiting" style="display:none;" src="images/loading.gif" alt="" />
									<span class="error" style="display:none;"></span>
									<?php wp_nonce_field( 'taxinlineeditnonce', '_inline_edit', false ); ?>
									<br class="clear" />
								</p>
							</td>
						</tr>
					</tbody>
				</table>
			</form>
<?php
		}
		
		function get_attachments_by_media_categories($args='') {
			global $post;
			$defaults = array(
				'call_source' => '',
				'display_item_callback' => 'default_item_callback',
				'media_categories' => '', 
				'media_types' => null,
				'search_by' => 'slug',
				'numberposts' => '-1',
				'orderby' => 'menu_order',
				'order' => 'ASC',
				'offset' => '0',
				'return_type' => '',
				'tags_compare' => 'OR'			
			);
			$r = wp_parse_args( $args, $defaults );

			if ((!$r['media_categories']) || (strlen($r['media_categories']) == 0))	return;

			// Force 'OR' on compare if searching by name (not slug). This is because the name search will return multiple values per each 'media_tags' searched item.
			if ($r['search_by'] != 'slug')	$r['tags_compare'] = 'OR';

			// First split the comma-seperated media-tags list into an array
			$r['media_categories_array'] = split(',', $r['media_categories']);
			if ($r['media_categories_array']) {
				foreach($r['media_categories_array'] as $idx => $val) {
					$r['media_categories_array'][$idx] = sanitize_title_with_dashes($val);
				}
			}

			// Next split the comma-seperated media-types list into an array
			if ($r['media_types']) {
				$r['media_types_array'] = split(',', $r['media_types']);
				if ($r['media_types_array']) {
					foreach($r['media_types_array'] as $idx => $val) {
						$r['media_types_array'][$idx] = sanitize_title_with_dashes($val);
					}
				}
			}

			// Next lookup each term in the terms table. 
			$search_terms_array = array();
			if ($r['media_categories_array']) {
				foreach($r['media_categories_array'] as $search_term) {
					$get_terms_args['hide_empty'] = 0;

					if ($r['search_by'] != "slug") {
						$get_terms_args['search'] = $search_term;
					} else {
						$get_terms_args['slug'] = $search_term;
					}
					$terms_item = get_terms($this->taxonomy, $get_terms_args );
					if ($terms_item)	$search_terms_array[$search_term] = $terms_item;
				}
			}

			$objects_ids_array = array();
			if (count($search_terms_array)) {
				foreach($search_terms_array as $search_term_items) {
					if ($search_term_items) {
						foreach($search_term_items as $search_term_item) {
							$objects_ids = get_objects_in_term($search_term_item->term_id, $this->taxonomy);
							if ($objects_ids)	$objects_ids_array[] = $objects_ids;
						}
					}
				}
			}

			if (count($objects_ids_array) > 1) {
				foreach($objects_ids_array as $idx_ids => $object_ids_item) {
					if ((!isset($array_unique_ids)) && ($idx_ids == 0)) {
						$array_unique_ids = $object_ids_item;
					}
					if (strtoupper($r['tags_compare']) == strtoupper("AND")) {
						$array_unique_ids = array_unique(array_intersect($array_unique_ids, $object_ids_item));
					} else {
						$array_unique_ids = array_unique(array_merge($array_unique_ids, $object_ids_item));
					}
				}
				sort($array_unique_ids);
			} else if (count($objects_ids_array) == 1) {
				$array_unique_ids = $objects_ids_array[0];
			}

			$object_ids_str = "";
			if ($array_unique_ids)	$object_ids_str = implode(',', $array_unique_ids);

			if ($object_ids_str) {
				$query_str = 'post_type=attachment&numberposts=-1';
				if (isset($r['post_parent'])) $query_str = "post_parent=". $r['post_parent'] . "&". $query_str;

				$attachment_posts = get_posts($query_str);

				$attachment_posts_ids = array();
				if ($attachment_posts) {
					foreach($attachment_posts as $attachment_post) {
						$attachment_posts_ids[] = $attachment_post->ID;
					}
				}

				$result = array_intersect($array_unique_ids, $attachment_posts_ids);
				//echo "result<pre>"; print_r($result); echo "</pre>";
				if ($result) {				
					$get_post_args['post_type'] 	= "attachment";
					$get_post_args['numberposts'] 	= $r['numberposts'];
					$get_post_args['offset']		= $r['offset'];
					$get_post_args['orderby']		= $r['orderby'];
					$get_post_args['order']		= $r['order'];
					$get_post_args['include']		= implode(',', $result);
					//echo "get_post_args<pre>"; print_r($get_post_args); echo "</pre>";

					$attachment_posts = get_posts($get_post_args);

					// Now that we have the list of all matching posts we need to filter by the media type is provided
					if (count($r['media_types_array'])) {
						foreach($attachment_posts as $attachment_idx => $attachment_post) {
							$ret_mime_match = wp_match_mime_types($r['media_types_array'], $attachment_post->post_mime_type);
							//echo "ret_mime_match<pre>"; print_r($ret_mime_match); echo "</pre>";
							if (!$ret_mime_match)	unset($attachment_posts[$attachment_idx]);
						}
					}

					// If the calling system doesn't want the whole list.
					if (($r['offset'] > 0) || ($r['numberposts'] > 0))	$attachment_posts = array_slice($attachment_posts, $r['offset'], $r['numberposts']);

					if ($r['return_type'] === "li") {
						$attachment_posts_list = "";
						foreach($attachment_posts as $attachment_idx => $attachment_post) {
							if ((strlen($r['display_item_callback'])) && (function_exists($r['display_item_callback'])))	$attachment_posts_list .= call_user_func($r['display_item_callback'], $attachment_post);
						}
					return $attachment_posts_list;
					} else {
						return $attachment_posts;
					}
				}
			}
		}
	}
endif;
if (class_exists("MediaCategories"))	$MediaCategories = new MediaCategories();

// Template Tags
function &get_mediacategories($args = '') {
	global $MediaCategories;
	$categories = get_terms($MediaCategories->taxonomy, $args );
	if ( empty( $categories ) ) {
		$return = array();
		return $return;
	}
	$categories = apply_filters( 'get_mediacategories', $categories, $args );
	return $categories;
}

function get_attachments_by_media_categories($args='') {
	global $MediaCategories;
	return $MediaCategories->get_attachments_by_media_categories($args);
}
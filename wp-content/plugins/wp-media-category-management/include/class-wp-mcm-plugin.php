<?php
/**
 * The WordPress Media Category Management Plugin.
 *
 * @package   WP_MediaCategoryManagement
 * @author    De B.A.A.T. <wp-mcm@de-baat.nl>
 * @license   GPL-3.0+
 * @link      https://www.de-baat.nl/WP_MCM
 * @copyright 2014 - 2016 De B.A.A.T.
 */

/**
 * WP_MCM_Plugin class.
 *
 * @package   WP_MCM_Plugin
 * @author    De B.A.A.T. <wp-mcm@de-baat.nl>
 */
class WP_MCM_Plugin {

	/**
	 * Unique identifier for your plugin.
	 *
	 * Use this value (not the variable name) as the text domain when internationalizing strings of text. It should
	 * match the Text Domain file header in the main plugin file.
	 *
	 * @since    0.1.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'wp-mcm';
	protected $plugin_icon = '';

	/**
	 * Instance of this class.
	 *
	 * @since    0.1.0
	 *
	 * @var      object
	 */
	protected static $instance = null;

	static $options = null;

	// Some local variables
	var $page_title, $menu_title, $capability, $menu_slug;


	/**
	 * Variable to hold the shortcode attributes for global processing
	 *
	 * @since    1.9.0
	 *
	 * @var      array
	 */
	var $mcm_shortcode_attributes = '';

	/**
	 * Initialize the plugin by setting localization, filters, and administration functions.
	 *
	 * @since     0.1.0
	 */
	private function __construct() {

		// Set some variables
		$this->page_title = 'WP MCM';
		$this->menu_title = 'WP MCM';
		$this->capability = 'edit_theme_options';
		$this->menu_slug = 'wp-mcm';
		$this->plugin_icon = 'dashicons-list-view';
		$this->debugMP('pr',__FUNCTION__ . ' this->menu_slug = ', $this->menu_slug);
		$this->debugMP('pr',__FUNCTION__ . ' this->plugin_slug = ', $this->plugin_slug);

		// Load plugin text domain
		add_action( 'init',						array( $this, 'mcm_init' ) );
		add_action( 'dmp_addpanel',				array( $this, 'create_DMPPanels') );

		// Add the options page and menu item.
		add_action( 'admin_menu',				array( $this, 'add_plugin_admin_menu' ) );
		add_action( 'admin_init',				array( $this, 'mcm_admin_init' ) );
		add_action( 'admin_init',				array( $this, 'plugin_page_init' ) );

		// Load admin style sheet and scripts.
		add_action( 'admin_enqueue_scripts',	array( $this, 'enqueue_admin_styles' ) );
		add_action( 'admin_enqueue_scripts',	array( $this, 'mcm_enqueue_media_action' ) );

		// Manage columns for attachments
		add_filter('manage_taxonomies_for_attachment_columns',	array($this,'mcm_filter_media_taxonomy_columns'), 10, 2);

		// Some filters and action to process categories
		add_filter('attachment_fields_to_edit',                 array($this,'mcm_attachment_fields_to_edit'    ), 10, 2);
//		add_filter('attachment_fields_to_save',                 array($this,'mcm_attachment_fields_to_save'    ), 10, 2);
		add_action('wp_ajax_save-attachment-compat',            array($this,'mcm_save_attachment_compat'       ), 0    );
		add_filter('request',                                   array($this,'mcm_request'                      )       );
		add_filter('pre_get_posts',                             array($this,'mcm_pre_get_posts'                )       );
		add_filter('plugin_action_links_' . WP_MCM_PLUGIN_FILE, array($this,'mcm_plugin_action_links'          ), 10, 4);
		add_filter('wp_get_attachment_link',                    array($this,'mcm_wp_get_attachment_link'       ), 10, 6);

	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     0.1.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function mcm_init() {
		load_plugin_textdomain( 'wp-media-category-management', FALSE, WP_MCM_BASENAME . '/lang/' );
		$this->debugMP('msg', __FUNCTION__ . ' ' . WP_MCM_BASENAME . '/lang/');

		// Configure some settings
		$this->mcm_register_media_taxonomy();

		$wp_mcm_options = get_option(WP_MCM_OPTIONS_NAME);
		$this->debugMP('pr', __FUNCTION__ . ' AFTER ' . WP_MCM_BASENAME . '/lang/; wp_mcm_options = ', $wp_mcm_options);

	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.0
	 */
	public function mcm_admin_init() {
		load_plugin_textdomain( 'wp-media-category-management', FALSE, WP_MCM_BASENAME . '/lang/' );
		$this->debugMP('msg', __FUNCTION__ . ' ' . WP_MCM_BASENAME . '/lang/' . ' for MCM V' . mcm_get_option('wp_mcm_version'));

		// Check whether to update options or not
		if (mcm_get_option('wp_mcm_version') != WP_MCM_VERSION) {
			mcm_init_option_defaults();
		}

		// Configure some settings
		$this->mcm_change_category_update_count_callback();


		$wp_mcm_options = get_option(WP_MCM_OPTIONS_NAME);
		$this->debugMP('pr', __FUNCTION__ . ' AFTER ' . WP_MCM_BASENAME . '/lang/; wp_mcm_options = ', $wp_mcm_options);
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.1.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public static function activate( $network_wide ) {
		// Create a default set of options
		mcm_init_option_defaults();
	}

	/**
	 * Add the settings link to the list of plugin actions.
	 *
	 * @since    1.7.0
	 *
	 * @param array  $action_links An array of plugin action links.
	 * @param string $plugin_file  Path to the plugin file.
	 * @param array  $plugin_data  An array of plugin data.
	 * @param string $context      The plugin context. Defaults are 'All', 'Active',
	 *                             'Inactive', 'Recently Activated', 'Upgrade',
	 *                             'Must-Use', 'Drop-ins', 'Search'.
	 */
	public function mcm_plugin_action_links( $action_links, $plugin_file, $plugin_data, $context ) {

//		$this->debugMP('msg', __FUNCTION__);
//		$this->debugMP('msg','', ' WP_MCM_DIR = ' . WP_MCM_DIR . ', WP_MCM_BASENAME = ' . WP_MCM_BASENAME . ', plugin_data = ');
//		$this->debugMP('pr', '', $plugin_data);
//		$this->debugMP('msg','', ' WP_MCM_BASENAME = ' . WP_MCM_BASENAME . ', WP_MCM_FILENAME = ' . WP_MCM_FILENAME);
//		$this->debugMP('msg','', ' WP_MCM_PLUGIN_FILE = ' . WP_MCM_PLUGIN_FILE . ', plugin_file, context, action_links = ');
//		$this->debugMP('pr', '', $plugin_file);
//		$this->debugMP('pr', '', $context);
//		$this->debugMP('pr', '', $action_links);

		$action_links[] = '<a href="' . esc_url( $this->get_page_url() ) . '">'.esc_html__( 'Settings' , 'wp-media-category-management').'</a>';

		return $action_links;

	}

	/**
	 * Retrieve an attachment page link using an image or icon, if possible.
	 *
	 * @return string HTML content.
	 */
	public function mcm_wp_get_attachment_link( $html = '', $id = 0, $size = 'thumbnail', $permalink = false, $icon = false, $text = false ) {

		$mcm_html = $html;

		// Check shortcode_attribute show_category_link
		$mcm_show_category_link = '';
		if ( isset($this->mcm_shortcode_attributes['show_category_link'])) {
			$mcm_show_category_link = $this->mcm_shortcode_attributes['show_category_link'];
		}
		if ($mcm_show_category_link == '') {
			// If not link required, then just return the html received
			return $mcm_html;
		}

		// Check $media_taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
		$terms = wp_get_object_terms($id, $media_taxonomy);

		// Get the category_link for each taxonomy term found
		foreach ( $terms as $term ) {
			$this->debugMP('pr', __FUNCTION__ . ' post[' . $id . '][' . $media_taxonomy . '] term =', $term);
			$category_link = get_category_link( $term->term_taxonomy_id );
			$this->debugMP('msg','', __FUNCTION__ . ' term->term_taxonomy_id = ' . $term->term_taxonomy_id . ', category_link = ' . $category_link);

			// Add the category_link to the mcm_html
			$mcm_html .= '<a href="' . esc_url( $category_link ) . '">' . $term->name . '</a>';

			// Add an optional separation element, default is a space
			switch (strtoupper($mcm_show_category_link)) {
				case 'BR':
				case 'NL':
					$mcm_html .= '<br>';
					break;
				case ' ':
				default:
					$mcm_html .= ' ';
					break;
			}
		}

		return $mcm_html;
	}


	/**
	 * Get the page_url for the settings page of this plugin.
	 *
	 * @since    1.7.0
	 *
	 * @param string $page
	 */
	public function get_page_url( $page = 'config' ) {

//		$this->debugMP('msg', __FUNCTION__ . ': menu_page_url(' . $this->menu_slug . ', false) = ' . menu_page_url($this->menu_slug, false) );
		$url = menu_page_url($this->menu_slug, false);

		return $url;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.1.0
	 *
	 * @param    WP_Query    $query    The query object used to find objects like posts
	 */
	function mcm_pre_get_posts( $query ) {

		global $wp_query;
		//$this->debugMP('pr',__FUNCTION__ . ' is_search() = ' . is_search() . ', is_archive() = ' . is_archive() . ', wp_query = ', $wp_query);

		// Check search_media_library for search when desired
		if ( ! mcm_get_option_bool('wp_mcm_search_media_library')) {
			return;
		}

		// Only perform search on non-admin pages
		if (is_admin()) {
			return;
		}

		// Check whether this is the main query
		if ($query->is_main_query()) {

			// Handle query if it is used for media is_archive
			if (is_archive()) {

				// Get media taxonomy and categories to find
				$media_taxonomy   = mcm_get_media_taxonomy();
				$media_categories = $query->get( $media_taxonomy, '__not_found' );

				// Check categories to find
				if ($media_categories != '__not_found') {
					$query->set( 'post_type',   'attachment');
					$query->set( 'post_status', 'inherit');
				} else {
					// Add media for post categories when desired
					if (is_category() && mcm_get_option_bool('wp_mcm_use_post_taxonomy')) {
						$query->set( 'post_type',   array('post',    'attachment'));
						$query->set( 'post_status', array('publish', 'inherit'));
					}
				}

			}

			// Add media for search when desired
			if (is_search() && mcm_get_option_bool('wp_mcm_search_media_library')) {

				// Add attachment to post_type
				$query_post_type = $query->get( 'post_type', '__not_found' );
				if ($query_post_type == '__not_found') {
					$query_post_type = 'post';
				}
				$query_post_type = mcm_query_vars_add_values($query_post_type, 'attachment');
				$query->set( 'post_type', $query_post_type);

				// Add inherit to post_status
				$query_post_status = $query->get( 'post_status', '__not_found' );
				if ($query_post_status == '__not_found') {
					$query_post_status = 'publish';
				}
				$query_post_status = mcm_query_vars_add_values($query_post_status, 'inherit');
				$query->set( 'post_status', $query_post_status);
			}

		}

	}

	/** register taxonomy for attachments */
	function mcm_register_media_taxonomy() {

		// Get media taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
		$this->debugMP('msg',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy);

		// Register WP_MCM_MEDIA_TAXONOMY
		$use_media_taxonomy = $media_taxonomy == WP_MCM_MEDIA_TAXONOMY;
		$args = array(
			'hierarchical'			=> true,  // hierarchical: true = display as categories, false = display as tags
			'show_ui'				=> $use_media_taxonomy,
			'show_admin_column'		=> $use_media_taxonomy,
			'public'				=> $use_media_taxonomy,
			'show_in_nav_menus'		=> $use_media_taxonomy,
			'query_var'				=> true,
//			'rewrite'				=> array( 'slug' => WP_MCM_MEDIA_TAXONOMY, 'ep_mask' => EP_ALL ),
			'update_count_callback'	=> 'mcm_update_count_callback',
			'labels' => array(
				'name'				=> __('MCM Categories', 'wp-media-category-management'),
				'singular_name'		=> __('MCM Category', 'wp-media-category-management'),
				'menu_name'			=> __('MCM Categories', 'wp-media-category-management'),
				'all_items'			=> __('All MCM Categories', 'wp-media-category-management'),
				'edit_item'			=> __('Edit MCM Category', 'wp-media-category-management'),
				'view_item'			=> __('View MCM Category', 'wp-media-category-management'),
				'update_item'		=> __('Update MCM Category', 'wp-media-category-management'),
				'add_new_item'		=> __('Add New MCM Category', 'wp-media-category-management'),
				'new_item_name'		=> __('New MCM Category Name', 'wp-media-category-management'),
				'parent_item'		=> __('Parent MCM Category', 'wp-media-category-management'),
				'parent_item_colon'	=> __('Parent MCM Category:', 'wp-media-category-management'),
				'search_items'		=> __('Search MCM Categories', 'wp-media-category-management'),
			),
		);
		register_taxonomy( WP_MCM_MEDIA_TAXONOMY, array( 'attachment' ), $args );

		// Handle a taxonomy which may have been used previously by another plugin
		$wp_mcm_media_taxonomy_to_use = mcm_get_option('wp_mcm_media_taxonomy_to_use');
		if ( ($wp_mcm_media_taxonomy_to_use != WP_MCM_MEDIA_TAXONOMY) &&
			 ($wp_mcm_media_taxonomy_to_use != WP_MCM_POST_TAXONOMY) &&
			 (! taxonomy_exists($wp_mcm_media_taxonomy_to_use))) {
			// Create a nice name for the Custom MCM Taxonomy
			$wp_mcm_custom_taxonomy_name = mcm_get_option('wp_mcm_custom_taxonomy_name');
			if ($wp_mcm_custom_taxonomy_name == '') {
				$wp_mcm_custom_taxonomy_name = __('Custom MCM Categories', 'wp-media-category-management');
			}
			$wp_mcm_custom_taxonomy_name_single = mcm_get_option('wp_mcm_custom_taxonomy_name_single');
			if ($wp_mcm_custom_taxonomy_name_single == '') {
				$wp_mcm_custom_taxonomy_name_single = __('Custom MCM Category', 'wp-media-category-management');
			}
			// Register custom taxonomy to use
			$args = array(
				'hierarchical'			=> true,  // hierarchical: true = display as categories, false = display as tags
				'show_ui'				=> true,
				'show_admin_column'		=> true,
				'public'				=> true,
				'show_in_nav_menus'		=> true,
				'rewrite'				=> array( 'slug' => $wp_mcm_media_taxonomy_to_use ),
				'update_count_callback'	=> 'mcm_update_count_callback',
				'labels' => array(
					'name'				=> '(*) ' . $wp_mcm_custom_taxonomy_name,
					'singular_name'		=> $wp_mcm_custom_taxonomy_name_single,
					'menu_name'			=> $wp_mcm_custom_taxonomy_name,
					'all_items'			=> __('All',     'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name,
					'edit_item'			=> __('Edit',    'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name_single,
					'view_item'			=> __('View',    'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name_single,
					'update_item'		=> __('Update',  'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name_single,
					'add_new_item'		=> __('Add New', 'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name_single,
					'new_item_name'		=> sprintf(__('New %s Name', 'wp-media-category-management'), $wp_mcm_custom_taxonomy_name_single),
					'parent_item'		=> __('Parent',  'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name_single,
					'parent_item_colon'	=> __('Parent',  'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name_single . ':',
					'search_items'		=> __('Search',  'wp-media-category-management') . ' ' . $wp_mcm_custom_taxonomy_name,
				),
			);
			register_taxonomy( $wp_mcm_media_taxonomy_to_use, array( 'attachment' ), $args );
		}

		// Register WP_MCM_POST_TAXONOMY for attachments only if explicitly desired
		if ((mcm_get_option_bool('wp_mcm_use_post_taxonomy')) ||
			 ($wp_mcm_media_taxonomy_to_use == WP_MCM_POST_TAXONOMY)) {
			$this->mcm_set_media_taxonomy_settings();
			register_taxonomy_for_object_type( WP_MCM_POST_TAXONOMY, 'attachment' );
		}

		// Register WP_MCM_TAGS_TAXONOMY for attachments only if explicitly desired
		if ($wp_mcm_media_taxonomy_to_use == WP_MCM_TAGS_TAXONOMY) {
			//$this->mcm_set_media_taxonomy_settings();
			register_taxonomy_for_object_type( WP_MCM_TAGS_TAXONOMY, 'attachment' );
		}

		// Flush rewrite when necessary, e.g. when the definition of post_types changed
		flush_rewrite_rules();
	}

	/** Check whether this search is for NO Category */
	function mcm_get_no_category_search() {

		$searchCategory = '';

		// Check for correct Filter situation
		if ((!isset($_REQUEST['filter_action'])) || empty( $_REQUEST['filter_action'] )) {
			$this->debugMP('msg',__FUNCTION__ . ' Invalid request: No filter action. ');
			return $searchCategory;
		}

		// Check parameters to use for new request
		if ( isset( $_REQUEST['bulk_tax_cat'] ) ) {
			$searchCategory = $_REQUEST['bulk_tax_cat'];

			// Get the request value to check for WP_MCM_OPTION_NO_CAT
			$searchCategoryRequest = '';
			if ( isset( $_REQUEST[$searchCategory] ) ) {
				$searchCategoryRequest = $_REQUEST[$searchCategory];
			} else {
				if ( ($_REQUEST['bulk_tax_cat'] == WP_MCM_POST_TAXONOMY) && isset( $_REQUEST['cat'] ) ) {
					$searchCategoryRequest = $_REQUEST['cat'];
				}
			}

			// Filter request on specific category so don't mess with it
			if ($searchCategoryRequest == WP_MCM_OPTION_NO_CAT) {
				$this->debugMP('msg',__FUNCTION__ . ' Searching for NO Category for searchCategory: ' . $searchCategory);
				return $searchCategory;
			}
		}

		return '';
	}

	/** Implement the request to filter media without category */
	function mcm_request($query_args) {
//		$this->debugMP('pr', __FUNCTION__ . ' query = ', $query_args);

		// Get media taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
		$this->debugMP('pr',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy . ' query_args = ', $query_args);

		$mediaCategory = $this->mcm_get_no_category_search();
		if ($mediaCategory != '') {
			// Fix the search settings to search for NO Category
			$this->debugMP('msg',__FUNCTION__ . ' Valid request: Filter on not part of category: ' . $mediaCategory);

			// Find all posts for the current mediaCategory to use for filtering them out
			$all_attachments = mcm_get_posts_for_media_taxonomy($mediaCategory);
			$post_not_in = array();
			foreach ($all_attachments as $key => $val) {
				$post_not_in[] = $val->ID;
			}
			$query_args['post__not_in'] = $post_not_in;
			$this->debugMP('pr', __FUNCTION__ . ' post_not_in = ', $post_not_in);

			// Reset the search query parameters to search for all attachments
			$query_args[$mediaCategory] = 0;
		} else {
			// Check for filtering tags
			if ($media_taxonomy == WP_MCM_TAGS_TAXONOMY) {
				// Fix the search settings to search for NO Category
				if ( isset( $_REQUEST[WP_MCM_TAGS_TAXONOMY] ) && ( $_REQUEST[WP_MCM_TAGS_TAXONOMY] != WP_MCM_OPTION_ALL_CAT) ) {
					$query_args['tag'] = $_REQUEST[WP_MCM_TAGS_TAXONOMY];
				}
				$this->debugMP('pr',__FUNCTION__ . ' Reworked query_args for tags to: ', $query_args);
			}
		}

		return $query_args;

	}

	/** Filter the columns shown depending on taxonomy choosen */
	function mcm_filter_media_taxonomy_columns( $columns, $post_type ) {

		// Get media taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
		$this->debugMP('pr',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy . ' columns = ', $columns);

		// Find the columns to show
		$filtered = array();
		foreach ($columns as $key => $value) {
			// Add column for MCM Category
			if ($value == $media_taxonomy) {
				$filtered[] = $value;
			} elseif (($value == WP_MCM_POST_TAXONOMY) && (mcm_get_option_bool('wp_mcm_use_post_taxonomy'))) {
				// Add column for WP_MCM_POST_TAXONOMY
				$filtered[] = $value;
			}
		}

		return $filtered;
	}

	/** Filter the columns shown depending on taxonomy choosen */
	function mcm_attachment_fields_to_edit( $form_fields, $post ) {

		$this->debugMP('pr',__FUNCTION__ . ' form_fields = ', $form_fields);
		$this->debugMP('pr',__FUNCTION__ . ' post = ', $post);
//		return $form_fields;

		foreach ( get_attachment_taxonomies($post->ID) as $taxonomy ) {

			$t = (array) get_taxonomy($taxonomy);
			if ( ! $t['public'] || ! $t['show_ui'] ) {
				continue;
			}
			if ( empty($t['label']) ) {
				$t['label'] = $taxonomy;
			}
			if ( empty($t['args']) ) {
				$t['args'] = array();
			}

			$terms = get_object_term_cache( $post->ID, $taxonomy );
			if ( false === $terms ) {
				$terms = wp_get_object_terms($post->ID, $taxonomy, $t['args']);
			}

			// Get the values in a list
			$values = array();
			foreach ( $terms as $term ) {
				$values[] = $term->slug;
			}
			$t['value'] = join(', ', $values);

			$t['show_in_edit'] = false;

			if ( ( $t['hierarchical'] ) || ( $taxonomy == WP_MCM_TAGS_TAXONOMY ) ) {
				ob_start();

					wp_terms_checklist( $post->ID,
										array( 'taxonomy' => $taxonomy,
												'checked_ontop' => false,
												'walker' => new mcm_walker_category_mediagrid_checklist()
											)
						);

					if ( ob_get_contents() != false ) {
						$html = '<ul class="term-list">' . ob_get_contents() . '</ul>';
					} else {
						$html = '<ul class="term-list"><li>No ' . $t['label'] . '</li></ul>';
					}

				ob_end_clean();

				$t['input'] = 'html';
				$t['html'] = $html; 
			}

			$form_fields[$taxonomy] = $t;
		}

		return $form_fields;

	}

	// Save tag field from attachment edit menu
	function mcm_attachment_fields_to_save($post, $attachment) {
		$tags = esc_attr($_POST['attachments'][$post['ID']]['tags']);

		$tag_arr = explode(',', $tags);
		wp_set_object_terms( $post['ID'], $tag_arr, 'post_tag' );
		return $post;
	}

	/** 
	 *  mcm_save_attachment_compat
	 *
	 *  Based on /wp-admin/includes/ajax-actions.php
	 *
	 *  @since    1.3.0
	 *  @created  12/11/14
	 */
	function mcm_save_attachment_compat() {	
		if ( ! isset( $_REQUEST['id'] ) ) {
			wp_send_json_error();
		}

		if ( ! $id = absint( $_REQUEST['id'] ) ) {
			wp_send_json_error();
		}

		if ( empty( $_REQUEST['attachments'] ) || empty( $_REQUEST['attachments'][ $id ] ) ) {
			wp_send_json_error();
		}
		$attachment_data = $_REQUEST['attachments'][ $id ];

		check_ajax_referer( 'update-post_' . $id, 'nonce' );

		if ( ! current_user_can( 'edit_post', $id ) ) {
			wp_send_json_error();
		}

		$post = get_post( $id, ARRAY_A );

		if ( 'attachment' != $post['post_type'] ) {
			wp_send_json_error();
		}

		/** This filter is documented in wp-admin/includes/media.php */
		$post = apply_filters( 'attachment_fields_to_save', $post, $attachment_data );

		if ( isset( $post['errors'] ) ) {
			$errors = $post['errors']; // @todo return me and display me!
			unset( $post['errors'] );
		}

		wp_update_post( $post );

		foreach ( get_attachment_taxonomies( $post ) as $taxonomy ) 
		{		
			if ( isset( $attachment_data[ $taxonomy ] ) ) {
				wp_set_object_terms( $id, array_map( 'trim', preg_split( '/,+/', $attachment_data[ $taxonomy ] ) ), $taxonomy, false );
			} elseif ( isset($_REQUEST['tax_input']) && isset( $_REQUEST['tax_input'][ $taxonomy ] ) ) {
				wp_set_object_terms( $id, $_REQUEST['tax_input'][ $taxonomy ], $taxonomy, false );
			} else {
				wp_set_object_terms( $id, '', $taxonomy, false );
			}
		}

		if ( ! $attachment = wp_prepare_attachment_for_js( $id ) ) {
			wp_send_json_error();
		}

		wp_send_json_success( $attachment );
	}

	/** change the settings for category taxonomy depending on taxonomy choosen */
	function mcm_set_media_taxonomy_settings() {

		// Get the post_ID and the corresponding post_type
		if ( isset( $_GET['post'] ) ) {
			$post_id = $post_ID = (int) $_GET['post'];
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $post_ID = (int) $_POST['post_ID'];
		} else {
			$post_id = $post_ID = 0;
		}
		$post_type = get_post_type($post_id);
		$this->debugMP('msg',__FUNCTION__ . ' post_type = ' . $post_type);

		// Only limit post taxonomy for attachments
		if ( ($post_type == 'attachment') || ($post_id == 0) ) {

			// get the arguments of the already-registered taxonomy
			$category_args = get_taxonomy( WP_MCM_POST_TAXONOMY ); // returns an object

			// make changes to the args
			// again, note that it's an object
			$wp_mcm_media_taxonomy_to_use = mcm_get_option('wp_mcm_media_taxonomy_to_use');
			$use_post_taxonomy = ((mcm_get_option_bool('wp_mcm_use_post_taxonomy')) || ($wp_mcm_media_taxonomy_to_use == WP_MCM_POST_TAXONOMY));
			$category_args->show_ui = $use_post_taxonomy;
			$category_args->show_admin_column = $use_post_taxonomy;

			// re-register the taxonomy
			register_taxonomy( WP_MCM_POST_TAXONOMY, 'post', (array) $category_args );

		}

	}

	/** change default update_count_callback for category and tags taxonomies */
	function mcm_change_category_update_count_callback() {
		global $wp_taxonomies;


		// Get media taxonomy
		$media_taxonomy = mcm_get_media_taxonomy();
		$this->debugMP('msg',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy);

		// Reset count_callback for WP_MCM_POST_TAXONOMY
		if ( $media_taxonomy == WP_MCM_POST_TAXONOMY ) {
			if ( taxonomy_exists( WP_MCM_POST_TAXONOMY ) ) {
				$new_arg = &$wp_taxonomies[WP_MCM_POST_TAXONOMY]->update_count_callback;
				$new_arg = 'mcm_update_count_callback';
			}
		}

		// Reset count_callback for WP_MCM_TAGS_TAXONOMY
		if ( $media_taxonomy == WP_MCM_TAGS_TAXONOMY ) {
			if ( taxonomy_exists( WP_MCM_TAGS_TAXONOMY ) ) {
				$new_arg = &$wp_taxonomies[WP_MCM_TAGS_TAXONOMY]->update_count_callback;
				$new_arg = 'mcm_update_count_callback';
			}
		}
	}

	/** Enqueue admin scripts and styles */
	function mcm_enqueue_media_action() {
		global $pagenow;
		$this->debugMP('msg',__FUNCTION__ . ' pagenow = ' . $pagenow . ', wp_script_is( media-editor ) = ' . wp_script_is( 'media-editor' ));

		// Enqueue the media scripts always, not only on post pages.
		//if ( wp_script_is( 'media-editor' ) && (('upload.php' == $pagenow ) || ('post.php' == $pagenow ) || ('post-new.php' == $pagenow ) )) {
		if (true) {


			// Get media taxonomy
			$media_taxonomy = mcm_get_media_taxonomy();
			$this->debugMP('msg',__FUNCTION__ . ' taxonomy = ' . $media_taxonomy);

			// Only show_count when no Post or Tag taxonomy
			if (( $media_taxonomy == WP_MCM_POST_TAXONOMY ) || ( $media_taxonomy == WP_MCM_TAGS_TAXONOMY )) {
				$show_count = false;
			} else {
				$show_count = true;
			}
			$dropdown_options = array(
				'taxonomy'        => $media_taxonomy,
				'hide_empty'      => false,
				'hierarchical'    => true,
				'orderby'         => 'name',
				'show_count'      => $show_count,
				'walker'          => new mcm_walker_category_mediagridfilter(),
				'value'           => 'id',
				'echo'            => false
			);
			$attachment_terms = wp_dropdown_categories( $dropdown_options );
			$attachment_terms = preg_replace( array( "/<select([^>]*)>/", "/<\/select>/" ), "", $attachment_terms );

			// Add an attachment_terms for No category
			$mcm_label     = mcm_get_media_category_label($media_taxonomy);
			$mcm_label_all = __( 'View all', 'wp-media-category-management' ) . ' ' . $mcm_label;
			$mcm_label_no  = __( 'No',       'wp-media-category-management' ) . ' ' . $mcm_label;
			$no_category_term = ' ,{"term_id":"' . WP_MCM_OPTION_NO_CAT . '","term_name":"' . $mcm_label_no . '"}';
			$attachment_terms = $no_category_term . substr( $attachment_terms, 1 );
			$this->debugMP('msg',__FUNCTION__ . ' attachment_terms = !' . $attachment_terms . '!');

			echo '<script type="text/javascript">';
			echo '/* <![CDATA[ */';
			echo 'var mcm_taxonomies = {"' . $media_taxonomy . '":';
			echo     '{"list_title":"' . html_entity_decode( $mcm_label_all, ENT_QUOTES, 'UTF-8' ) . '",';
			echo       '"term_list":[' . substr( $attachment_terms, 2 ) . ']}};';
			echo '/* ]]> */';
			echo '</script>';

			wp_enqueue_script( 'mcm-media-views', WP_MCM_URL . '/js/wp-mcm-media-views.js', array( 'media-views' ), WP_MCM_VERSION, true );
		}
	}

	/**
	 * Register and enqueue admin-specific style sheet.
	 *
	 * @since     0.1.0
	 *
	 * @return    null    Return early if no admin page is registered.
	 */
	public function enqueue_admin_styles() {

		wp_enqueue_style( $this->plugin_slug .'-admin-styles', WP_MCM_URL . '/css/admin.css', array(), WP_MCM_VERSION );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    0.1.0
	 */
	public function add_plugin_admin_menu() {
		$this->debugMP('msg',__FUNCTION__ . ' Count(menuItems)=' . '...');

		if (current_user_can($this->capability)) {
			do_action('mcm_admin_menu_starting');

			// The main hook for the menu
			//
			add_menu_page(
				$this->page_title,
				$this->menu_title,
				$this->capability,
				$this->plugin_slug,
				array($this,'display_plugin_admin_page'),
				$this->plugin_icon
			);

			// Default menu items
			//
			$menuItems = array(
				array(
					'label'             => __('MCM Settings', 'wp-media-category-management'),
					'slug'              => $this->plugin_slug,
					'class'             => $this,
					'function'          => 'display_plugin_admin_page'
				)
			);

			// Get all additional menu items
			$menuItems = apply_filters('add_wp_mcm_menu_items', $menuItems);

			// Check the number of submenu_pages to add
			$this->debugMP('msg',__FUNCTION__ . ' Count(menuItems)=' . count($menuItems) . '...');
			$this->debugMP('pr',__FUNCTION__ . ' menuItems',$menuItems);

			// Attach Menu Items To Sidebar and Top Nav
			//
			foreach ($menuItems as $menuItem) {

				// Using class names (or objects)
				//
				if (isset($menuItem['class'])) {
					add_submenu_page(
						$this->plugin_slug,
						$menuItem['label'],
						$menuItem['label'],
						$this->capability,
						$menuItem['slug'],
						array($menuItem['class'],$menuItem['function'])
						);

				// Full URL or plain function name
				//
				} else {
					add_submenu_page(
						$this->plugin_slug,
						$menuItem['label'],
						$menuItem['label'],
						$this->capability,
						$menuItem['url']
						);
				}
			}

		}
	}

	/**
	 * Init the admin page for this plugin.
	 *
	 * @since    0.1.0
	 */
	public function plugin_page_init() {
		$this->debugMP('msg',__FUNCTION__ . ' ' . WP_MCM_BASENAME . '/lang/');
		register_setting( 'wp_mcm_option_group', WP_MCM_OPTIONS_NAME, array( $this, 'check_wp_mcm_option' ) );

		add_settings_section(
			'wp_mcm_section_id',
			__('Set your settings below:', 'wp-media-category-management'),
			array( $this, 'print_general_section_info' ),
			'wp-mcm-setting-admin'
		);

		add_settings_field(
			'wp_mcm_toggle_assign',
			__('Toggle Assign', 'wp-media-category-management'), 
			array( $this, 'create_wp_mcm_toggle_assign_field' ), 
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_toggle_assign', 'field' => 'wp_mcm_toggle_assign' )
		);

//		add_settings_field(
//			'wp_mcm_debug',
//			__('Debug info', 'wp-media-category-management'),
//			array( $this, 'create_wp_mcm_debug_field' ),
//			'wp-mcm-setting-admin',
//			'wp_mcm_section_id',
//			array( 'label_for' => 'wp_mcm_debug', 'field' => 'wp_mcm_debug' )
//		);

		add_settings_field(
			'wp_mcm_media_taxonomy_to_use',
			__('Media Taxonomy To Use', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_media_taxonomy_to_use_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_media_taxonomy_to_use', 'field' => 'wp_mcm_media_taxonomy_to_use' )
		);

		add_settings_field(
			'wp_mcm_custom_taxonomy_name',
			__('Name for Custom MCM Taxonomy', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_custom_taxonomy_name_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_custom_taxonomy_name', 'field' => 'wp_mcm_custom_taxonomy_name' )
		);

		add_settings_field(
			'wp_mcm_custom_taxonomy_name_single',
			__('Custom Singular Name', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_custom_taxonomy_name_single_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_custom_taxonomy_name_single', 'field' => 'wp_mcm_custom_taxonomy_name_single' )
		);

		add_settings_field(
			'wp_mcm_use_default_category',
			__('Use Default Category', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_use_default_category_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_use_default_category', 'field' => 'wp_mcm_use_default_category' )
		);

		add_settings_field(
			'wp_mcm_default_media_category',
			__('Default Media Category', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_default_media_category_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_default_media_category', 'field' => 'wp_mcm_default_media_category' )
		);

		add_settings_field(
			'wp_mcm_use_post_taxonomy',
			__('Use Post Taxonomy', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_use_post_taxonomy_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_use_post_taxonomy', 'field' => 'wp_mcm_use_post_taxonomy' )
		);

		add_settings_field(
			'wp_mcm_search_media_library',
			__('Search Media Library', 'wp-media-category-management'),
			array( $this, 'create_wp_mcm_search_media_library_field' ),
			'wp-mcm-setting-admin',
			'wp_mcm_section_id',
			array( 'label_for' => 'wp_mcm_search_media_library', 'field' => 'wp_mcm_search_media_library' )
		);

//		add_settings_field(
//			'wp_mcm_default_post_category',
//			__('Default Post Category', 'wp-media-category-management'),
//			array( $this, 'create_wp_mcm_default_post_category_field' ),
//			'wp-mcm-setting-admin',
//			'wp_mcm_section_id',
//			array( 'label_for' => 'wp_mcm_default_post_category', 'field' => 'wp_mcm_default_post_category' )
//		);

//		add_settings_field(
//			'wp_mcm_default_custom_media_category',
//			__('Default Custom Media Category', 'wp-media-category-management'),
//			array( $this, 'create_wp_mcm_default_custom_media_category_field' ),
//			'wp-mcm-setting-admin',
//			'wp_mcm_section_id',
//			array( 'label_for' => 'wp_mcm_default_custom_media_category', 'field' => 'wp_mcm_default_custom_media_category' )
//		);

	}

	function check_wp_mcm_option_checkbox($input = array(), $key = '') {
		if ( $key == '' ) {
			return 0;
		}
		if ( ! array($input)) {
			return 0;
		}
		if ( ! isset($input[$key])) {
			return 0;
		}
		return trim($input[$key]);
	}

	function check_wp_mcm_option($input) {

		$newinput = array();

		// Always set the current version
		$newinput['wp_mcm_version'] = WP_MCM_VERSION;

		// Check value of wp_mcm_toggle_assign
		$newinput['wp_mcm_toggle_assign'] = $this->check_wp_mcm_option_checkbox($input,'wp_mcm_toggle_assign');

		// Check value of wp_mcm_media_taxonomy_to_use
		$newinput['wp_mcm_media_taxonomy_to_use'] = sanitize_key(trim($input['wp_mcm_media_taxonomy_to_use']));

		// Check value of wp_mcm_custom_taxonomy_name
		$newinput['wp_mcm_custom_taxonomy_name'] = trim($input['wp_mcm_custom_taxonomy_name']);
		$newinput['wp_mcm_custom_taxonomy_name_single'] = trim($input['wp_mcm_custom_taxonomy_name_single']);

		// Check value of wp_mcm_use_post_taxonomy
		$newinput['wp_mcm_use_post_taxonomy']    = $this->check_wp_mcm_option_checkbox($input,'wp_mcm_use_post_taxonomy');
		$newinput['wp_mcm_use_default_category'] = $this->check_wp_mcm_option_checkbox($input,'wp_mcm_use_default_category');

		// Check value of wp_mcm_search_media_library
		$newinput['wp_mcm_search_media_library'] = $this->check_wp_mcm_option_checkbox($input,'wp_mcm_search_media_library');

		// Check value of wp_mcm_default_media_category
		// If Media Taxonomy To Use changed, reset Default Media Category
		if ($newinput['wp_mcm_media_taxonomy_to_use'] != mcm_get_option('wp_mcm_media_taxonomy_to_use')) {
			$newinput['wp_mcm_default_media_category'] = WP_MCM_OPTION_NONE;
		} else {
			$newinput['wp_mcm_default_media_category'] = sanitize_key(trim($input['wp_mcm_default_media_category']));
		}
//		$newinput['wp_mcm_default_post_category']  = sanitize_key(trim($input['wp_mcm_default_post_category']));
//		$newinput['wp_mcm_default_custom_media_category'] = sanitize_key(trim($input['wp_mcm_default_custom_media_category']));

		$newinput['wp_mcm_debug'] = 'OPTION wp_mcm_media_taxonomy_to_use: ' . mcm_get_option('wp_mcm_media_taxonomy_to_use')
				. ' \n '
				. 'wp_mcm_media_taxonomy_to_use: ' . sanitize_key(trim($input['wp_mcm_media_taxonomy_to_use']))
				. ' \n '
				. 'wp_mcm_default_media_category: ' . sanitize_key(trim($input['wp_mcm_default_media_category']))
				. ' '
				;
		$this->debugMP('pr',__FUNCTION__  . ' input used:', $input);
		$this->debugMP('pr',__FUNCTION__  . ' newinput found:', $newinput);
//		print_r(' input used:<br/>');
//		print_r($input);
//		print_r(' <br/>newinput found:<br/>');
//		print_r($newinput);
//wp_die();
		return $newinput;
	}

	public function print_general_section_info(){
//		print __('Set your settings below:', 'wp-media-category-management');
	}

	public function create_wp_mcm_toggle_assign_field(){
		$wp_mcm_toggle_assign = mcm_get_option('wp_mcm_toggle_assign');
		$wp_mcm_toggle_assign_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_toggle_assign]';
		?><input type="checkbox" id="input_wp_mcm_toggle_assign" name="<?php echo $wp_mcm_toggle_assign_name; ?>" value="1" <?php checked('1', $wp_mcm_toggle_assign);?> />
		<?php  echo __(' Show category toggles in list view?', 'wp-media-category-management');
	}

	public function create_wp_mcm_custom_taxonomy_name_field(){
		$wp_mcm_custom_taxonomy_name = mcm_get_option('wp_mcm_custom_taxonomy_name');
		$wp_mcm_custom_taxonomy_name_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_custom_taxonomy_name]';
		?><input type="text" id="input_wp_mcm_custom_taxonomy_name" name="<?php echo $wp_mcm_custom_taxonomy_name_name; ?>" value="<?php echo $wp_mcm_custom_taxonomy_name;?>" />
		<?php  echo __(' What text should be used as <strong>plural</strong> name for the Custom MCM Taxonomy?', 'wp-media-category-management');
	}

	public function create_wp_mcm_custom_taxonomy_name_single_field(){
		$wp_mcm_custom_taxonomy_name_single = mcm_get_option('wp_mcm_custom_taxonomy_name_single');
		$wp_mcm_custom_taxonomy_name_single_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_custom_taxonomy_name_single]';
		?><input type="text" id="input_wp_mcm_custom_taxonomy_name_single" name="<?php echo $wp_mcm_custom_taxonomy_name_single_name; ?>" value="<?php echo $wp_mcm_custom_taxonomy_name_single;?>" />
		<?php  echo __(' What text should be used as <strong>singular</strong> name for the Custom MCM Taxonomy?', 'wp-media-category-management');
	}

	public function create_wp_mcm_debug_field(){
		$wp_mcm_debug = mcm_get_option('wp_mcm_debug');
		$wp_mcm_debug_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_debug]';
		?><textarea cols="60" rows="4" id="input_wp_mcm_debug" name="<?php echo $wp_mcm_debug_name; ?>"><?php echo $wp_mcm_debug; ?></textarea>
		<?php  echo __(' Debug info.', 'wp-media-category-management');
	}

	public function create_wp_mcm_media_taxonomy_to_use_field(){
		$wp_mcm_media_taxonomy_to_use = mcm_get_option('wp_mcm_media_taxonomy_to_use');
		$wp_mcm_media_taxonomy_to_use_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_media_taxonomy_to_use]';

		// Get the $mediaTaxonomies available
		//$mediaTaxonomies = get_taxonomies( array( 'object_type' => array( 'attachment' ) ), 'objects' );
		$mediaTaxonomies = mcm_get_media_taxonomies();
		$this->debugMP('pr',__FUNCTION__  . ' mediaTaxonomies found:', $mediaTaxonomies);

		// Create the html dropdown
		$HTML  = "";
		if ($mediaTaxonomies) {

			$HTML .= "<select id='{$wp_mcm_media_taxonomy_to_use_name}' name='{$wp_mcm_media_taxonomy_to_use_name}' class='postform'>";

			// Create the dropdown list for each taxonomy found
			foreach ($mediaTaxonomies as $mediaTaxonomy) {
				$is_selected = ( $mediaTaxonomy['name'] === $wp_mcm_media_taxonomy_to_use ) ? 'selected' : '';
				$HTML .= "<option value='{$mediaTaxonomy['name']}' $is_selected>{$mediaTaxonomy['label']}</option>";
			}

			$HTML .= "</select>";
		} else {
			$HTML .= " " . __('Current value:', 'wp-media-category-management') . " <b>" . $wp_mcm_media_taxonomy_to_use . "</b> ";
		}

		$HTML .= '<span> ';
		$HTML .= __('Which taxonomy should be used to manage the media?', 'wp-media-category-management');
		$HTML .= '<br/>';
		$HTML .= ' ' . __('(P) means that the taxonomy is also used for posts.', 'wp-media-category-management');
		$HTML .= '<br/>';
		$HTML .= ' ' . __('(T) means that the taxonomy is also used as tags for posts.', 'wp-media-category-management');
		$HTML .= '<br/>';
		$HTML .= ' ' . __('(*) means that the taxonomy may have been registered previously, e.g. by another plugin.', 'wp-media-category-management');
		$HTML .= '<br/>';
		$HTML .= ' ' . __('[#<strong>X</strong>] means that the taxonomy is currently assigned to <strong>X</strong> attachments.', 'wp-media-category-management');
		$HTML .= '</span>';
		echo $HTML;
		return;

	}

	public function create_wp_mcm_use_default_category_field(){
		$wp_mcm_use_default_category = mcm_get_option('wp_mcm_use_default_category');
		$wp_mcm_use_default_category_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_use_default_category]';
		?><input type="checkbox" id="input_wp_mcm_use_default_category" name="<?php echo $wp_mcm_use_default_category_name; ?>" value="1" <?php checked('1', $wp_mcm_use_default_category);?> />
			<?php  echo __(' Use the default category when adding or editing an attachment?', 'wp-media-category-management');
	}

	public function create_wp_mcm_use_post_taxonomy_field(){
		$wp_mcm_use_post_taxonomy = mcm_get_option('wp_mcm_use_post_taxonomy');
		$wp_mcm_use_post_taxonomy_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_use_post_taxonomy]';
		?><input type="checkbox" id="input_wp_mcm_use_post_taxonomy" name="<?php echo $wp_mcm_use_post_taxonomy_name; ?>" value="1" <?php checked('1', $wp_mcm_use_post_taxonomy);?> />
			<?php  echo __(' Use the category used for posts also explicitly for attachments?', 'wp-media-category-management');
	}

	public function create_wp_mcm_search_media_library_field(){
		$wp_mcm_search_media_library = mcm_get_option('wp_mcm_search_media_library');
		$wp_mcm_search_media_library_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_search_media_library]';
		?><input type="checkbox" id="input_wp_mcm_search_media_library" name="<?php echo $wp_mcm_search_media_library_name; ?>" value="1" <?php checked('1', $wp_mcm_search_media_library);?> />
			<?php  echo __(' Also search the media library for matching titles when searching?', 'wp-media-category-management');
	}

	public function create_wp_mcm_default_media_category_field(){
		$wp_mcm_media_taxonomy_to_use = mcm_get_option('wp_mcm_media_taxonomy_to_use');
		$wp_mcm_default_media_category = mcm_get_option('wp_mcm_default_media_category');
		$wp_mcm_default_media_category_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_default_media_category]';
		// Only show_option_none when no POST Taxonomy
		if ($wp_mcm_media_taxonomy_to_use == WP_MCM_POST_TAXONOMY) {
			$wp_mcm_show_option_none = '';
		} else {
			$wp_mcm_show_option_none = __('No default category', 'wp-media-category-management');
		}
		$dropdown_options = array(
			'taxonomy'          => $wp_mcm_media_taxonomy_to_use,
			'name'              => $wp_mcm_default_media_category_name,
			'selected'          => $wp_mcm_default_media_category,
			'hide_empty'        => 0,
			'hierarchical'      => true,
			'orderby'           => 'name',
			'walker'            => new mcm_walker_category_filter(),
			'show_count'        => false,
			'show_option_none'  => $wp_mcm_show_option_none,
			'option_none_value' => WP_MCM_OPTION_NONE,
		);
		wp_dropdown_categories( $dropdown_options );
		echo ' ' . __('Which category of the selected media taxonomy should be used as default?', 'wp-media-category-management');
	}

	public function create_wp_mcm_default_post_category_field(){
		$wp_mcm_default_post_category = mcm_get_option('wp_mcm_default_post_category');
		$wp_mcm_default_post_category_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_default_post_category]';
		$dropdown_options = array(
			'taxonomy'          => WP_MCM_POST_TAXONOMY,
			'name'              => $wp_mcm_default_post_category_name,
			'selected'          => $wp_mcm_default_post_category,
			'hide_empty'        => 0,
			'hierarchical'      => true,
			'orderby'           => 'name',
			'walker'            => new mcm_walker_category_filter(),
			'value'             => 'slug',
			'show_count'        => false,
			'show_option_none'  => __('No default category', 'wp-media-category-management'),
			'option_none_value' => '',
		);
		wp_dropdown_categories( $dropdown_options );
		echo __(' Which post category should be used as default?', 'wp-media-category-management');
	}

	public function create_wp_mcm_default_custom_media_category_field(){
		$wp_mcm_custom_media_taxonomy = mcm_get_option('wp_mcm_media_taxonomy_to_use');
		$wp_mcm_default_custom_media_category = mcm_get_option('wp_mcm_default_custom_media_category');
		$wp_mcm_default_custom_media_category_name = WP_MCM_OPTIONS_NAME . '[wp_mcm_default_custom_media_category]';
		$dropdown_options = array(
			'taxonomy'          => $wp_mcm_custom_media_taxonomy,
			'name'              => $wp_mcm_default_custom_media_category_name,
			'selected'          => $wp_mcm_default_custom_media_category,
			'hide_empty'        => 0,
			'hierarchical'      => true,
			'orderby'           => 'name',
			'walker'            => new mcm_walker_category_filter(),
			'show_count'        => false,
			'show_option_none'  => __('No default category', 'wp-media-category-management'),
			'option_none_value' => '',
		);
		wp_dropdown_categories( $dropdown_options );
		echo __(' Which custom media category should be used as default?', 'wp-media-category-management');
	}

	/**
	 * Render the admin page for this plugin.
	 *
	 * @since    0.1.0
	 */
	public function display_plugin_admin_page() {
		$this->debugMP('msg',__FUNCTION__);
		include_once( WP_MCM_DIR . '/views/admin.php' );
	}


	/**
	 * Create a Debug My Plugin panel.
	 *
	 * @return null
	 */
	function create_DMPPanels() {
		if (!isset($GLOBALS['DebugMyPlugin'])) { return; }
		if (class_exists('DMPPanelWPMCMMain') == false) {
			require_once(dirname( __FILE__ ) . '/class.dmppanels.php');
		}
		$GLOBALS['DebugMyPlugin']->panels['wp-mcm'] = new DMPPanelWPMCMMain();
	}

	/**
	 * Add DebugMyPlugin messages.
	 *
	 * @param string $panel - panel name
	 * @param string $type - what type of debugging (msg = simple string, pr = print_r of variable)
	 * @param string $header - the header
	 * @param string $message - what you want to say
	 * @param string $file - file of the call (__FILE__)
	 * @param int $line - line number of the call (__LINE__)
	 * @param boolean $notime - show time? default true = yes.
	 * @return null
	 */
	function debugMP($type='msg', $header='Debug WP Media Category Management',$message='',$file=null,$line=null,$notime=true) {

		$panel='wp-mcm';

		// Panel not setup yet?  Return and do nothing.
		//
		if (
			!isset($GLOBALS['DebugMyPlugin']) ||
			!isset($GLOBALS['DebugMyPlugin']->panels[$panel])
		   ) {
			return;
		}

		if (($header!=='')) {
			$header = 'WPMCM:: ' . $header;
		}

		// Do normal real-time message output.
		//
		switch (strtolower($type)):
			case 'pr':
				$GLOBALS['DebugMyPlugin']->panels[$panel]->addPR($header,$message,$file,$line,$notime);
				break;
			default:
				$GLOBALS['DebugMyPlugin']->panels[$panel]->addMessage($header,$message,$file,$line,$notime);
		endswitch;
	}

}
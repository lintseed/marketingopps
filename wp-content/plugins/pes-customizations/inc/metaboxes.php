<?php
/**
 * Define the metabox and field configurations.
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

function cmb2_sample_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix = 'opp_';

    /**
     * Initiate the metabox
     */
    $cmb = new_cmb2_box( array(
        'id'            => $prefix . 'details',
        'title'         => __( 'Opportunity Details', 'cmb2' ),
        'object_types'  => array( 'opportunity', ), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
      //  'cmb_styles' => iot_types, // false to disable the CMB stylesheet
    ) );
    // Sold?
		$cmb->add_field( array(
			'name'             => '<strong style="color: #ff0000;">Sold</strong>',
			'id'               => $prefix . 'sold',
			'type'             => 'checkbox',
			'default' => '',
			'options'          => array(
					'sold'   => __( 'sold', 'cmb2' ),
			),
	) );
	// Enabled?
	$cmb->add_field( array(
			'name'             => '<span style="color:green">Enabled</span>',
			'id'               => $prefix . 'enabled',
			'type'             => 'checkbox',
			'default' => 'enabled',
			'options'          => array(
					'enabled' => __( 'Enabled', 'cmb2' ),
			),
	) );
	// Featured
		$cmb->add_field( array(
			'name'             => '<span style="color:#ffcd00">✩</span> Featured Opportunity?',
			'id'               => $prefix . 'featured',
			'type'             => 'checkbox',
			'default' => '',
			'options'          => array(
					'featured' => __( 'Featured', 'cmb2' ),
			),
	) );
	// Current Quantity Available
		$cmb->add_field( array(
			'name'    => 'Excerpt',
			'desc'    => 'Will display above the content. Provide one paragraph of text, do not include HTML',
			'default' => '',
			'id'      => $prefix . 'excerpt',
			'sanitization_cb' => 'sanitize_html',
			'type'    => 'textarea',
		) );
		// look @ column option for these fields or before_row, etc.
		// Current Quantity Available
		$cmb->add_field( array(
			'name'    => '<u>Current</u> Quantity Available',
			'default' => '',
			'id'      => $prefix . 'current_quantity',
			'type'    => 'text',
		) );
		// Totle Quantity Available
		$cmb->add_field( array(
			'name'    => '<u>Total</u> Quantity Available',
			'default' => '',
			'id'      => $prefix . 'total_quantity',
			'type'    => 'text',
		) );
		// look @ column option for these fields or before_row, etc.
		// Numeric Cost
		$cmb->add_field( array(
			'name'    => 'Cost',
			'id'      => $prefix . 'numeric_cost',
			'desc'    => 'Enter the minimum value for price sorting.',
			'type'    => 'text_money',
			'sanitization_cb' => 'sanitize_numeric',
		) );
		// Cost Override
		$cmb->add_field( array(
			'name'    => 'Text Cost',
			'desc'    => 'Enter a price range or include any necessary descriptors here.',
			'id'      => $prefix . 'total_cost',
			'type'    => 'text',
		) );
		$cmb->add_field( array(
	    'name'    => 'Sponsor Logo Paths',
			'desc'    => 'Please enter the full URL for each sponsor logo stored in the Sponsor Tool. If one does not exist, please use the upload tool below.',
			'id'      => $prefix . 'logos_paths',
			'type'    => 'text',
			'repeatable' => true,
		) );
		$cmb->add_field( array(
	    'name'    => 'Upload Sponsor Logos',
			'desc'    => 'Upload sponsor logos when there is not already a logo on file.',
			'id'      => $prefix . 'sponsor_logos',
			'type'    => 'file_list',
			'options' => array(
        'url' => true,
    	),
			'repeatable' => true
		) );
		$cmb->add_field( array(
	    'name'    => 'Images',
			'id'      => $prefix . 'images',
			'type'    => 'file_list',
			'options' => array(
        'url' => true,
    	),
			'repeatable' => true
		) );
		$cmb->add_field( array(
	    'name'    => 'Supporting Document',
			'desc'    => 'Upload a file or enter a URL',
			'id'      => $prefix . 'document',
			'type'    => 'file_list',
			'text' => array(
        'add_upload_files_text' => 'Add Files', // default: "Add or Upload Files"
        'remove_image_text' => 'Remove Images', // default: "Remove Image"
        'file_text' => 'File:', // default: "File:"
        'file_download_text' => 'Download', // default: "Download"
        'remove_text' => 'Remove', // default: "Remove"
    	),
		) );
		$cmb->add_field( array(
	    'name'    => 'Supporting Document Labels',
			'desc'    => 'Please enter a label for each document uploaded',
			'id'      => $prefix . 'documentLabel',
			'type'    => 'text',
			'repeatable'  => true,
		) );
		$cmb->add_field( array(
			'name' => 'Sale Deadline',
			'id'   => $prefix . 'deadline',
			'type' => 'text_date',
			// 'timezone_meta_key' => 'wiki_test_timezone',
			// 'date_format' => 'l jS \of F Y',
		) );
		$cmb->add_field( array(
	    'name'    => 'Contact Information',
			'id'      => $prefix . 'contact',
			'type'    => 'text'
		) );
		$cmb->add_field( array(
	    'name'    => 'Contact Information #2',
			'id'      => $prefix . 'contact_2',
			'type'    => 'text'
		) );


	$cmb = new_cmb2_box( array(
			'id'            => $prefix . 'admin_notes',
			'title'         => __( 'Admin Notes', 'cmb2' ),
			'object_types'  => array( 'opportunity', ), // Post type
			'context'       => 'normal',
			'priority'      => 'high',
			'show_names'    => true, // Show field names on the left
			// 'cmb_styles' => false, // false to disable the CMB stylesheet
			// 'closed'     => true, // Keep the metabox closed by default
	) );
	$cmb->add_field( array(
    'name' => 'Fulfillment Notes',
    'desc' => 'field description (optional)',
    'default' => '',
    'id' => $prefix . 'fulfillment',
    'type' => 'textarea_small'
	) );
	$cmb->add_field( array(
    'name' => 'Venue Information',
    'desc' => 'field description (optional)',
    'default' => '',
    'id' => $prefix . 'venue_info',
    'type' => 'textarea_small'
	) );
	//	1500 Characters
	//	XX Characters
}
add_action( 'cmb2_admin_init', 'cmb2_sample_metaboxes' );


/**
 * Manually render a field.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function opps_render_row_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$id          = $field->args( 'id' );
	$label       = $field->args( 'name' );
	$name        = $field->args( '_name' );
	$value       = $field->escaped_value();
	$description = $field->args( 'description' );
	?>
	<div class="custom-field-row <?php echo $classes; ?>">
		<p><label for="<?php echo $id; ?>"><?php echo $label; ?></label></p>
		<p><input id="<?php echo $id; ?>" type="text" name="<?php echo $name; ?>" value="<?php echo $value; ?>"/></p>
		<p class="description"><?php echo $description; ?></p>
	</div>
	<?php
}

/**
 * Manually render a field column display.
 *
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 */
function opps_display_text_small_column( $field_args, $field ) {
	?>
	<div class="custom-column-display <?php echo $field->row_classes(); ?>">
		<p><?php echo $field->escaped_value(); ?></p>
		<p class="description"><?php echo $field->args( 'description' ); ?></p>
	</div>
	<?php
}

add_action( 'cmb2_admin_init', 'opps_register_repeatable_group_field_metabox' );
/**
 * Hook in and add a metabox to demonstrate repeatable grouped fields
 */
function opps_register_repeatable_group_field_metabox() {
	$prefix = 'opps_group_';
	/**
	 * Repeatable Field Groups
	 */
	$cmb_group = new_cmb2_box( array(
		'id'           => $prefix . 'metabox',
		'title'        => __( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'page', ),
	) );
	// $group_field_id is the field id string, so in this case: $prefix . 'demo'
	$group_field_id = $cmb_group->add_field( array(
		'id'          => $prefix . 'demo',
		'type'        => 'group',
		'description' => __( 'Generates reusable form entries', 'cmb2' ),
		'options'     => array(
			'group_title'   => __( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
			'add_button'    => __( 'Add Another Entry', 'cmb2' ),
			'remove_button' => __( 'Remove Entry', 'cmb2' ),
			'sortable'      => true, // beta
			// 'closed'     => true, // true to have the groups closed by default
		),
	) );
	/**
	 * Group fields works the same, except ids only need
	 * to be unique to the group. Prefix is not needed.
	 *
	 * The parent field's id needs to be passed as the first argument.
	 */
	$cmb_group->add_group_field( $group_field_id, array(
		'name'       => __( 'Entry Title', 'cmb2' ),
		'id'         => 'title',
		'type'       => 'text',
		// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
	) );
	$cmb_group->add_group_field( $group_field_id, array(
		'name'        => __( 'Description', 'cmb2' ),
		'description' => __( 'Write a short description for this entry', 'cmb2' ),
		'id'          => 'description',
		'type'        => 'textarea_small',
	) );
	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Entry Image', 'cmb2' ),
		'id'   => 'image',
		'type' => 'file',
	) );
	$cmb_group->add_group_field( $group_field_id, array(
		'name' => __( 'Image Caption', 'cmb2' ),
		'id'   => 'image_caption',
		'type' => 'text',
	) );
}

add_action( 'cmb2_admin_init', 'opps_register_taxonomy_metabox' );
/**
 * Hook in and add a metabox to add fields to taxonomy terms
 */
function opps_register_taxonomy_metabox() {
	$prefix = 'opps_term_';

	/**
	 * Metabox to add fields to categories and tags
	 */
	$cmb_term = new_cmb2_box( array(
		'id'               => $prefix . 'edit',
		'title'            => __( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'category', 'post_tag' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );
	$cmb_term->add_field( array(
		'name'             => __( 'Event Year', 'cmb2' ),
		'id'               => $prefix . 'select',
		'type'             => 'select',
		'show_option_none' => true,
		'options'          => array(
			'2014' => __( '2014', 'cmb2' ),
			'2015' => __( '2015', 'cmb2' ),
			'2016' => __( '2016', 'cmb2' ),
			'2017' => __( '2017', 'cmb2' ),
			'2018' => __( '2018', 'cmb2' ),
			'2019' => __( '2019', 'cmb2' ),
			'2020' => __( '2020', 'cmb2' ),
			'2021' => __( '2021', 'cmb2' ),
			'2022' => __( '2023', 'cmb2' ),
			'2023' => __( '2023', 'cmb2' ),
			'2024' => __( '2024', 'cmb2' ),
			'2025' => __( '2025', 'cmb2' ),
			'2026' => __( '2026', 'cmb2' ),
			'2027' => __( '2027', 'cmb2' ),
			'2028' => __( '2028', 'cmb2' ),
			'2029' => __( '2029', 'cmb2' ),
			'2030' => __( '2030', 'cmb2' ),
		)
	) );
	// Date Range
		$cmb_term->add_field( array(
        'name'       => __( 'Start Date', 'cmb2' ),
        'id'         => $prefix . 'text_datetime_timestamp_timezone',
        'type'       => 'text_datetime_timestamp_timezone',
    ) );
  	$cmb_term->add_field( array(
        'name'       => __( 'End Date', 'cmb2' ),
        'id'         => $prefix . 'text_datetime_timestamp',
        'type'       => 'text_datetime_timestamp',
    ) );
}

add_action( 'cmb2_admin_init', 'opps_register_theme_options_metabox' );
/**
 * Hook in and register a metabox to handle a theme options page
 */
function opps_register_theme_options_metabox() {

	$option_key = 'opps_theme_options';

	/**
	 * Metabox for an options page. Will not be added automatically, but needs to be called with
	 * the `cmb2_metabox_form` helper function. See wiki for more info.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'      => $option_key . 'page',
		'title'   => __( 'Theme Options Metabox', 'cmb2' ),
		'hookup'  => false, // Do not need the normal user/post hookup
		'show_on' => array(
			// These are important, don't remove
			'key'   => 'options-page',
			'value' => array( $option_key )
		),
	) );



	/**
	 * Options fields ids only need
	 * to be unique within this option group.
	 * Prefix is not needed.
	 */
	$cmb_options->add_field( array(
		'name'    => __( 'Site Background Color', 'cmb2' ),
		'desc'    => __( 'field description (optional)', 'cmb2' ),
		'id'      => 'bg_color',
		'type'    => 'colorpicker',
		'default' => '#ffffff',
	) );

}

function	sanitize_numeric($value, $field_args, $field) {
	$value = preg_replace('/[\$,]/', '', $value);
	$sanitized_value = floatval($value);
	return $sanitized_value;
}
/**
 * Handles sanitization for the wiki_custom_escaping_and_sanitization field.
 * Ensures a field's value is greater than 100 or nothing.
 *
 * @param  mixed      $value      The unsanitized value from the form.
 * @param  array      $field_args Array of field arguments.
 * @param  CMB2_Field $field      The field object
 *
 * @return mixed                  Sanitized value to be stored.
 */
function sanitize_html( $value, $field_args, $field ) {
		$sanitized_value = strip_tags($value);
  	return  $sanitized_value;
}

/**
 * Opportunity Meta
 * Conditionally displays meta boxes per selected category
 */
// require '/inc/event-metaboxes.php';
/* Hook into posts to do the thing... */
function add_admin_scripts( $hook ) {
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'opportunity' === $post->post_type ) {
            wp_enqueue_script(  'eventboxes', plugins_url().'/pes-customizations/js/eventboxes.js' );
        }
    }
}

/**
 * trim the fat
 */
 function slug_get_post_meta_cb( $object, $field_name, $request ) {
	return get_post_meta( $object[ 'id' ], $field_name );
}

function slug_update_post_meta_cb( $value, $object, $field_name ) {
	return update_post_meta( $object[ 'id' ], $field_name, $value );
}


/**
 * levels & types
 */

add_action( 'cmb2_admin_init', 'cmb2_register_iot' );
add_action( 'cmb2_admin_init', 'cmb2_register_worldtea' );
add_action( 'cmb2_admin_init', 'cmb2_register_naturalproducts' );
add_action( 'cmb2_admin_init', 'cmb2_register_club' );
add_action( 'cmb2_admin_init', 'cmb2_register_engredea' );
add_action( 'cmb2_admin_init', 'cmb2_register_ew' );
add_action( 'cmb2_admin_init', 'cmb2_register_ee' );
add_action( 'cmb2_admin_init', 'cmb2_register_nbj' );
add_action( 'cmb2_admin_init', 'cmb2_register_nbj18' );
add_action( 'cmb2_admin_init', 'cmb2_register_waste' );
add_action( 'cmb2_admin_init', 'cmb2_register_mtce' );
add_action( 'cmb2_admin_init', 'cmb2_register_mtce18' );
add_action( 'cmb2_admin_init', 'cmb2_register_sl' );
add_action( 'cmb2_admin_init', 'cmb2_register_ldi' );
add_action( 'cmb2_admin_init', 'cmb2_register_pes' );
add_action( 'cmb2_admin_init', 'cmb2_register_itdev' );
add_action( 'cmb2_admin_init', 'cmb2_register_escabona' );
add_action( 'cmb2_admin_init', 'cmb2_register_mro' );
add_action( 'cmb2_admin_init', 'cmb2_register_cll' );
add_action( 'cmb2_admin_init', 'cmb2_register_tse' );
add_action( 'cmb2_admin_init', 'cmb2_register_iwce' );
add_action( 'cmb2_admin_init', 'cmb2_register_dcw' );


function cmb2_register_iot() {
	$cmb = new_cmb2_box( array(
        'id'           => 'iot_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity'), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_iot',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Marketing Assets' => 'Marketing Assets',
            'Signature Opportunities' => 'Signature Opportunities' ,
            'Premier Sponsorships' => 'Premier Sponsorships',
        ),
    ) );
}

function cmb2_register_naturalproducts() { /* ee17 */
	$cmb = new_cmb2_box( array(
        'id'           => 'naturalproducts_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity' ), // Post type
    ) );
 		$cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_np',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
            'Marketing' => 'Marketing',
            'Title Sponsor' => 'Title Sponsor',
        ),
    ) );
}

function cmb2_register_club() {
	$cmb = new_cmb2_box( array(
        'id'           => 'club_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity' ), // Post type
    ) );
 		$cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_club',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
						'Premier Platinum' => 'Premier Platinum',
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
            'Marketing' => 'Marketing',
        ),
    ) );
}

function cmb2_register_worldtea() {
	$cmb = new_cmb2_box( array(
        'id'           => 'worldtea_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_tea',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Signature' => 'Signature',
            'Premium' => 'Premium',
            'Marketing' => 'Marketing',
        ),
    ) );
}

function cmb2_register_engredea() {
	$cmb = new_cmb2_box( array(
        'id'           => 'engredea_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_engredea',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
					'Platinum' => 'Platinum',
					'Gold' => 'Gold',
					'Silver' => 'Silver',
					'Marketing' => 'Marketing',
					'Title' => 'Title'
        ),
    ) );
}

function cmb2_register_ew() {
	$cmb = new_cmb2_box( array(
        'id'           => 'ew_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_ew',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
					'Platinum' => 'Platinum',
					'Gold' => 'Gold',
					'Silver' => 'Silver',
					'Marketing' => 'Marketing',
					'Title' => 'Title'
        ),
    ) );
}

function cmb2_register_ee() {
	$cmb = new_cmb2_box( array(
        'id'           => 'ee_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_ee',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
					'Platinum' => 'Platinum',
					'Gold' => 'Gold',
					'Silver' => 'Silver',
					'Marketing' => 'Marketing',
					'Title' => 'Title'
        ),
    ) );
}

function cmb2_register_nbj() {
	$cmb = new_cmb2_box( array(
        'id'           => 'nbj_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_nbj',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Brand' => 'Brand',
            'Exclusive' => 'Exclusive',
            'Event' => 'Event',
            'Lead Generation' => 'Lead Generation',
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_nbj',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Premier Platinum' => 'Premier Platinum',
            'Premier Title' => 'Premier Title',
            'Premier Program' => 'Premier Program',
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
        ),
    ) );
}

function cmb2_register_nbj18() {
	$cmb = new_cmb2_box( array(
        'id'           => 'nbj18_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_nbj18',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Brand' => 'Brand',
            'Exclusive' => 'Exclusive',
            'Event' => 'Event',
            'Lead Generation' => 'Lead Generation',
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_nbj18',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Platinum',
          2 => 'Gold',
          3 => 'Silver',
          4 => 'Media Partner',
          5 => 'Media Partner',
          6 => 'Media Partner'
        ),
    ) );
}

function cmb2_register_waste() {
	$cmb = new_cmb2_box( array(
        'id'           => 'waste_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity'), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_waste',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
          'Event' => 'Event',
					'Package' => 'Package',
					'Brand Exposure' => 'Brand Exposure',
					'Mobile App' => 'Mobile App',
					'A-la-carte' => 'A-la-carte',
					'Marketing' => 'Marketing'
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_waste',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Platinum' => 'Platinum',
            'Silver' => 'Silver',
            'Bronze' => 'Bronze',
            'Green' => 'Green',
            'Mobile App Upgrades' => 'Mobile App Upgrades'
        ),
    ) );
}

function cmb2_register_mtce() {
	$cmb = new_cmb2_box( array(
        'id'           => 'mtce_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_mtce',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Premium' => 'Premium',
            'Content Related' => 'Content Related',
            'Hospitality' => 'Hospitality',
            'Product Branded' => 'Product Branded',
            'Exhibit Hall' => 'Exhibit Hall',
            'Tech-Focused' => 'Tech-Focused',
        ),
    ) );
}

function cmb2_register_mtce18() {
	$cmb = new_cmb2_box( array(
        'id'           => 'mtce18_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_mtce18',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Premium' => 'Premium',
            'Content Related' => 'Content Related',
            'Hospitality' => 'Hospitality',
            'Product Branded' => 'Product Branded',
            'Exhibit Hall' => 'Exhibit Hall',
            'Tech-Focused' => 'Tech-Focused',
        ),
    ) );
}

function cmb2_register_sl() {
	$cmb = new_cmb2_box( array(
        'id'           => 'sl_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_sl',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Premium' => 'Premium',
            'Content Related' => 'Content Related',
            'Hospitality' => 'Hospitality',
            'Product Branded' => 'Product Branded',
            'Exhibit Hall' => 'Exhibit Hall',
            'Tech-Focused' => 'Tech-Focused',
        ),
    ) );
}

function cmb2_register_ldi() {
	$cmb = new_cmb2_box( array(
        'id'           => 'ldi_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_ldi',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
          'Digital' => 'Digital',
          'Events' => 'Events',
					'Marketing' => 'Marketing',
					'Brand Awareness' => 'Brand Awareness',
					'Lead Generation' => 'Lead Generation',
					'Community' => 'Community',
					'Sponsorships' => 'Sponsorships',
					'Exclusive Opportunity' => 'Exclusive Opportunity',
					'Product Sampling' => 'Product Sampling',
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_ldi',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Front Row' => 'Front Row',
            'Association' => 'Association',
        ),
    ) );
}

function cmb2_register_pes() {
	$cmb = new_cmb2_box( array(
        'id'           => 'pes_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_pes',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
           'Brand Awareness' => 'Brand Awareness',
					 'Marketing' => 'Marketing',
					 'Exclusive Opportunity' => 'Exclusive Opportunity',
					 'Lead Generation' => 'Lead Generation',
					 'Signature Opportunity' => 'Signature Opportunity',
					 'Digital' => 'Digital',
					 'Events' => 'Events',
					 'Premium Sponsorship' => 'Premium Sponsorship'
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_pes',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          'Platinum' => 'Platinum',
					'Gold' => 'Gold',
					'Silver' => 'Silver',
					'None' => 'None'
        ),
    ) );
}

function cmb2_register_itdev() {
	$cmb = new_cmb2_box( array(
        'id'           => 'itdev_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_itdev',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Diamond',
          2 => 'Platinum',
					3 => 'Gold',
					4 => 'Silver',
					5 => 'Promotional Sponsors'
        ),
    ) );
}

function cmb2_register_escabona() {
	$cmb = new_cmb2_box( array(
        'id'           => 'escabona_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_escabona',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Innovation Sponsor',
          2 => 'Influence Sponsor',
					3 => 'Growth Sponsor',
					4 => 'Marketing'
        ),
    ) );
}

function cmb2_register_mro() {
	$cmb = new_cmb2_box( array(
        'id'           => 'mro_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_mro',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Host',
          2 => 'Lead',
					3 => 'Sponsor',
					4 => 'Supporter',
					5 => 'Tabletop'
        ),
    ) );
}

function cmb2_register_cll() {
	$cmb = new_cmb2_box( array(
        'id'           => 'cll_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_cll',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Platinum',
          2 => 'Premier Partner',
					3 => 'Industry Partner'
        ),
    ) );
}

function cmb2_register_tse() {
	$cmb = new_cmb2_box( array(
        'id'           => 'tse_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_tse',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
					 'Brand' => 'Brand',
					 'Events' => 'Events',
					 'Sponsorships' => 'Sponsorships'
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_tse',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Diamond',
          2 => 'Premier',
					3 => 'Exhibitor'
        ),
    ) );
}

function cmb2_register_iwce() {
	$cmb = new_cmb2_box( array(
        'id'           => 'iwce_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_iwce',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Sponsorship',
          2 => 'Advertising'
        ),
    ) );
}

function cmb2_register_dcw() {
	$cmb = new_cmb2_box( array(
        'id'           => 'dcw_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_dcw',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
          1 => 'Strategic Partner',
          2 => 'Platinum',
          3 => 'Gold',
          4 => 'Silver',
          5 => 'Speaking',
          6 => 'Events',
          7 => 'Marketing Promotions',
          8 => 'Media Partner'
        ),
    ) );
}

<?php
/*
 
*/
		
add_action( 'cmb2_admin_init', 'cmb2_register_iot' );
add_action( 'cmb2_admin_init', 'cmb2_register_worldtea' );
add_action( 'cmb2_admin_init', 'cmb2_register_naturalproducts' );
add_action( 'cmb2_admin_init', 'cmb2_register_club' );
add_action( 'cmb2_admin_init', 'cmb2_register_engredea' );
add_action( 'cmb2_admin_init', 'cmb2_register_ew' );
add_action( 'cmb2_admin_init', 'cmb2_register_nbj' );
add_action( 'cmb2_admin_init', 'cmb2_register_waste' );
add_action( 'cmb2_admin_init', 'cmb2_register_mtce' );
add_action( 'cmb2_admin_init', 'cmb2_register_ldi' );

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
        'id'      => 'opp_level_np',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
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
        'name'    => 'Type',
        'id'      => 'opp_type_wt',
        'type'    => 'multicheck',
        'select_all_button' => false,
        'options' => array(
            'Package' => 'Package',
            'Marketing' => 'Marketing',
            'Brand Awareness' => 'Brand Awareness',
            'Lead Generation' => 'Lead Generation',
        ),
    ) );
    $cmb->add_field( array(
        'name'    => 'Level',
        'id'      => 'opp_level_nbj',
        'type'    => 'select',
        'show_option_none' => true,
        'options' => array(
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
            'Media Partner' => 'Media Partner',
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
            'Platinum' => 'Platinum',
            'Gold' => 'Gold',
            'Silver' => 'Silver',
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

function cmb2_register_ldi() {
	$cmb = new_cmb2_box( array(
        'id'           => 'ldi_metabox',
        'classes'    => 'options-box types-levels',
        'title'        => 'Opportunity Options',	
        'object_types' => array( 'opportunity', ), // Post type
    ) );
    $cmb->add_field( array(
        'name'    => 'Type',
        'id'      => 'opp_type_waste',
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
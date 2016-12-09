<?php /**
 * Unserialize arrays for JSON ouput
 */
class unserialize_php_arrays_before_sending_json {
    function __construct() {
      add_action( 'json_api_import_wp_post',
      array( $this, 'json_api_import_wp_post' ), 10, 2 );
    }
	function json_api_import_wp_post( $JSON_API_Post, $wp_post ) {
		foreach ( $JSON_API_Post->custom_fields as $key => $custom_field ) {
			if (is_array($custom_field)) {
				$unserialized_array = array();
				foreach($custom_field as $field_key => $field_value) {
					$unserialized_array[$field_key] = maybe_unserialize( $field_value );
				}
				$JSON_API_Post->custom_fields->$key = $unserialized_array;
			} else {
				$JSON_API_Post->custom_fields->$key = maybe_unserialize( $custom_field );
			}
		}
	}
}
new unserialize_php_arrays_before_sending_json();

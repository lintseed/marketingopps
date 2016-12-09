<?php
// Copyright 2014-2016 RealFaviconGenerator

class Favicon_By_RealFaviconGenerator_Common {

	const PLUGIN_PREFIX = 'fbrfg';

	const OPTION_FAVICON_CONFIGURED                   = 'fbrfg_favicon_configured';
	const OPTION_FAVICON_IN_ROOT                      = 'fbrfg_favicon_in_root';
	const OPTION_PREVIEW_FILE_NAME                    = 'fbrfg_preview_file_name';
	const OPTION_HTML_CODE                            = 'fbrfg_html_code';
	const OPTION_FAVICON_NON_INTERACTIVE_API_REQUEST  = 'fbrfg_favicon_non_interactive_api_request';

	const OPTION_FAVICON_CURRENT_VERSION              = 'fbrfg_favicon_current_version';
	const OPTION_MOST_RECENT_AUTOMATIC_UPDATE_FROM    = 'fbrfg_most_recent_automatic_update_from';
	const OPTION_MOST_RECENT_AUTOMATIC_UPDATE_TO      = 'fbrfg_most_recent_automatic_update_to';
	const OPTION_LATEST_MANUAL_AVAILABLE_UPDATE       = 'fbrfg_latest_manual_available_update';
	const OPTION_UPDATES_DATA                         = 'fbrfg_updates_data';
	const OPTION_UPDATES_LIST                         = 'fbrfg_updates_list';

	const META_NO_UPDATE_NOTICE_FOR_VERSION           = 'fbrfg_ignore_update_notice_';
	const META_NO_AUTOMATIC_UPDATE_NOTICE_FOR_VERSION = 'fbrfg_ignore_automatic_update_notice_';
	const META_NO_UPDATE_NOTICE                       = 'fbrfg_no_update_notice';

	public static function get_options_list() {
		return array(
			Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_CONFIGURED,
			Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_IN_ROOT,
			Favicon_By_RealFaviconGenerator_Common::OPTION_PREVIEW_FILE_NAME,
			Favicon_By_RealFaviconGenerator_Common::OPTION_HTML_CODE,
			Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_NON_INTERACTIVE_API_REQUEST,
			Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_CURRENT_VERSION,
			Favicon_By_RealFaviconGenerator_Common::OPTION_MOST_RECENT_AUTOMATIC_UPDATE_FROM,
			Favicon_By_RealFaviconGenerator_Common::OPTION_MOST_RECENT_AUTOMATIC_UPDATE_TO,
			Favicon_By_RealFaviconGenerator_Common::OPTION_LATEST_MANUAL_AVAILABLE_UPDATE,
			Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_DATA,
			Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_LIST,
			Favicon_By_RealFaviconGenerator_Common::META_NO_UPDATE_NOTICE );
	}

	const PLUGIN_SLUG = 'favicon-by-realfavicongenerator';

	const ACTION_CHECK_FOR_UPDATE = 'fbrfg_check_for_updates';

	const RFG_DEBUG = 'false';

	public function log_info( $message ) {
		if ( ( ( constant( 'WP_DEBUG') == 'true' ) || ( constant( 'WP_DEBUG') == 1 ) ) &&
			( ( constant( 'Favicon_By_RealFaviconGenerator_Common::RFG_DEBUG') == 'true' ) ||
				( constant( 'Favicon_By_RealFaviconGenerator_Common::RFG_DEBUG') == 1 ) ) ) {
			error_log( 'RealFaviconGenerator - ' . $message );
		}
	}

	/**
	 * Indicate if a favicon was configured.
	 */
	public function is_favicon_configured() {
		$opt = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_CONFIGURED );
		return ( $opt == 1 );
	}

	/**
	 * Indicate if the configured favicon is in the root directory of the web site.
	 */
	public function is_favicon_in_root() {
		$opt = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_IN_ROOT );
		return ( $opt == 1 ) && $this->is_favicon_configured();
	}

	public function get_favicon_current_version() {
		// Before the "version" feature was implemented, all favicons generated by the plugin
		// were generated with RFG v0.7
		return get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_CURRENT_VERSION, "0.7" );
	}

	public function set_favicon_current_version( $version ) {
		return update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_CURRENT_VERSION, $version );
	}

	public function set_most_recent_automatic_update( $from_version, $to_version ) {
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_MOST_RECENT_AUTOMATIC_UPDATE_FROM,
			$from_version );
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_MOST_RECENT_AUTOMATIC_UPDATE_TO,
			$to_version );
	}

	/**
	 * Return the last automatic update that *has been* run.
	 * If favicon was automatically updated from version 0.6 to 0.8, this function returns array('0.6', '0.8').
	 */
	public function get_most_recent_automatic_update() {
		$from = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_MOST_RECENT_AUTOMATIC_UPDATE_FROM );
		$to   = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_MOST_RECENT_AUTOMATIC_UPDATE_TO );
		return ( ( $from == NULL ) || ( $to == NULL ) ) ? NULL : array( $from, $to );
	}

	public function set_latest_manual_available_update( $version ) {
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_LATEST_MANUAL_AVAILABLE_UPDATE,
			$version );
	}

	/**
	 * Return the lastest available update (to be proposed to the user).
	 */
	public function get_latest_manual_available_update() {
		return get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_LATEST_MANUAL_AVAILABLE_UPDATE );
	}

	/**
	 * Save the versions data, as returned by https://realfavicongenerator.net/api/versions
	 */
	public function set_updates_data( $versions_data ) {
		$this->log_info( 'Set updates data' );

		$data = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_DATA );
		if ( ! $data ) {
			$data = array();
		}
		$list = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_LIST );
		if ( ! $list ) {
			$list = array();
		}
		foreach($versions_data as $version ) {
			$this->log_info( 'Store data of ' . $version['version']);
			$data[$version['version']] = $version;
			if ( ! in_array($version['version'], $list ) ) {
				array_push( $list, $version['version'] );
			}
		}
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_DATA, $data );
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_LIST, $list );
	}

	/**
	 * Returns the data of a particular update. Format is similar to what is returned by
	 * https://realfavicongenerator.net/api/versions
	 */
	public function get_update_data( $version ) {
		$data = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_DATA );
		if ( ! $data ) {
			return NULL;
		}
		else {
			return $data[$version];
		}
	}

	/**
	 * Return the list of versions. For example, if versions are know from 0.3 to 0.11 and $from = '0.6' and $to = '0.10',
	 * then this function returns array('0.7', '0.8', '0.9', '0.10'). Yes, '0.6' is not included while '0.10' is.
	 */
	public function get_updates_list( $from, $to ) {
		$this->log_info( 'Getting versions list from ' . $from . ' to ' . $to );

		$list = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_UPDATES_LIST );
		if ( ! $list ) {
			return NULL;
		}

		$listing = ! in_array( $from, $list );
		$sub_list = array();

		foreach( $list as $version ) {
			if ( $listing ) {
				array_push( $sub_list, $version );
			}
			if ( $version == $from ) {
				$listing = true;
			}
			if ( $version == $to ) {
				return $sub_list;
			}
		}

		return $sub_list;
	}

	public function get_updates_description( $from, $to ) {
		$this->log_info( 'Getting description from ' . $from . ' to ' . $to );

		$versions = $this->get_updates_list( $from, $to );
		if ( $versions == NULL ) {
			$this->log_info( 'No versions, return a link to the change log description' );
			return sprintf( __( "Visit the <a href=\"%s\">RFG's change log</a> to view the content of the update" ),
				'https://realfavicongenerator.net/change_log?since=' . $from );
		}

		$this->log_info( 'Versions to describe: ' . implode( ', ', $versions ) );

		$descriptions = array();
		foreach( $versions as $version ) {
			$update = $this->get_update_data( $version );
			array_push( $descriptions,
				'<p>' .  $update['description'] . '</p>' );
		}
		return implode($descriptions);
	}

	public function get_non_interactive_api_request() {
		return get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_NON_INTERACTIVE_API_REQUEST );
	}

	public function set_favicon_configured( $configured, $favicon_in_root, $version, $non_interactive_api_request = NULL ) {
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_CONFIGURED,
			$configured ? 1 : 0 );
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_IN_ROOT,
			$favicon_in_root ? 1 : 0 );

		$this->set_favicon_current_version( $version );

		// Reset the update stuff
		$this->set_latest_manual_available_update( NULL );

		if ( $non_interactive_api_request != NULL ) {
			update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_FAVICON_NON_INTERACTIVE_API_REQUEST,
				$non_interactive_api_request );
		}
	}

	public function is_preview_available() {
		$opt = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_PREVIEW_FILE_NAME );
		return ( ( $opt != NULL ) && ( $opt != false ) );
	}

	public function get_preview_file_name() {
		return get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_PREVIEW_FILE_NAME );
	}

	public function set_preview_file_name($preview_file_name) {
		update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_PREVIEW_FILE_NAME,
			$preview_file_name);
	}

	public function add_favicon_markups() {
		$code = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_HTML_CODE );
		if ( $code ) {
			echo $code;
		}
	}

	public function remove_genesis_favicon() {
		// See http://dreamwhisperdesigns.com/genesis-tutorials/change-default-genesis-favicon/
		// However, I didn't find the right hook to trigger this code in time to deactivate Genesis hooks.
		// As a consequence, this function is not used and mostly here as a reference.
		remove_action( 'genesis_meta', 'genesis_load_favicon' );
		remove_action( 'wp_head', 'genesis_load_favicon' );
	}

	public function return_empty_favicon_for_genesis( $param ) {
		$code = get_option( Favicon_By_RealFaviconGenerator_Common::OPTION_HTML_CODE );
		if ( $code ) {
			// Why NULL?
			// - It is not false (ie. the exact boolean value 'false')
			// - When tested with 'if ($value)', the condition fails.
			// See function genesis_load_favicon for more details
			return NULL;
		}
		else {
			// Return the value as is, no interference with the rest of WordPress
			return $param;
		}
	}

	/**
	 * Returns /www/wordpress/wp-content/uploaded/fbrfg
	 */
	public static function get_files_dir() {
		$up_dir = wp_upload_dir();
		return $up_dir['basedir'] . '/' . Favicon_By_RealFaviconGenerator_Common::PLUGIN_PREFIX . '/';
	}

	/**
	 * Returns http//somesite.com/blog/wp-content/upload/fbrfg/
	 */
	public static function get_files_url() {
		$up_dir = wp_upload_dir();
		$baseUrl = $up_dir['baseurl'];
		// Make sure to no duplicate the '/'
		// This is especially important when the base URL is the root directory:
		// When this happens, the generated URL would be
		// "http//somesite.com//fbrfg/" and then "//fbrfg/" when the host name is
		// stripped. But this path is wrong, as it looks like a "same protocol" URL.
		$separator = (substr($baseUrl, -1) == '/') ? '' : '/';
		return $baseUrl . $separator . Favicon_By_RealFaviconGenerator_Common::PLUGIN_PREFIX . '/';
	}

	public static function get_tmp_dir() {
		return Favicon_By_RealFaviconGenerator_Common::get_files_dir() . 'tmp/';
	}

	public static function remove_directory($directory) {
		foreach( scandir( $directory ) as $v ) {
			if ( is_dir( $directory . '/' . $v ) ) {
				if ( $v != '.' && $v != '..' ) {
					Favicon_By_RealFaviconGenerator_Common::remove_directory( $directory . '/' . $v );
				}
			}
			else {
				unlink( $directory . '/' . $v );
			}
		}
		rmdir( $directory );
	}


	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {

		$domain = Favicon_By_RealFaviconGenerator_Common::PLUGIN_SLUG;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}

	// See http://webcheatsheet.com/php/get_current_page_url.php
	public function current_page_url() {
		$pageURL = 'http';
		if ( isset($_SERVER["HTTPS"] ) && ( $_SERVER["HTTPS"] == "on" ) ) {
			$pageURL .= "s";
		}
		$pageURL .= "://";
		if ( $_SERVER["SERVER_PORT"] != "80" ) {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		}
		else {
			$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		}
		return $pageURL;
	}

	public function add_parameter_to_current_url( $param_and_value ) {
		$url = $this->current_page_url();
		if ( strpos( $url, '?') !== false) {
			return $url . '&' . $param_and_value;
		}
		else {
			return $url . '?' . $param_and_value;
		}
	}

	public function check_for_updates() {
		$this->log_info( 'Checking for updates...' );

		if ( ! $this->is_favicon_configured() ) {
			// No favicon so nothing to update
			$this->log_info( 'No favicon configured so nothing to update' );
			return;
		}

		$version = $this->get_favicon_current_version();
		$this->log_info( 'Current version is ' . $version );

		if ( $version == NULL ) {
			// No version for some reason. Let's leave.
			$this->log_info( 'Current favicon version not available' );
			return;
		}

		$checkUrl = 'https://realfavicongenerator.net/api/versions?since=' . $version;
		$resp = wp_remote_get( $checkUrl );
		if ( ( $resp == NULL ) || ( $resp == false ) || ( is_wp_error( $resp ) )  ||
			 ( $resp['response'] == NULL ) || ( $resp['response']['code'] == NULL ) || ( $resp['response']['code'] != 200 ) ) {
			// Error of some kind? Return
			$this->log_info( 'Cannot get latest version from RealFaviconGenerator ' .
				( is_wp_error( $resp ) ? ': ' . $resp->get_error_message() : '' ) . ' (URL was ' . $checkUrl . ')' );
			return;
		}

		$json = json_decode( $resp['body'], true );
		if ( empty( $json ) ) {
			$this->log_info( 'No change since version ' . $version . ' or cannot parse JSON (JSON parsing error code is ' . json_last_error() . ')' );
			return;
		}

		$this->log_info( 'Update versions database' );
		$this->set_updates_data( $json );

		// Check update relevancy
		$manual = false;
		$automatic = false;
		foreach($json as $version) {
			if ( $version['relevance']['manual_update'] ) {
				$manual = true;
			}
			if ( $version['relevance']['automated_update'] ) {
				$automatic = true;
			}
		}

		$this->log_info( "Automated updates to run: " . ( $automatic ? 'true' : 'false') );
		$this->log_info( "Manual updates to run: " . ( $manual ? 'true' : 'false' ) );

		if ( $manual || ( $automatic && ( ! $this->get_non_interactive_api_request() ) ) ) {
			$this->log_info( 'Manual update, or automatic update but we have no non-interactive request to do it automatically' );

			// We only note the latest available version.
			// For example, if we receive version 0.8, 0.9 and 0.10 (in this order), we only note 0.10
			$last = $json[count( $json ) - 1];
			$latest_version = $last['version'];

			// Save the fact that we should update
			$this->log_info( 'There is a manual update to go to ' . $latest_version );
			$this->set_latest_manual_available_update( $latest_version );
		}
		else if ( $automatic && $this->get_non_interactive_api_request() ) {
			// Automatic update

			$this->log_info( 'Automatic update to be performed' );

			// Do not run it when the update is also manual, because we are going to ask the user to
			// update anyway.

			try {
				$result = $this->run_non_interactive_api_request( $this->get_non_interactive_api_request() );

				$response = new Favicon_By_RealFaviconGenerator_Api_Response( $result );

				$zip_path = Favicon_By_RealFaviconGenerator_Common::get_tmp_dir();
				if ( ! file_exists( $zip_path ) ) {
					if ( mkdir( $zip_path, 0755, true ) !== true ) {
						throw new InvalidArgumentException( sprintf( __( 'Cannot create directory %s to store the favicon package', FBRFG_PLUGIN_SLUG), $zip_path ) );
					}
				}
				$response->downloadAndUnpack( $zip_path );

				$this->store_pictures( $response );

				$this->store_preview( $response->getPreviewPath() );

				Favicon_By_RealFaviconGenerator_Common::remove_directory( $zip_path );

				update_option( Favicon_By_RealFaviconGenerator_Common::OPTION_HTML_CODE, $response->getHtmlCode() );

				$version_before_update = $this->get_favicon_current_version();

				$this->set_favicon_configured( true, $response->isFilesInRoot(), $response->getVersion() );

				// Remember about this update
				$this->log_info( 'Save the fact that we updated from ' . $version_before_update . ' to ' . $response->getVersion() );
				$this->set_most_recent_automatic_update( $version_before_update, $response->getVersion() );
			}
			catch( Exception $e ) {
				$this->log_info( 'Cannot update favicon automatically: ' . $e->getMessage() );
			}
		}
	}

	public function run_non_interactive_api_request( $request ) {
		$resp = wp_remote_post( 'https://realfavicongenerator.net/api/favicon',
			array( 'body' => $request, 'timeout' => 45 ) );
		if ( is_wp_error( $resp )) {
			throw new InvalidArgumentException( "Cannot run the non-interactive API request for update: " . $resp->get_error_message() );
		}

		$json = wp_remote_retrieve_body( $resp );
		if ( empty( $json ) ) {
			throw new InvalidArgumentException( "Empty JSON document while running the non-interactive API request" );
		}

		return $json;
	}

}

// Shortcut
define('FBRFG_PLUGIN_SLUG', Favicon_By_RealFaviconGenerator_Common::PLUGIN_SLUG);

<?php
/**
 *
 * The WordPress Media Category Management Plugin.
 *
 * @package   WP_MediaCategoryManagement
 * @author    De B.A.A.T. <wp-mcm@de-baat.nl>
 * @license   GPL-3.0+
 * @link      https://www.de-baat.nl/WP_MCM
 * @copyright 2014 - 2016 De B.A.A.T.
 *
 * Represents the view for the administration dashboard.
 *
 * This includes the header, options, and other information that should provide
 * The Admin User Interface to the admin user.
 */
?>
<div class="wrap">

	<?php screen_icon(); ?>
	<h2><?php echo __('Welcome to WP Media Category Management', 'wp-media-category-management'); ?></h2>

	<form method="post" action="options.php">

	<?php
		settings_fields( 'wp_mcm_option_group' );
		do_settings_sections( 'wp-mcm-setting-admin' );
	?>

		<?php submit_button(); ?>
	</form>

	<br/>
	<br/>
	<br/>
	<br/>
	<br/>
	<p><?php echo sprintf(__('wp-mcm version %s.', 'wp-media-category-management'), mcm_get_option('wp_mcm_version')); ?></p>

</div>

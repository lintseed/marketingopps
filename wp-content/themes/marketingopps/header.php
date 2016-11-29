<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<link rel="apple-touch-icon" sizes="180x180" href="/sandbox/MarketingOpps/wp-content/themes/marketingopps/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" href="/sandbox/MarketingOpps/wp-content/themes/marketingopps/favicons/favicon-32x32.png" sizes="32x32">
	<link rel="icon" type="image/png" href="/sandbox/MarketingOpps/wp-content/themes/marketingopps/favicons/favicon-16x16.png" sizes="16x16">
	<link rel="manifest" href="/sandbox/MarketingOpps/wp-content/themes/marketingopps/favicons/manifest.json">
	<link rel="mask-icon" href="/sandbox/MarketingOpps/wp-content/themes/marketingopps/favicons/safari-pinned-tab.svg" color="#5bbad5">
	<meta name="theme-color" content="#ffffff">
	<?php wp_head(); ?>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<div class="site-inner">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'twentysixteen' ); ?></a>
		
		<div class="header" id="content" tabindex="-1">
			<div class="container">
				<div class="site-branding">
					<?php twentysixteen_the_custom_logo(); ?>
				</div><!-- .site-branding -->
			</div>			
		</div><!-- .header -->

		<div id="content" class="container">

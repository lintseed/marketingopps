<nav id="pes-navbar" class="navbar-fixed-top navbar navbar-inverse pes-navbar bg-primary">

	<div class="container">

		<div class="navbar-header">
			<button type="button" class="navbar-toggle right offcanvas-trigger">
				<span class="sr-only"><?php _e('Toggle navigation','_tk') ?> </span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>

		<div class="navbar-offcanvas offcanvas-trigger">
			<div class="offcanvas-inner right">

				<div class="pull-right margin-top padding-sm-top">
					<?php if (is_user_logged_in()) { ?>
						<i class="fa fa-user" aria-hidden="true"></i> hey,
						<?php $current_user = wp_get_current_user(); ?>
						<?php if (!empty($current_user->first_name)) {
							echo $current_user->first_name;
						} else {
							echo $current_user->nicename;
						} ?>
						&nbsp;&nbsp;|&nbsp;&nbsp;<a class="screen-reader-shortcut" href="<?php echo esc_url( get_dashboard_url() ); ?>"><?php _e('dashboard'); ?></a>
						 &nbsp;&nbsp;|&nbsp;&nbsp;<a class="screen-reader-shortcut" href="<?php echo esc_url( wp_logout_url() ); ?>"><?php _e('log out'); ?></a>
					<?php } else { ?>
					  <i class="fa fa-user" aria-hidden="true"></i> <a class="screen-reader-shortcut" href="<?php echo esc_url( wp_login_url() ); ?>"><?php _e('please login'); ?></a>
					<? } ?>
				</div>

				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="/wp-content/themes/pes-core-wp/dist/images/penton_wht.png" alt="<?php bloginfo( 'name' ); ?>"></a>
				<a class="site-title" aria-haspopup="true" href="/">Opportunities</a>

			</div>
		</div>

	</div><!-- .container -->

	<?php wp_nav_menu(array('theme_location'=>'primary', 'container'=>'div', 'fallback_cb'=>'', 'menu_class'=>'container', 'container_id'=>'subnav')); ?>

</nav><!-- .navbar -->

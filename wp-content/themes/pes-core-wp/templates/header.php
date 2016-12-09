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

				<!-- Your site title as branding in the menu -->
				<a class="navbar-brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="/wp-content/themes/pes-core-wp/dist/images/penton_wht.png" alt="<?php bloginfo( 'name' ); ?>"></a>
				<a class="site-title" aria-haspopup="true" href="/">Opportunities</a>
<!--
				<?php wp_nav_menu(
					array(
						'theme_location'	=> 'primary',
						'depth'						=> '0',
						'menu_id'					=> 'menu-mobile',
						'menu_class'			=> 'nav navbar-nav',
						'container'				=> false,
						// 'walker' => new wp_bootstrap_navwalker(),
					)
				); ?>
				<?php wp_nav_menu(
					array(
						'theme_location'	=> 'primary',
						'depth'						=> '0',
						'menu_id'					=> 'menu-wide',
						'menu_class'			=> 'nav navbar-nav',
						'container'				=> false,
						// 'walker' => new wp_bootstrap_navwalker(),
					)
				); ?>
				<?php if (is_user_logged_in()) { ?>
					<a class="screen-reader-shortcut" href="<?php echo esc_url( wp_logout_url() ); ?>"><?php _e('Log Out'); ?></a>
				<?php } else { ?>
				  Welcome, visitor!
				<? } ?>
-->
			</div>
		</div>

	</div><!-- .container -->


  <?php if ( is_user_logged_in() ) : ?>

  <?php endif; ?>

	<?php wp_nav_menu(array('theme_location'=>'primary', 'container'=>'div', 'fallback_cb'=>'', 'menu_class'=>'container', 'container_id'=>'subnav')); ?>

</nav><!-- .navbar -->

    </div><!-- .site-content -->

    <footer id="colophon" class="site-footer pes-footer bg-info" role="contentinfo">
      <div class="container">
        <?php if ( has_nav_menu( 'primary' ) ) : ?>
          <nav class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Primary Menu', 'twentysixteen' ); ?>">
            <?php
              wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'primary-menu',
               ) );
            ?>
          </nav><!-- .main-navigation -->
        <?php endif; ?>

        <div class="site-info row">
          <div class="col-md-6">
            <nav class="Nav Nav--footer-utility">
              <ul class="Nav-menu Nav-menu--depth0 menu breadcrumbs">
                <li class="Nav-menuItem Nav-menuItem--depth0 menu-item menu-item-type-post_type menu-item-object-page menu-item-54"><a href="/terms-of-service/" class="Nav-link">Terms of Service</a></li>
                <li class="Nav-menuItem Nav-menuItem--depth0 menu-item menu-item-type-post_type menu-item-object-page menu-item-53"><a href="/privacy-policy/" class="Nav-link">Privacy Policy</a></li>
                <li class="Nav-menuItem Nav-menuItem--depth0 menu-item menu-item-type-post_type menu-item-object-page menu-item-52"><a href="/sitemap/" class="Nav-link">Sitemap</a></li>
              </ul>
            </nav>
          </div>
          <div class="col-md-6">
            <p class="text-right footer-copyright">&copy; <?php echo date('Y'); ?> Penton. All Rights Reserved.</p>
          </div>
        </div><!-- .site-info -->
      </div><!-- .container -->
    </footer><!-- .site-footer -->


  </div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
</body>
</html>

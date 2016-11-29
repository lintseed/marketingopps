<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

get_header(); ?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .entry-header -->

					<div class="entry-content">

						<?php

//						print_r(maybe_unserialize(get_post_meta(get_the_ID(), 'opp_type_iot', true)));
							print_r(get_post_meta(get_the_ID(), 'opp_images', true));
							print_r(get_post_meta(get_the_ID(), 'opp_logos_paths', true));
							print_r(get_post_meta(get_the_ID(), 'opp_document', true));
							
							?>
					</div><!-- .entry-content -->

				</article><!-- #post-## -->
<?php
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<?php
get_footer();

<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

 ?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<?php $meta = get_post_meta(get_the_ID()); ?>
		<?php
		$args = array(
	'orderby'   => 'meta_value_num',
	'meta_key'  => 'TSEORDER',
);
$query = new WP_Query( $args );
?>
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			// Start the Loop.
			while ( have_posts() ) : the_post(); ?>
			
			<?php $meta = get_post_meta(get_the_ID()); ?>
			

			<?php
				echo '<li class="panel '.$meta["YEAR"][0].' '.$meta["EVENTID"][0].' '.$meta["TSEORDER"][0].'">';  
				//edit_post_link( __('<i class="fa fa-pencil text-gray-light" aria-hidden="true"></i>'));
				echo '<h3>'.get_the_title().'</h3>';
				echo '<h4>'.$meta["PRODUCT"][0].'</h4>';
				
				if(!empty($meta['LEVEL'])) {
					echo '<span class="label label-'.$meta["LEVEL"][0].'">'.$meta["LEVEL"][0].'</span><br>';
				}	
				
				if(!empty($meta['CONTACT_FOR_PRINT'])) {
					echo $meta["CONTACT_FOR_PRINT"][0];
				}			
				if(!empty($meta['PHONE'])) {
					echo ' | '.$meta["PHONE"][0];
				}
				echo ' | '.$meta["COMPANY"][0];
				if(!empty($meta['CONTACT_EMAIL'])) {
					echo ' | <a href="mailto:'.$meta["CONTACT_EMAIL"][0].'">'.$meta["CONTACT_EMAIL"][0].'</a>';
				}
			//	if(!empty($meta['EMAIL_FOR_PRINT'])) {
			//		echo ' | <a href="mailto:'.$meta["EMAIL_FOR_PRINT"][0].'">'.$meta["EMAIL_FOR_PRINT"][0].'</a>';
			//	}
				if(!empty($meta['WEBSITE'])) {
					echo ' | <a href="'.$meta["WEBSITE"][0].'" target="_blank">'.$meta["WEBSITE"][0].'</a>';
				}
				echo '</li>';    
				
//				echo $meta["EVENT"][0];
//				echo $meta["CONTACT_EMAIL"][0];
//				echo '</p>';				
			?>

		<?php	endwhile; ?>
		<?php	endif; ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>

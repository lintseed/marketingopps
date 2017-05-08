<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

 /*
 * Levels & Types
 * todo: create a callback function
 */
 $meta = get_post_meta(get_the_ID());
 foreach($meta as $key=>$value) {
	 if("opp_level_" == substr($key,0,10) || "opp_type_" == substr($key,0,9)) {
		 $suffix = substr($key,strrpos($key,'_'));
		 $type = 'opp_type'.$suffix;
		 $level = 'opp_level'.$suffix;
	 }
 }
 $theTypes = unserialize($meta[$type][0]);
 $oppLevel = unserialize($meta[$level][0]);
?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post(); ?>

				<?php $meta = get_post_meta(get_the_ID()); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="page-header">
						<div class="pull-right">
							<?php
								$categories = get_the_category();
								$separator = ' &raquo; ';
								$category = $categories[0]->cat_ID;
								$parent_id = $categories[0]->category_parent;
                $ancestors = 0;
                if ($parent_id) {
								  $ancestors = get_category_parents($parent_id, true, $separator);
                }
								if (!empty($ancestors)) {
                  print_r($ancestors);
	      					$breadcrumb = $ancestors.'<a href="'.get_category_link($category).'">'.$categories[0]->cat_name.'</a>';
	 							} else {
	      					$breadcrumb = '<span class="active-cat">'.single_cat_title().'</span>';
	 							}
	     					echo '<div class="padding-lg-top"><h3 class="opp-event margin-top text-gray-light">'.$breadcrumb.'</h3></div>';
							?>
						</div>
						<div class="pull-left">
							<?php the_title( '<h1 class="entry-title pull-left"><span class="text-gray">Opportunity:</span> ', '</h1>' ); ?>
							<?php /* editors, edit! */ ?>
							<?php edit_post_link('<i class="fa fa-pencil text-gray-light" aria-hidden="true"></i>', '<span class="margin-lg-top margin-left pull-left">', '</span>'); ?>
						</div>
					</header><!-- .entry-header -->

					<div class="row">
					<div class="entry-content col-sm-8">

						<?php /* display price */ ?>
						<?php if (!empty($meta['opp_total_cost'][0])) { ?>
							<p class="margin-bottom"><h5>Display Price:</h5>
								<?php echo $meta['opp_total_cost'][0]; ?>
							</p>
						<?php } elseif ($meta['opp_numeric_cost'][0]) { ?>
							<p class="margin-bottom"><h5>Numeric Price:</h5>
								<?php echo '$'.number_format($meta['opp_numeric_cost'][0]); ?>
							</p>
						<?php } ?>

						<?php /* display quantities */ ?>
						<?php if (!empty($meta['opp_current_quantity'][0]) || !empty($meta['opp_total_quantity'][0])) { ?>
							<div class="opp-quantities">
								<h5>Quanitity:</h5>
								<?php if (!empty($meta['opp_current_quantity'][0])) { echo $meta['opp_current_quantity'][0]; } ?>
								<?php if (!empty($meta['opp_total_quantity'][0])) { echo '/'.$meta['opp_total_quantity'][0]; } ?>
							</div>
						<?php } ?>

						<?php /*  featured? */ ?>
						<?php if(!empty($meta['opp_featured'][0])) { ?><p class="margin-bottom"><h5><i class="fa fa-star-o" aria-hidden="true"></i> Featured Opportunity</h5></p><?php } ?>

						<?php /* sold status, level, types */ ?>
						<div class="clear clearfix labels">

							<div class="margin-bottom">
								<h5>Status: </h5>
								<?php if (!empty($meta['opp_sold'][0])) { ?>
									<span class="label label-danger">Sold</span>
								<?php } else { ?>
									<span class="label label-success">Available</span>
								<?php } ?>
							</div>

							<?php

							if (!empty($meta['opp_level_pes'][0])) { ?><span class="margin-sm-right label label-default so-label <?php //echo levelClass($meta['opp_level_pes'][0]); ?>"><?php echo $meta['opp_level_pes'][0]; ?></span><?php } ?>

							<?php if (!empty($meta[$level][0])) { ?>
								<div class="margin-bottom">
									<h5>Level:</h5>
									<span class="margin-sm-right label label-default <?php echo $meta[$level][0]; ?>"><?php echo $meta[$level][0]; ?></span>
								</div>
							<?php } ?>

							<?php
								if(is_array($theTypes)) {
									echo '<div class="margin-bottom"><h5>Type/s: </h5>';
									foreach($theTypes as $test=>$oppType) {
										echo '<span class="margin-sm-right label label-default '.$oppType.'">'.$oppType.'</span>';
									}
									echo '</div>';
								}
							?>
							<?php if (!empty($meta['opp_level_pes'][0])) { ?><br><span class="pull-left margin-sm-right label label-default so-label <?php //echo levelClass($meta['opp_level_pes'][0]); ?>"><?php echo $meta['opp_level_pes'][0]; ?></span><?php } ?>

						</div><?php /* labels */ ?>

						<?php /* do the content  */ ?>
						<?php if(!empty($meta['opp_excerpt'][0])) { echo '<h5>Excerpt:</h5><div class="margin-lg-bottom well">'.$meta['opp_excerpt'][0].'</div>'; } ?>
						<?php if(get_the_content()) {
							echo '<h5>Content:</h5><br><div class="margin-lg-bottom well">';
							echo the_content();
							echo '</div>';
						} ?>

						<?php /* types */ ?>
						<?php if (!empty($meta['opp_type_pes'])) { ?>
							<h5>Types:</h5>
							<ul class="margin-lg-bottom">
								<?php foreach($meta['opp_type_pes'] as $type) {
									$opptype = unserialize($type);
									foreach($opptype as $k => $v) {
										echo '<li>'.$v.'</li>';
									}
								} ?>
							</ul>
						<?php } ?>

						<?php /* supporting documents */ ?>
						<?php if(!empty($meta['opp_document'])) {
							echo '<p class="margin-lg-bottom"><h5>Supporting Documents:</h5><br>	';
							$i = -1;
							// print_r($meta['opp_document']);

							foreach($meta['opp_document'] as $key => $value) {
								$doc = unserialize($value);
								// print_r($doc);
								foreach($doc as $file => $path) {
									$i++;
									if($meta['opp_documentLabel']) {
										foreach($meta['opp_documentLabel'] as $doclabel) {
											$labels = unserialize($doclabel);
										}
									}
									if ($labels[$i] === null) {
										$attachment_title = get_the_title($file);
										$labels[$i] = $attachment_title;
									}
									echo '<i class="fa fa-file-o" aria-hidden="true"></i> <a href="'.$path.'" target="_blank">'.$labels[$i].'</a><br>';
								}
							}
							echo '</p>';
						} ?>

						<?php /* Output the deadline */ ?>
						<?php if(!empty($meta['opp_deadline'])) { echo '<p class="margin-lg-bottom"><h5><i class="fa fa-calendar" aria-hidden="true"></i> Sale Deadline:</h5> '.$meta['opp_deadline'][0].'</p>'; } ?>

						<?php /* finally, contact info. */ ?>
						<?php if(!empty($meta['opp_contact'])) { ?>
							<p class="margin-lg-bottom">
								<h5><i class="fa fa-user" aria-hidden="true"></i> Contact:</h5><br>
								<?php
									echo $meta['opp_contact'][0];
									if ($meta['opp_contact_2']) {
										 echo '<br>'.$meta['opp_contact_2'][0];
									} ?>
							</p>
						<?php } ?>

					</div><?php /* .entry-content */ ?>

					<div class="col-sm-4">
						<?php /* sponsor logo fields: uploaded */ ?>
						<?php if(!empty($meta['opp_sponsor_logos'])) {
							echo '<div class="clear margin-lg-bottom text-center"><h5 class="text-center block margin-bottom">Logos</h5><br>';
							foreach($meta['opp_sponsor_logos'] as $logo) {
								$array = unserialize($logo);
								foreach($array as $img => $src) {
									foreach($src as $imgpath) {
										echo '<img src="'. $imgpath .'" alt="" class="margin-bottom" height="75">';
									}
								}
							}
							echo '</div>';
						} ?>
						<?php /* sponsor logo fields:linked */ ?>
						<?php if(!empty($meta['opp_logos_paths'])) {
							echo '<div class="margin-lg-bottom text-center"><h5 class="text-center block margin-bottom">Logo via Paths</h5><br>';
							foreach($meta['opp_logos_paths'] as $logo) {
								$array = unserialize($logo);
								echo '<img src="'. $array[0] .'" alt="" class="margin-bottom" height="75">';
							}
							echo '</div>';
						} ?>

						<?php /* opp images  */ ?>
						<?php if(!empty($meta['opp_images'])) {
							echo '<div class="pull-right text-center"><h5 class="text-center block margin-bottom">Images</h5><br>';
								foreach($meta['opp_images'] as $oppimg) {
									$image = unserialize($oppimg);
									foreach($image as $img => $src) {
										foreach($src as $imgpath) {
											echo '<img src="'. $imgpath .'" alt="" class="margin-bottom" width="200">';
										}
									}
								}
							echo '</div>';
						} ?>
					</div><!-- col -->
				</div><!-- row -->

				</article><!-- #post-## -->
<?php
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->

<!-- Modal ... move this to an include -->

<?php
/**
 * Template Name: Full Width Page
 *
 * @package WordPress
 * @subpackage Twenty_Fourteen
 * @since Twenty Fourteen 1.0
 */

?>

<div id="main-content" class="main-content">

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post(); ?>

				<?php $meta = get_post_meta(get_the_ID()); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header cleafix">
						<?php the_title( '<h1 class="entry-title pull-left">', '</h1>' ); ?>
						<?php /* editors, edit! */ ?>
						<button type="button" class="margin-lg-top margin-sm-left pull-left" data-toggle="modal" data-target="#editModal"><i class="fa fa-pencil text-gray-light" aria-hidden="true"></i></button>
					</header><!-- .entry-header -->

					<div class="entry-content clearfix clear">

						<?php /* display price */ ?>
						<?php if (!empty($meta['opp_total_cost'][0])) { ?>
							<p class="margin-lg-bottom"><b>Display Price:</b>
								<?php echo $meta['opp_total_cost'][0]; ?>
							</p>
						<?php } elseif ($meta['opp_numeric_cost'][0]) { ?>
							<p class="margin-lg-bottom"><b>Numeric Price:</b>
								<?php echo '$'.number_format($meta['opp_numeric_cost'][0]); ?>
							</p>
						<?php } ?>

						<?php /* title, featured? */ ?>
						<?php if(!empty($meta['opp_featured'][0])) { ?><i class="fa fa-star-o" aria-hidden="true"></i> <b>Featured Opportunity</b><?php } ?>

						<?php /* levels, types, sold, deadline  */ ?>
						<div class="clear clearfix labels">
							<?php if (!empty($meta['opp_level_pes'][0])) { ?><span class="margin-sm-right label label-default so-label <?php //echo levelClass($meta['opp_level_pes'][0]); ?>"><?php echo $meta['opp_level_pes'][0]; ?></span><?php } ?>
							<?php if (!empty($meta['opp_sold'][0])) { ?><span class="label label-danger">Sold</span><?php } ?>
						</div>

						<?php /* sponsor logo fields: uploaded */ ?>
						<?php if(!empty($meta['opp_sponsor_logos'])) {
							echo '<div class="clear margin-lg-bottom">';
							foreach($meta['opp_sponsor_logos'] as $logo) {
								$array = unserialize($logo);
								foreach($array as $img => $src) {
									foreach($src as $imgpath) {
										echo '<img src="'. $imgpath .'" alt="" class="margin-lg-right pull-left" height="75">';
									}
								}
							}
							echo '</div>';
						} ?>
						<?php /* sponsor logo fields:linked */ ?>
						<?php if(!empty($meta['opp_logos_paths'])) {
							echo '<div class="margin-lg-bottom">';
							foreach($meta['opp_logos_paths'] as $logo) {
								$array = unserialize($logo);
								echo '<img src="'. $array[0] .'" alt="" class="margin-lg-right pull-left" height="75">';
							}
							echo '</div>';
						} ?>

					</div><?php /* /.heading */ ?>

						<?php /* opp images  */ ?>
						<?php if(!empty($meta['opp_images'])) {
							echo '<div class="pull-right">';
								foreach($meta['opp_images'] as $oppimg) {
									$image = unserialize($oppimg);
									foreach($image as $img => $src) {
										foreach($src as $imgpath) {
											echo '<img src="'. $imgpath .'" alt="" class="pull-right margin-lg-left margin-lg-bottom" width="200">';
										}
									}
								}
							echo '</div>';
						} ?>

						<?php /* do the content  */ ?>
						<?php if(!empty($meta['opp_excerpt'])) { echo '<div class="margin-lg-bottom">'.$meta['opp_excerpt'][0].'</div>'; } ?>
						<?php if(get_the_content()) {
							echo '<div class="margin-lg-bottom">';
							echo the_content();
							echo '</div>';
						} ?>

						<?php /* types */ ?>
						<?php if (!empty($meta['opp_type_pes'])) { ?>
							<p><b>Types:</b></p>
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
							echo '<p class="margin-lg-bottom"><b>Supporting Documents:</b><br>	';
							$i = -1;
							foreach($meta['opp_document'] as $key => $value) {
								$doc = unserialize($value);
								foreach($doc as $file => $path) {
									$i++;
									if($meta['opp_documentLabel']) {
										foreach($meta['opp_documentLabel'] as $doclabel) {
											$labels = unserialize($doclabel);
										}
									}
									if ($labels[$i] === null) {
										$labels[$i] = 'View Document';
									}
									echo '<i class="fa fa-file-o" aria-hidden="true"></i> <a href="'.$path.'" target="_blank">'.$labels[$i].'</a><br>';
								}
							}
							echo '</p>';
						} ?>

						<?php /* Output the deadline */ ?>
						<?php if(!empty($meta['opp_deadline'])) { echo '<p class="margin-lg-bottom"><b>Deadline:</b> '.$meta['opp_deadline'][0].'</p>'; } ?>

						<?php /* finally, contact info. */ ?>
						<?php if(!empty($meta['opp_contact'])) { ?>
							<p class="margin-lg-bottom">
								<b><i class="fa fa-user" aria-hidden="true"></i> Contact:</b><br>
								<?php
									echo $meta['opp_contact'][0];
									if ($meta['opp_contact_2']) {
										 echo '<br>'.$meta['opp_contact_2'][0];
									} ?>
							</p>
						<?php } ?>

					</div><!-- .entry-content -->

				</article><!-- #post-## -->
<?php
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div><!-- #main-content -->


<!-- Modal ... move this to an include -->
<?php
//Admin functions required to show taxonomy lists
	require_once(ABSPATH.'wp-admin/includes/template.php');
	$meta = get_post_meta(get_the_ID());

	$custom = get_post_custom(get_the_ID());
	$excerpt = @$custom["opp_excerpt"][0];
	$sold = @$custom["opp_sold"][0];
	$enabled = @$custom["opp_enabled"][0];
	$featured = @$custom["opp_featured"][0];
	$deadline = @$custom["opp_deadline"][0];
	$current_quantity = @$custom["opp_current_quantity"][0];
	$total_quantity = @$custom["opp_total_quantity"][0];
	$numeric_cost = @$custom["opp_numeric_cost"][0];
	$total_cost = @$custom["opp_total_cost"][0];

?>

<div id="editModal" class="modal fade" role="dialog" aria-labelledby="editLabel" style="display: none;">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<form method="post" action="" enctype="multipart/form-data">

				<input type='hidden' name='frontend' value="true" />
				<input type='hidden' name='ID' value="<?php echo get_the_ID(); ?>" />
				<input type='hidden' name='post_type' value="<?php echo $post->post_type ?>" />

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 id="editLabel">Edit Opportunity</h3>
				</div>

				<div class="modal-body">
					<?php /* descriptors */ ?>
					<div class="form-group">
						<label for="inputTitle">Title</label>
						<input type="text" id="inputTitle" name="post_title" placeholder="Title" value="<?php echo get_the_title() ?>" />
					</div>
					<div class="form-group">
						<label for="inputContent">Description</label>
						<?php wp_editor( get_the_content(), 'post_content', array(
							'media_buttons' => false,
						)); ?>
					</div>
					<div class="form-group">
						<label for="excerpt">Excerpt</label>
						<textarea id="opp_excerpt" name="opp_excerpt" rows="5"><?php echo $meta['opp_excerpt'][0]; ?></textarea>
					</div>

					<?php /* levels & types */ ?>
					<hr>
					levels & types

					<?php /* options */ ?>
					<hr>
					<div class="form-group">
						<label for="sold" class="text-danger">Sold</label>
						<input type="checkbox" id="opp_sold" name="sold" checked="<?php echo $meta['opp_sold'][0]; ?>" />
					</div>
					<div class="form-group">
						<label for="sold" class="text-success">Enabled</label>
						<input type="checkbox" id="opp_enabled" name="opp_enabled" checked="<?php echo $meta['opp_enabled'][0]; ?>" />
					</div>
					<div class="form-group">
						<label for="sold"><i class="fa fa-star-o" aria-hidden="true"></i> Featured</label>
						<input type="checkbox" id="opp_featured" name="opp_featured" checked="<?php echo $meta['opp_featured'][0]; ?>" />
					</div>
					<div class="form-group">
						<label for="opp_total_cost">Sale Deadline</label>
						<input type="text" id="opp_deadline" name="opp_deadline" value="<?php echo $meta['opp_deadline'][0]; ?>" />
					</div>

					<?php /* details */ ?>
					<hr>
					<div class="form-group">
						<label for="opp_current_quantity">Current Quantity</label>
						<input type="text" id="opp_current_quantity" name="opp_current_quantity" value="<?php echo $meta['opp_current_quantity'][0]; ?>" />
					</div>
					<div class="form-group">
						<label for="opp_total_quantity">Total Quantity</label>
						<input type="text" id="opp_total_quantity" name="opp_total_quantity" value="<?php echo $meta['opp_total_quantity'][0]; ?>" />
					</div>
					<hr>
					<div class="form-group">
						<label for="opp_current_quantity">Cost<br><em class="text-gray">Enter the minimum value for price sorting.</em></label>
						<input type="text" id="opp_numeric_cost" name="opp_numeric_cost" value="<?php echo $meta['opp_numeric_cost'][0]; ?>" />
					</div>
					<div class="form-group">
						<label for="opp_total_cost">Text Cost<br><em class="text-gray">Enter a price range or include any necessary descriptors here.</em></label>
						<input type="text" id="opp_total_cost" name="opp_total_cost" value="<?php echo $meta['opp_total_cost'][0]; ?>" />
					</div>

					<?php /* more */ ?>
					<hr>
					<a href="/wp-admin/post.php?post=<?php echo get_the_ID(); ?> &action=edit" class="btn btn-primary" target="_blank"><i class="fa fa-pencil" aria-hidden="true"></i> More Options</a>
					<!-- <?php edit_post_link('<i class="fa fa-pencil" aria-hidden="true"></i> More Options','<p>','</p>',get_the_ID(),'btn btn-primary'); ?> -->
				</div>

				<div class="modal-footer">
					<button data-dismiss="modal">Close</button>
					<button>Save changes</button>
				</div>

			</form>

		</div>
	</div>
</div>

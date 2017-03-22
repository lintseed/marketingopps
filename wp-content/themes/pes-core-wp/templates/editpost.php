<?php
	require_once(ABSPATH.'wp-admin/includes/template.php');
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
						<textarea id="opp_excerpt" name="opp_excerpt" rows="5"><?php echo $excerpt; ?></textarea>
					</div>

					<?php /* levels & types */ ?>
					<hr>
					levels & types<br><br>

					<?php /* options */ ?>
					<div class="margin-sm-bottom">
						<div class="form-group col-sm-4 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_sold" class="text-danger">Sold</label>
							<input type="checkbox" id="opp_sold" name="sold" checked="<?php if(!empty($sold)) { echo 'checked'; } else { echo 'false'; } ?>" />
						</div>
						<div class="form-group col-sm-4 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_enabled" class="text-success">Enabled</label>
							<input type="checkbox" id="opp_enabled" name="opp_enabled" checked="<?php if(!empty($enabled)) { echo 'checked'; } else { echo 'false'; } ?>" />
						</div>
						<div class="form-group col-sm-4 border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_featured"><i class="fa fa-star-o" aria-hidden="true"></i> Featured</label>
							<input type="checkbox" id="opp_featured" name="opp_featured" checked="<?php if(!empty($featured)) { echo 'checked'; } else { echo 'false'; } ?>" />
						</div>
					</div>

					<?php /* details */ ?>
					<div class="margin-sm-bottom">
						<div class="form-group col-sm-4 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_total_cost">Sale Deadline</label>
							<input type="text" id="opp_deadline" name="opp_deadline" value="<?php echo $deadline; ?>" />
						</div>
						<div class="form-group col-sm-4 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_current_quantity">Current Quantity</label>
							<input type="text" id="opp_current_quantity" name="opp_current_quantity" value="<?php echo $current_quantity; ?>" />
						</div>
						<div class="form-group col-sm-4 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_total_quantity">Total Quantity</label>
							<input type="text" id="opp_total_quantity" name="opp_total_quantity" value="<?php echo $total_quantity; ?>" />
						</div>
					</div>

					<?php /* cost */ ?>
					<div class="margin-sm-bottom">
						<div class="form-group col-sm-6 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_current_quantity">Cost<br><em class="text-gray small">(minimum, numeric value for sorting)</em></label>
							<input type="text" id="opp_numeric_cost" name="opp_numeric_cost" value="<?php echo $meta['opp_numeric_cost'][0]; ?>" />
						</div>
						<div class="form-group col-sm-6 btn-default border-gray-light border-right-none padding-sm pull-left">
							<label for="opp_total_cost">Text Cost<br><em class="text-gray small">(range or descriptive text)</em></label>
							<input type="text" id="opp_total_cost" name="opp_total_cost" value="<?php echo $meta['opp_total_cost'][0]; ?>" />
						</div>
					</div>

				</div><?php /*  end modal body */ ?>

				<div class="modal-footer">
					<button data-dismiss="modal" class="btn btn-default"><i class="fa fa-close" aria-hidden="true"></i>&nbsp;&nbsp;Cancel</button>
					<a href="/wp-admin/post.php?post=<?php echo get_the_ID(); ?> &action=edit" class="btn btn-default"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;More Options</a>
					<button class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i>&nbsp;&nbsp;Save Opportunity</button>
				</div>

			</form>

		</div>
	</div>
</div>

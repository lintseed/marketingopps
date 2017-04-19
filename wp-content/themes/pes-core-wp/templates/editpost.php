<?php
	global $post;
	require_once(ABSPATH.'wp-admin/includes/template.php');
	$custom = $post->ID;
?>

<div id="editModal<?php echo $post->ID; ?>" class="modal fade" role="dialog" aria-labelledby="editLabel" style="display: none;">

	<div class="modal-dialog" role="document">

		<div class="modal-content">
			<form method="post" action="" enctype="multipart/form-data">

				<input type='hidden' name='frontend' value="true" />
				<input type='hidden' name='ID' value="<?php echo $post->ID; ?>" />
				<input type='hidden' name='post_type' value="<?php echo $post->post_type ?>" />

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<?php
						$categories = get_the_category();
						$separator = ' &raquo; ';
						$category = $categories[0]->cat_ID;
						// print_r($category);
						// die;
						$parent_id = $categories[0]->category_parent;

						if (!empty($parent_id)) {
							$ancestors = get_category_parents($parent_id, true, $separator);
						} else {
							$ancestors = '';
						}
						if (!empty($ancestors)) {
							$breadcrumb = $ancestors.'<a href="'.get_category_link($category).'">'.$categories[0]->cat_name.'</a>';
						} else {
							$breadcrumb = '<span class="active-cat">'.single_cat_title().'</span>';
						}
						echo '<div class="pull-right margin-right"><span class="opp-event text-gray-light">('.$breadcrumb.')</span></div>';
					?>
					<h3 id="editLabel">Edit Opportunity</h3>
				</div>

				<div class="modal-body">

					<?php /* descriptors */ ?>
					<div class="form-group">
						<label for="inputTitle">Title</label>
						<input type="text" class="form-control lead padding text-bold" id="inputTitle" name="post_title" placeholder="Title" value="<?php echo get_the_title() ?>" />
					</div>

					<?php /* wrapper */ ?>
					<div class="modal-container">
						<div id="descriptors-<?php echo $post->ID; ?>" data-field="descriptors-<?php echo $post->ID; ?>" aria-expanded="false">
							<div class="well">
								<div class="form-group">
									<label for="inputContent">Description</label>
										<?php wp_editor( get_the_content(), 'post_content', array(
										'media_buttons' => false,
										'textarea_rows' => 28,
									)); ?>
								</div>
								<div class="form-group"><br>
									<label for="excerpt">Excerpt</label><br>
									<textarea id="opp_excerpt" name="opp_excerpt" rows="5" cols="85"><?php echo $meta['opp_excerpt'][0]; ?></textarea>
								</div>
							</div>
						</div>

						<?php
							/* levels & types */
						?>

						<?php /* options */ ?>
						<div class="margin-sm-bottom">
							<div class="form-group col-sm-4 border-gray-lighter border-right-none pull-left text-center padding-sm-top">
								<input type="checkbox" id="opp_sold-<?php echo $post->ID; ?>" name="opp_sold"<?php if(!empty($meta['opp_sold'][0])) { echo ' checked="checked"'; } else { echo 'null="null"'; } ?> />
								<label for="opp_sold-<?php echo $post->ID; ?>" class="text-danger">Sold</label>
							</div>
							<div class="form-group col-sm-4 border-gray-lighter border-right-none pull-left text-center padding-sm-top">
								<input type="checkbox" id="opp_enabled-<?php echo $post->ID; ?>" name="opp_enabled"<?php if(!empty($meta['opp_enabled'][0])) { echo ' checked="checked"'; } ?> />
								<label for="opp_enabled-<?php echo $post->ID; ?>" class="text-success">Enabled</label>
							</div>
							<div class="form-group col-sm-4 border-gray-lighter pull-left text-center padding-sm-top">
								<input type="checkbox" id="opp_featured-<?php echo $post->ID; ?>" name="opp_featured"<?php if(!empty($meta['opp_featured'][0])) { echo ' checked="checked"'; } ?> />
								<label for="opp_featured-<?php echo $post->ID; ?>"><i class="fa fa-star-o" aria-hidden="true"></i> Featured</label>
							</div>
						</div>

						<?php /* details */ ?>
						<div class="margin-sm-bottom">
							<div class="form-group col-sm-4 border-gray-lighter border-right-none padding-sm-top pull-left">
								<label for="opp_total_cost">Sale Deadline</label>
								<?php if (!empty($meta['opp_deadline'][0])) { ?>
									<input type="date" class="form-control" id="opp_deadline" name="opp_deadline" value="<?php echo date('Y-m-d', strtotime($meta['opp_deadline'][0])); ?>" />
								<?php } else { ?>
									<input type="date" class="form-control" id="opp_deadline" name="opp_deadline" value="" />
								<?php } ?>
							</div>
							<div class="form-group col-sm-4 border-gray-lighter border-right-none padding-sm-top pull-left">
								<label for="opp_current_quantity">Current Quantity</label>
								<input type="text" class="form-control" id="opp_current_quantity" name="opp_current_quantity" value="<?php echo $meta['opp_current_quantity'][0]; ?>" />
							</div>
							<div class="form-group col-sm-4 border-gray-lighter padding-sm-top pull-left">
								<label for="opp_total_quantity">Total Quantity</label>
								<input type="text" class="form-control" id="opp_total_quantity" name="opp_total_quantity" value="<?php echo $meta['opp_total_quantity'][0]; ?>" />
							</div>
						</div>

						<?php /* cost */ ?>
						<div class="margin-sm-bottom">
							<div class="form-group col-sm-6 border-gray-lighter border-right-none padding-sm-top">
								<label for="opp_current_quantity">Cost<br><em class="text-gray-light small">(minimum, numeric value for sorting)</em></label>
								<input type="text" class="form-control" id="opp_numeric_cost" name="opp_numeric_cost" value="<?php echo $meta['opp_numeric_cost'][0]; ?>" />
							</div>
							<div class="form-group col-sm-6 border-gray-lighter padding-sm-top">
								<label for="opp_total_cost">Text Cost<br><em class="text-gray-light small">(range or descriptive text)</em></label>
								<input type="text" class="form-control" id="opp_total_cost" name="opp_total_cost" value="<?php echo $meta['opp_total_cost'][0]; ?>" />
							</div>
						</div>

						<?php /* contacts */ ?>
						<div class="margin-sm-bottom">
							<div class="form-group col-sm-6 border-gray-lighter border-right-none padding-sm-top">
								<label for="opp_current_quantity">Contact</label>
								<input type="text" class="form-control" id="opp_contact" name="opp_contact" value="<?php echo $meta['opp_contact'][0]; ?>" />
							</div>
							<div class="form-group col-sm-6 border-gray-lighter padding-sm-top">
								<label for="opp_total_cost">Contact Row 2</label>
								<input type="text" class="form-control" id="opp_contact_2" name="opp_contact_2" value="<?php echo $meta['opp_contact_2'][0]; ?>" />
							</div>
						</div>

					</div><?php /*  end modal container */ ?>
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

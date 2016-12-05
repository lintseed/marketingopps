<?php
/**
 * The template for displaying CATEGORY pages
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
		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="page-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

      <div id="sponsorship-opps" class="base-sponsor-opp opps">
        <?php /* sort & filter */ ?>
				<!--
        <div id="base-sponsor-opp-accordion" class="panel-group list">
          <div class="row">
            <div class="col-sm-4">
              <div><label>Search</label></div>
              <input class="search" />
            </div>
            <div class="col-sm-8">
              <div><label>Sort</label></div>
              <span class="sort btn btn-sm btn-default" data-sort="opp-title">Sort by name</span>
              <span class="sort btn btn-sm btn-default" data-sort="opp-price">Sort by price</span>
            </div>
          </div>
				-->
	      <ul class="list">
				<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();
					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					// get_template_part( 'template-parts/content', get_post_format() );
	      	$meta = get_post_meta(get_the_ID()); ?>
	        <li class="panel item">
	          <?php if($meta['opp_sponsor_logos']) { ?><div class="panel-heading logos"><?php } else { ?><div class="panel-heading"><?php } ?>
	            <?php /* sort values */ ?>
	            <?php if ($meta['opp_numeric_cost'][0]) { echo '<span class="opp-price hidden">'.number_format($meta['opp_numeric_cost'][0]).'</span>'; } ?>

	            <?php /* display price */ ?>
	            <div class="opp-price pull-right margin-left">
	              <?php if ($meta['opp_total_cost'][0]) { ?>
	                <?php echo $meta['opp_total_cost'][0]; ?>
	              <?php } elseif ($meta['opp_numeric_cost'][0]) { ?>
	                <?php echo '$'.number_format($meta['opp_numeric_cost'][0]); ?>
	              <?php } ?>
	            </div>
	            <?php /* title, featured? */ ?>
	            <h4 class="opp-title media-heading pull-left">
	              <a data-toggle="collapse" data-parent="#base-sponsor-opp-accordion" href="#<?php echo $post->post_name; ?>" class="collapsed title">
	                <?php if($meta['opp_featured'][0]) { ?><i class="fa fa-star-o" aria-hidden="true"></i><?php } ?>
	                <?php echo get_the_title(); ?> <span class="collapse-indicator fa fa-chevron-down"></span>
	              </a>
	            </h4>
	            <?php /* sponsor logo fields  */ ?>
	            <?php if($meta['opp_sponsor_logos']) {
	              echo '<div class="pull-right">';
	              foreach($meta['opp_sponsor_logos'] as $key => $value) {
	                foreach($value as $k => $v) {
	                  foreach($v as $img => $src) {
	                    echo '<img src="'. $src .'" alt="" class="margin-lg-left" height="25">';
	                  }
	                }
	              }
	              echo '</div>';
	            } ?>
	            <?php if($meta['opp_logos_paths']) {
	              echo '<div class="pull-right">';
	              foreach($meta['opp_logos_paths'] as $key => $value) {
	                foreach($value as $k => $v) {
	                  foreach($v as $img => $src) {
	                    echo '<img src="'. $src .'" alt="" class="margin-lg-left" height="25">';
	                  }
	                }
	              }
	              echo '</div>';
	            } ?>
	            <?php /* levels, types, sold, deadline  */ ?>
	            <div class="clearfix labels">
	              <?php if ($meta['opp_level_nbj'][0]) { ?><span class="margin-sm-left label label-default so-label <?php echo levelClass($meta['opp_level_nbj'][0]); ?>"><?php echo $meta['opp_level_nbj'][0]; ?></span><?php } ?>
	              <?php if ($meta['opp_sold'][0]) { ?><span class="margin-sm-left label label-danger">Sold</span><?php } ?>
	              <?php
	                // $opp_date = $meta['opp_deadline'];
	                // pastDeadline($opp_date);
	              ?>
	            </div>

	          </div><?php /* /.panel-heading */ ?>

	          <div id="<?php echo $post->post_name; ?>" class="panel-body panel-collapse collapse">
	            <?php /* opp images  */ ?>
	            <?php if($meta['opp_images']) {
	              echo '<div class="pull-right">';
	              foreach($meta['opp_images'] as $key => $value) {
	                foreach($value as $k => $v) {
	                  foreach($v as $img => $src) {
	                    echo '<img src="'. $src .'" alt="" class="pull-right margin-lg-left margin-lg-bottom" width="200">';
	                  }
	                }
	              }
	              echo '</div>';
	            } ?>
	            <?php /* do the content  */ ?>
	            <?php if($meta['opp_excerpt']) { echo '<p>'.$meta['opp_excerpt'][0].'</p>'; } ?>
	            <?php if(the_content()) { echo the_content(); } ?>

	            <?php /* supporting documents */ ?>
	            <?php if($meta['opp_document']) {
	              echo '<p><b>Supporting Documents:</b><br>	';
	              $i = -1;
	              foreach($meta['opp_document'] as $key => $value) {
	                foreach($value as $k => $v) {
	                  $i++;
	                  if ($meta['opp_documentLabel'][0][$i]) {
	                    $label = $meta['opp_documentLabel'][0][$i];
	                  } else {
	                    $label = 'View Document';
	                  }
	                  echo '<i class="fa fa-file-o" aria-hidden="true"></i> <a href="'.$v.'" target="_blank">'.$label.'</a><br>';
	                }
	              }
	              echo '</p>';
	            } ?>

	            <?php /* finally, contact info. */ ?>
	            <?php if($meta['opp_contact']) { ?>
	              <p>
	                <b><i class="fa fa-user" aria-hidden="true"></i> Contact:</b><br>
	                <?php
	                  echo $meta['opp_contact'][0];
	                  if ($meta['opp_contact_2']) {
	                  echo '<br>'.$meta['opp_contact_2'][0];
	                } ?>
	              </p>
	              <?php } ?>

	          </div><?php /* /.panel-body */ ?>

	        </li><?php /* /.panel */

				// End the loop.
	    	endwhile; ?>

	      </ul>

		    <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
		    <script type="text/javascript">
		      var options = {
		          valueNames: [ 'opp-title', 'opp-price' ]
		      };
		      var hackerList = new List('base-sponsor-opp-accordion', options);
		    </script>
			</div><!-- /#sponsorship-opps -->
<?php
  //
  // foreach ($meta as $key => $value) {
  //   echo $key . " => " . $value . "<br />";
  // }

			// Previous/next page navigation.
			the_posts_pagination( array(
				'prev_text'          => __( 'Previous page', 'twentysixteen' ),
				'next_text'          => __( 'Next page', 'twentysixteen' ),
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
			) );

		// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

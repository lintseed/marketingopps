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
 * @subpackage pes-core-wp
 */
 ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
        <?php if (is_user_logged_in()) { ?>
          <div class="pull-right margin-top">
            <a href="/wp-admin/post-new.php?post_type=opportunity" class="btn btn-primary btn-sm margin-lg-top"><i class="fa fa-plus" aria-hidden="true"></i> Add New Opportunity</a>
          </div>
        <?php }

					the_archive_title( '<h1 class="page-title">', '</h1>' );
          // <span class="text-gray">
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
				?>
			</header><!-- .page-header -->

      <div id="sponsorship-opps" class="base-sponsor-opp opps">
        <?php /* sort & filter */ ?>
        <div id="base-sponsor-opp-accordion" class="panel-group list">
          <div class="row">
            <div class="col-sm-4">
              <div><label>Search</label></div>
              <input class="search" type="text" style="width: 80% !important" />
            </div>
            <div class="col-sm-8">
              <div class="pull-left margin-lg-right">
                <div><label>Sort</label></div>
                <span class="sort btn btn-default asc" data-sort="opp-title">Sort by title</span>
                <span class="sort btn btn-default" data-sort="opp-price">Sort by price</span>
                <?php if ($wp_query->queried_object->category_parent == 0) { ?>
                  <span class="sort btn btn-default" data-sort="opp-event">Sort by event</span>
                <?php } ?>
              </div>

              <?php
              /* Is this is a parent category?
               * We'll want more display options.
    					 */ ?>
              <?php /* filter */ ?>
              <?php $this_category = get_category($cat); ?>
              <?php if ($this_category->category_parent == 0) { ?>
                <!-- display child categories -->
                <div class="pull-left margin-lg-left">
                  <div><label>Filter Events</label></div>
                  <div class="dropdown show">
                    <a class="btn btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <?php echo $this_category->cat_name; ?> <i class="fa fa-sort-desc text-gray" style="position: relative; top: -2px;" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                       <?php
                         wp_list_categories( array(
                           'child_of'           => $this_category->term_id,
                           'orderby'            => 'id',
                           'show_count'         => false,
                           'use_desc_for_title' => false,
                           'title_li'           => '',
                           'walker' => new Custom_Walker_Category
                         ) );
                       ?>
                    </ul>
                  </div>
                </div>
              <?php } else { ?>
                <!-- display same level categories  -->
                <div class="pull-left margin-lg-left">
                  <div><label>Filter Events</label></div>
                  <div class="dropdown show">
                    <a class="btn btn-default dropdown-toggle" href="#" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <?php echo $this_category->cat_name; ?> <i class="fa fa-sort-desc text-gray" style="position: relative; top: -2px;" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu">
                      <?php
                        // print_r($this_category);
                         wp_list_categories( array(
                           'child_of'           => $this_category->category_parent,
                           'orderby'            => 'id',
                           'show_count'         => false,
                           'use_desc_for_title' => false,
                           'current_category'   => $this_category->term_id,
                           'title_li'           => '',
                           'walker' => new Custom_Walker_Category
                         ) );
                       ?>
                     </ul>
                   </div>
                 </div>
               <?php } ?>


            </div>
          </div>

  	      <ul class="list">
  				<?php
  				// Start the Loop.
  				while ( have_posts() ) : the_post();


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
            if (!empty($meta[$level][0])) {
              $oppLevel = unserialize($meta[$level][0]);
            } else {
              $oppLevel = '';
            }
          ?>

  	        <li class="panel item" style="overflow: hidden">
  	          <?php if (!empty($meta['opp_sponsor_logos'])) { ?><div class="panel-heading logos clearfix"><?php } else { ?><div class="panel-heading clearfix"><?php } ?>

                <?php /* sort: price value */ ?>
  	            <?php if (!empty($meta['opp_numeric_cost'][0])) { echo '<span class="opp-price hidden">'.number_format($meta['opp_numeric_cost'][0]).'</span>'; } ?>

                <div class="pull-right margin-lg-left margin-sm-bottom">
                  <?php /* display price */ ?>
    	            <div class="opp-price">
    	              <?php if (!empty($meta['opp_total_cost'][0])) { ?>
    	                <?php echo $meta['opp_total_cost'][0]; ?>
    	              <?php } elseif ($meta['opp_numeric_cost'][0]) { ?>
    	                <?php echo '$'.number_format($meta['opp_numeric_cost'][0]); ?>
    	              <?php } ?>
    	            </div>

                  <?php /* display quantities */ ?>
                  <?php if (!empty($meta['opp_current_quantity'][0]) || !empty($meta['opp_total_quantity'][0])) { ?>
      	            <div class="opp-quantities text-right">
                      <h5>Quanitity:</h5>
      	              <?php if (!empty($meta['opp_current_quantity'][0])) { echo $meta['opp_current_quantity'][0]; } ?>
      	              <?php if (!empty($meta['opp_total_quantity'][0])) { echo '/'.$meta['opp_total_quantity'][0]; } ?>
      	            </div>
                  <?php } ?>
                </div>

                <div class="pull-left">

                  <?php /* parent? display child category/sub-event */ ?>
                  <?php
                  $my_post_categories = get_the_category();
                  $my_post_child_cats = array();
                  foreach ( $my_post_categories as $post_cat ) {
                    if ( 0 != $post_cat->category_parent ) {
                      $my_post_child_cats[] = $post_cat;
                    }
                  }
                  if ($wp_query->queried_object->category_parent == 0) { ?>
                    <h3 class="opp-event"><a href="<?php echo $my_post_child_cats[0]->slug; ?>" class="text-gray-light"><?php echo $my_post_child_cats[0]->name; ?></a></h3>
                  <?php } ?>


    	            <?php /* title, featured? */ ?>
    	            <h4 class="media-heading">
                    <?php if(!empty($meta['opp_featured'][0])) { ?><i class="fa fa-star-o" aria-hidden="true"></i><?php } ?>

                    <a data-toggle="collapse" data-parent="#base-sponsor-opp-accordion" data-field="opp-title" href="#<?php echo $post->post_name; ?>" class="collapsed title opp-title">
    	                <?php echo get_the_title(); ?> <span class="collapse-indicator fa fa-chevron-down"></span>
    	              </a>

                    <?php /* editors, edit! */ ?>
                    <?php if (is_user_logged_in() && current_user_can('edit_posts')) { ?>
											<span class="margin-lg-top margin-sm-left" data-toggle="modal" data-target="#editModal<?php echo get_the_ID(); ?>"><i class="fa fa-pencil text-gray-light" aria-hidden="true"></i></span>
										<?php } ?>
										<a class="margin-lg-top margin-sm-left" href="<?php the_permalink(); ?>" target="_blank"><i class="fa fa-eye text-gray-light" aria-hidden="true"></i></a>
                  </h4>
                  <?php if (is_user_logged_in() && current_user_can('edit_posts')) { ?><?php include(locate_template('templates/editpost.php')); ?><?php } ?>


                  <?php /* sold status, level, types */ ?>
    	            <div class="labels pull-left margin-lg-right">
                    <h5>Status:</h5><br>
                    <?php if (!empty($meta['opp_sold'][0])) { ?>
                      <span class="label label-danger">Sold</span>
                    <?php } else { ?>
                      <span class="label label-success">Available</span>
                    <?php } ?>
                  </div>

                  <?php if (!empty($meta[$level][0])) { ?>
                    <div class="pull-left margin-lg-right">
                      <h5>Level:</h5><br>
                      <span class="margin-sm-right label label-default <?php echo $meta[$level][0]; ?>"><?php echo $meta[$level][0]; ?></span>
                    </div>
                  <?php } ?>

                  <?php
                    if(is_array($theTypes)) {
                      echo '<div class="pull-left"><h5>Type/s:</h5><br>';
                      foreach($theTypes as $test=>$oppType) {
                        echo '<span class="margin-sm-right label label-default '.$oppType.'">'.$oppType.'</span>';
                      }
                      echo '</div>';
                    }
                  ?>
                  <?php if (!empty($meta['opp_level_pes'][0])) { ?><br><span class="pull-left margin-sm-right label label-default so-label <?php //echo levelClass($meta['opp_level_pes'][0]); ?>"><?php echo $meta['opp_level_pes'][0]; ?></span><?php } ?>

                </div><? /* done floating this section */ ?>

  	            <?php /* sponsor logo fields: uploaded */ ?>
  	            <?php if(!empty($meta['opp_sponsor_logos'])) {
  	              echo '<div class="pull-right">';
  	              foreach($meta['opp_sponsor_logos'] as $logo) {
                    $array = unserialize($logo);
	                  foreach($array as $img => $src) {
                      foreach($src as $imgpath) {
                        echo '<img src="'. $imgpath .'" alt="" class="margin-lg-left">';
                      }
	                  }
                  }
  	              echo '</div>';
  	            } ?>
                <?php /* sponsor logo fields:linked */ ?>
                <?php if(!empty($meta['opp_logos_paths'])) {
  	              echo '<div class="pull-right">';
  	              foreach($meta['opp_logos_paths'] as $logo) {
                    $array = unserialize($logo);
                    echo '<img src="'. $array[0] .'" alt="" class="margin-lg-left">';
                  }
  	              echo '</div>';
  	            } ?>

  	          </div><?php /* /.panel-heading */ ?>

  	          <div id="<?php echo $post->post_name; ?>" class="panel-body panel-collapse collapse">

                <div class="row">
                  <div class="col-sm-8">

      	            <?php /* do the content  */ ?>
      	            <?php if(!empty($meta['opp_excerpt'][0])) { echo '<h5>Excerpt:</h5><br><div class="margin-lg-bottom well">'.$meta['opp_excerpt'][0].'</div>'; } ?>
      	            <?php if(get_the_content()) {
                      echo '<h5>Content:</h5><br><div class="margin-lg-bottom well">';
                      echo the_content();
                      echo '</div>';
                    } ?>

                    <?php /* types */ ?>
                    <?php if (!empty($meta['opp_type_pes'])) { ?>
                      <h5>Types:</h5><br>
                      <ul class="margin-lg-bottom">
                        <?php foreach($meta['opp_type_pes'] as $type) {
                          $oppType = unserialize($type);
                          foreach($oppType as $k => $v) {
                            echo '<li>'.$v.'</li>';
                          }
                        } ?>
                      </ul>
                    <?php } ?>

      	            <?php /* supporting documents */ ?>
      	            <?php if(!empty($meta['opp_document'])) {
      	              echo '<div class="margin-lg-bottom"><h5>Supporting Documents:</h5><br>';
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
      	              echo '</div>';
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
                  </div>
                  <div class="col-sm-4">
                    <?php /* opp images  */ ?>
      	            <?php if(!empty($meta['opp_images'])) {
      	              foreach($meta['opp_images'] as $oppimg) {
                        $image = unserialize($oppimg);
    	                  foreach($image as $img => $src) {
                          foreach($src as $imgpath) {
                            echo '<img src="'. $imgpath .'" alt="" class="pull-right margin-lg-left margin-lg-bottom" width="200">';
                          }
    	                  }
                      }
      	            } ?>
                  </div>

                </div><?php /* row */ ?>
  	          </div><?php /* /.panel-body */ ?>

  	        </li><?php /* /.panel */

  				// End the loop.
  	    	endwhile; ?>

  	      </ul>

  		    <script src="http://listjs.com/assets/javascripts/list.min.js"></script>
  		    <script type="text/javascript">
  		      var options = {
  		          valueNames: [ 'opp-title', 'opp-price', 'opp-event' ]
  		      };
  		      var hackerList = new List('base-sponsor-opp-accordion', options);
  		    </script>
          <script>
            jQuery('#base-sponsor-opp-accordion').on('shown.bs.collapse', function (e) {
              jQuery(this).find('.in').prev('.panel-heading').addClass('straight');
            });
            jQuery('#base-sponsor-opp-accordion').on('hide.bs.collapse', function (e) {
              jQuery(this).find('.in').prev('.panel-heading').removeClass('straight');
            });
          </script>
  			</div><!-- /#sponsorship-opps -->

    <?php

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

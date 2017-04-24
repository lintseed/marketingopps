<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */

 /**
 * Category filter class
 */
 class Custom_Walker_Category extends Walker_Category {

   function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
           extract($args);
           $cat_name = esc_attr( $category->name );
           $cat_name = apply_filters( 'list_cats', $cat_name, $category );
           $link = '<a href="' . esc_url( get_term_link($category) ) . '" ';
           if ( $use_desc_for_title == 0 || empty($category->description) )
                   $link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '"';
           else
                   $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
           $link .= '>';
           $link .= $cat_name . '</a>';
           if ( !empty($feed_image) || !empty($feed) ) {
                   $link .= ' ';
                   if ( empty($feed_image) )
                           $link .= '(';
                   $link .= '<a href="' . esc_url( get_term_feed_link( $category->term_id, $category->taxonomy, $feed_type ) ) . '"';
                   if ( empty($feed) ) {
                           $alt = ' alt="' . sprintf(__( 'Feed for all posts filed under %s' ), $cat_name ) . '"';
                   } else {
                           $title = ' title="' . $feed . '"';
                           $alt = ' alt="' . $feed . '"';
                           $name = $feed;
                           $link .= $title;
                   }
                   $link .= '>';
                   if ( empty($feed_image) )
                           $link .= $name;
                   else
                           $link .= "<img src='$feed_image'$alt$title" . ' />';
                   $link .= '</a>';
                   if ( empty($feed_image) )
                           $link .= ')';
           }
           if ( !empty($show_count) )
                   $link .= ' (' . intval($category->count) . ')';
           if ( 'list' == $args['style'] ) {
                   $output .= "\t<li";
                   $class = 'dropdown-item cat-item-' . $category->term_id;


                   // YOUR CUSTOM CLASS
                   if ($depth)
                       $class .= ' sub-'.sanitize_title_with_dashes($category->name);


                   if ( !empty($current_category) ) {
                           $_current_category = get_term( $current_category, $category->taxonomy );
                           if ( $category->term_id == $current_category )
                                   $class .=  ' current-cat';
                           elseif ( $category->term_id == $_current_category->parent )
                                   $class .=  ' current-cat-parent';
                   }
                   $output .=  ' class="' . $class . '"';
                   $output .= ">$link\n";
           } else {
                   $output .= "\t$link<br />\n";
           }
   } // function start_el

 } // class Custom_Walker_Category


class WPQuestions_Walker extends Walker_Category {
  function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
    extract($args);

    $cat_name = esc_attr( $category->name );
    $cat_name = apply_filters( 'list_cats', $cat_name, $category );


    $termchildren = get_term_children( $category->term_id, $category->taxonomy );
    if (count($termchildren)>0) {
      $aclass = ' class="parent" ';
    }
    $link = '<a '.$aclass.' href="' . esc_url( get_term_link($category) ) . '" ';

    if ( $use_desc_for_title == 0 || empty($category->description) )
      $link .= 'title="' . esc_attr( sprintf(__( 'View all posts filed under %s' ), $cat_name) ) . '"';
    else
      $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
      $link .= '>';
      $link .= $cat_name . '</a>';

    if ( !empty($show_count) )
      $link .= ' (' . intval($category->count) . ')';

    if ( 'list' == $args['style'] ) {
      $output .= '<ul style="border:1px solid red">';
      $output .= "\t<li";
      $class = 'cat-item cat-item-' . $category->term_id;

      if ( !empty($current_category) ) {
        $_current_category = get_term( $current_category, $category->taxonomy );
        if ( $category->term_id == $current_category )
          $class .= ' current-cat';
        elseif ( $category->term_id == $_current_category->parent )
          $class .= ' current-cat-parent';
      }

      $output .= ' class="' . $class . '"';
      $output .= ">$link\n";
      $output .= '</ul>';
    } else {
      $output .= "\t$link<br />\n";
    }

  }
}

/**
* Frontend post editing
*/
function frontend_update_opp() {
  if ( empty($_POST['frontend']) || empty($_POST['ID']) || empty($_POST['post_type']) || $_POST['post_type'] != 'opportunity' ) {
    return;
  }
  // $post global is required so save_opp_custom_fields() doesn't error out
  global $post;
  $post = get_post($_POST['ID']);
  global $wpdb;
  $post_id = wp_update_post( $_POST );
}
add_action('init', 'frontend_update_opp');

function save_opp_custom_fields(){
  global $post;

  if ($post) {
    update_post_meta($post->ID, "opp_excerpt", @$_POST["opp_excerpt"]);
    update_post_meta($post->ID, "opp_sold", @$_POST["opp_sold"]);
    update_post_meta($post->ID, "opp_enabled", @$_POST["opp_enabled"]);
    update_post_meta($post->ID, "opp_featured", @$_POST["opp_featured"]);
    update_post_meta($post->ID, "opp_deadline", @$_POST["opp_deadline"]);
    update_post_meta($post->ID, "opp_current_quantity", @$_POST["opp_current_quantity"]);
    update_post_meta($post->ID, "opp_total_quantity", @$_POST["opp_total_quantity"]);
    update_post_meta($post->ID, "opp_numeric_cost", @$_POST["opp_numeric_cost"]);
    update_post_meta($post->ID, "opp_total_cost", @$_POST["opp_total_cost"]);
    update_post_meta($post->ID, "opp_contact", @$_POST["opp_contact"]);
    update_post_meta($post->ID, "opp_contact_2", @$_POST["opp_contact_2"]);
  }
}
add_action( 'save_post', 'save_opp_custom_fields' );


$sage_includes = [
  'lib/assets.php',    // Scripts and stylesheets
  'lib/extras.php',    // Custom functions
  'lib/setup.php',     // Theme setup
  'lib/titles.php',    // Page titles
  'lib/wrapper.php',   // Theme wrapper class
  'lib/customizer.php' // Theme customizer
];

foreach ($sage_includes as $file) {
  if (!$filepath = locate_template($file)) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);

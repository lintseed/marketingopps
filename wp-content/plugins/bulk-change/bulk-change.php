<?php

/**
 * Plugin Name: Bulk change of posts terms and post types
 * Plugin URI: http://wordpress.org/extend/plugins/bulk-change/
 * Description: Bulk change of posts categories,terms and post types
 * Version: 1.0
 * Author: Hmayak Tigranyan
 * Author URI: http://www.hmayaktigranyan.com/
 * Tags: bulk change, mass change, custom post ,post type chnage, term change, terms, custom post types,taxonomy ,custom posts , post types, plugin,
 * License: GPL

  =====================================================================================
  Copyright (C) 2013 Hmayak Tigranyan

  This program is free software; you can redistribute it and/or
  modify it under the terms of the GNU General Public License
  as published by the Free Software Foundation; either version 2
  of the License, or (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
  =====================================================================================
 */
class Wordpress_BCTP {

    public function init() {
        add_action('admin_menu', array(&$this, 'registerToolsPage'));

    }

    function registerToolsPage() {
        add_management_page('Bulk posts change', 'Bulk posts change', 8, __FILE__, array(&$this, 'showToolsPage'));
    }

    function showToolsPage() {
        

        if ($_GET['bctp_action']) {
            if ($_GET['postid']) {
                $postids = $_GET['postid'];
                $postids = array_map('intval', $postids);
                $postids = array_unique($postids);
            }
            foreach ($postids as $postId) {

                if ($new_post_type_object = get_post_type_object($_GET['change_posttype'])) {
                    /*$po = array();
                    $po = get_post($postId,'ARRAY_A');
                    $po['post_type'] = $_GET['change_posttype'];
                    wp_update_post($po);*/
            
                    set_post_type($postId, $new_post_type_object->name);
                    if(is_plugin_active("sitepress-multilingual-cms/sitepress.php")){
                        global $wpdb,$table_prefix;

                        include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );

                        $trrows = $wpdb->get_results("SELECT * FROM ".$table_prefix."icl_translations  where trid=( select trid from ".$table_prefix."icl_translations where element_id=" . $postId . ")");
                       if ($trrows && is_array($trrows)) {
                            foreach ($trrows as $trrow) {
                                set_post_type($trrow->element_id, $new_post_type_object->name);
                            }
                            $wpdb->query("update ".$table_prefix."icl_translations set element_type='post_" .$new_post_type_object->name . "'  where trid=" . $trrow->trid);
                        }
                    }
                }

                $termsToChange = $_GET['change']['terms'];
                if ($termsToChange) {
                    foreach ($termsToChange as $taxanomy => $terms) {
                        if ($_GET['bctp_action'] == "remove") {
                            $oldTerms = wp_get_object_terms($postId, $taxanomy, array('fields' => 'ids'));
                            $newTerms = array_diff($oldTerms, $terms);
                        } elseif ($_GET['bctp_action'] == "add") {
                            $oldTerms = wp_get_object_terms($postId, $taxanomy, array('fields' => 'ids'));
                            $newTerms = array_merge($oldTerms, $terms);
                        } else {
                            $newTerms = $terms;
                        }
                        if (!empty($newTerms)) {
                            $newTerms = array_map('intval', $newTerms);
                            $newTerms = array_unique($newTerms);
                        }

                        $res = wp_set_object_terms($postId, $newTerms, $taxanomy);
                        
                        
                    }
                }
                
            }
            echo "<div class='updated fade'><p><strong>UPDATED</strong></p></div>";
        }
        $per_page = absint($_GET['per_page']);
        if (!$per_page) {
            $per_page = 10;
        }
        $terms = $_GET['search']['terms'];
        $taxonomies = get_taxonomies(array('show_ui' => true));

        $query_terms = array();
        if (is_array($terms)) {
            foreach ($terms as $taxanomy => $terms) {
                foreach ($terms as $term) {
                    $term_array = get_term_by('id', $term, $taxanomy, 'ARRAY_A');
                    if (isset($query_terms[$taxanomy])) {
                        $query_terms[$taxanomy] = $query_terms[$taxanomy] . "," . $term_array["slug"];
                    } else {
                        $query_terms[$taxanomy] = $term_array["slug"];
                    }
                }
            }
        }
        if (isset($query_terms['category'])) {
            $query_terms['category_name'] = $query_terms['category'];
        }
        $args = $query_terms;

        $args['showposts'] = $per_page;

        $args['post_type'] = $_GET['search']['posttypes'];
        ?>
        <form method="get" action="tools.php">
            <input type="hidden" name="page" value="bulk-change/bulk-change.php" />
            <div class="wrap">
                <h2>Bulk change of posts terms and post types</h2>
                <div>
                    <span>
                        <select multiple="multiple"  name="search[posttypes][]" >
                            <option value="">Post types</option>
                            <?php
                            $post_types = get_post_types(array('show_ui' => true));

                            foreach ($post_types as $post_type) {
                                $pt = get_post_type_object($post_type);

                                $option = '<option value="' . $post_type;
                                if (is_array($_GET['search']['posttypes']) && in_array($post_type, $_GET['search']['posttypes'])) {
                                    $option .='" selected="selected';
                                }
                                $option .= '">';
                                $option .= $pt->labels->singular_name;
                                $option .= '</option>';
                                echo $option;
                            }
                            ?>
                        </select>
                    </span>
                    <?php
                    foreach ($taxonomies as $taxonomyslug) {
                        $taxonomy = get_taxonomy($taxonomyslug);
                        ?>
                        <span>
                            <select multiple="multiple"  name="search[terms][<?php echo $taxonomyslug ?>][]" >
                                <option value=""><?php echo $taxonomy->labels->name ?></option>
                                <?php
                                $terms = get_terms($taxonomyslug, 'hide_empty=0');

                                if (!is_wp_error($terms)) {
                                    foreach ($terms as $term) {

                                        $option = '<option value="' . $term->term_id;
                                        if (is_array($_GET['search']['terms'][$taxonomyslug]) && in_array($term->term_id, $_GET['search']['terms'][$taxonomyslug])) {
                                            $option .='" selected="selected';
                                        }
                                        $option .= '">';
                                        $option .= $term->name;
                                        $option .= '</option>';
                                        echo $option;
                                    }
                                }
                                ?>
                            </select>
                        </span>
                        <?php
                    }
                    ?>
                    <br/>
                    <span>
                        <label for="input_keyword">Keyword:</label>
                        <input type="text" id="input_keyword" value="<?php echo $_GET['s'] ?>">
                    </span>

                    <span>
                        <label>Per page:</label>
                        <input type="text" name="per_page" value="<?php echo $per_page; ?>" size="5" />
                    </span>
                    <span><input type="submit" id="btn_bcat_search"  name="dosearch" value="Search ..." class="button-secondary"></span>
                </div> 
                <div>
                    <div class="tablenav">
                        <div class="tablenav-pages">
                            <?php
                            $query = new WP_Query;

                            if (absint($_GET['paged'])) {
                                $args['paged'] = absint($_GET['paged']);
                            }
                            $posts = $query->query($args);



                            $page_links = paginate_links(array(
                                'base' => add_query_arg('paged', '%#%'),
                                'format' => '',
                                'prev_text' => __('&laquo;'),
                                'next_text' => __('&raquo;'),
                                'total' => $query->max_num_pages,
                                'current' => isset($_GET['paged']) ? $_GET['paged'] : 1
                                    ));
                            echo $page_links;
                            ?>


                        </div>
                    </div>
                    <!--Select all results in all pages:<input name="all_results"  type="checkbox" id="toggle_posts_all" title="Select all results">
                    --><table class="widefat">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="toggle_posts" title="Select all posts">
                                </th>
                                <th>Title</th>
                                <th>Post type</th>
                                <th>Categories,Terms</th>
                            </tr>
                        </thead>
                        <tbody id="the-list">
        <?php
        $siteurl = get_option('siteurl');

        foreach ($posts as $post) {
            ?>
                                <tr class="alternate">
                                    <td><input type="checkbox" name="postid[]" value="<?php echo $post->ID ?>"></td>
                                    <td><a href="<?php echo $siteurl ?>/wp-admin/post.php?post=<?php echo $post->ID ?>&action=edit"><?php echo $post->post_title ?></a></td>
                                    <td><?php echo get_post_type($post->ID) ?></td>
                                    <td><?php
                    $first = true;
                    foreach ($taxonomies as $taxonomyslug) {
                        if (!$first) {
                            echo "<br/>";
                        }
                        $first = false;
                        echo get_the_term_list($post->ID, $taxonomyslug, "", ",");
                    }
            ?></td>
                                </tr>
                                        <?php
                                    }
                                    ?>
                        </tbody>
                    </table>
                </div>
                <br><br>
                <h2>Change to </h2>
                <span>
                    <select  name="change_posttype" >
                        <option value="">Post type</option>
        <?php
        $post_types = get_post_types();

        foreach ($post_types as $post_type) {
            $pt = get_post_type_object($post_type);

            $option = '<option value="' . $post_type;
            $option .= '">';
            $option .= $pt->labels->singular_name;
            $option .= '</option>';
            echo $option;
        }
        ?>
                    </select>
                </span>
        <?php
        $taxonomies = get_taxonomies(array('show_ui' => true));
        foreach ($taxonomies as $taxonomyslug) {
            $taxonomy = get_taxonomy($taxonomyslug);
            ?>
                    <span>
                        <select multiple="multiple"  name="change[terms][<?php echo $taxonomyslug ?>][]" >
                            <option value=""><?php echo $taxonomy->labels->name ?></option>
            <?php
            $terms = get_terms($taxonomyslug, 'hide_empty=0');

            if (!is_wp_error($terms)) {
                foreach ($terms as $term) {

                    $option = '<option value="' . $term->term_id;
                    $option .= '">';
                    $option .= $term->name;
                    $option .= '</option>';
                    echo $option;
                }
            }
            ?>
                        </select>
                    </span>
            <?php
        }
        ?>
                <div class="tablenav bottom">

                    <div class="alignleft actions">
                        <select name='bctp_action'>
                            <option value='' selected='selected'>Bulk Actions</option>
                            <option value='add' >Add to posts</option>
                            <option value='set' >Set to posts</option>
                            <option value='remove' >Remove from posts</option>
                        </select>
                        <input type="submit" name="" id="doaction" class="button-secondary action" value="Apply"  />
                    </div>

                </div>
        </form>
        <script>
            jQuery('#toggle_posts').change(function(){
                jQuery('input:checkbox[name="postid[]"]').each(function(){
                    jQuery(this)[0].checked = jQuery('#toggle_posts')[0].checked;
                });
                    
            });
        </script>
        <?php
    }

}

$bctp_plugin = new Wordpress_BCTP();
$bctp_plugin->init();
?>
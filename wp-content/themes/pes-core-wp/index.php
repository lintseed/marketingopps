<?php get_template_part('templates/page', 'header'); ?>

<p>Please select an event to browse opportunities:</p>
<ul id="cat-nav" class="lead list-group">
   <?php
     wp_list_categories( array(
       'orderby'            => 'id',
       'show_count'         => true,
       'use_desc_for_title' => false,
       'title_li'           => '',
       'walker'             => new cat_walker,
       'show_count'=> 1,
     ) );
   ?>
</ul>

<?php get_template_part('templates/page', 'header'); ?>

<p>Please select an event to browse opportunities:</p>
<ul class="lead">
   <?php
     wp_list_categories( array(
       'orderby'            => 'id',
       'show_count'         => false,
       'use_desc_for_title' => false,
       'title_li'           => '',
     ) );
   ?>
</ul>

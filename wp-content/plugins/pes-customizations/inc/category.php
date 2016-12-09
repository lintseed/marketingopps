<?php
/**
 * ...
 */
function renameCategory() {
  global $wp_taxonomies;
  $cat = $wp_taxonomies['category'];
  $cat->label = 'Events';
  $cat->label = 'Events';
  $cat->labels->singular_name = 'Event';
  $cat->labels->plural_name = 'Events';
  $cat->labels->menu_name = 'Events';
  $cat->labels->all_items = 'All Events';
  $cat->labels->edit_item = 'Edit Event';
  $cat->labels->view_item = 'View Event';
  $cat->labels->update_item = 'Update Event';
  $cat->labels->add_new_item = 'Add New Event';
  $cat->new_item_name = 'New Event Name';
  $cat->parent_item = 'Parent Event';
  $cat->parent_item_colon = 'New Event:';
  $cat->search_items = 'Search Events';
  $cat->popular_items = 'Popular Events';
  $cat->separate_items_with_commas = 'Separate events with commas';
  $cat->add_or_remove_items = 'Add or remove events';
  $cat->choose_from_most_used ='Choose from the most used events';
  $cat->not_found = 'No events found.';

  $cat->labels->name = $cat->label;
  $cat->labels->menu_name = $cat->label;
}
add_action('init', 'renameCategory');

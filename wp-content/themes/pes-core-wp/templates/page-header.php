<?php use Roots\Sage\Titles; ?>

<div class="page-header">
  <?php if (is_front_page()) { ?>
    <h1>Event List</h1>
  <?php } else { ?>
    <h1><?= Titles\title(); ?></h1>
  <?php } ?>
</div>

<?php
// $Id$

/**
 * @file
 * Display Suite 3 column template.
 */
?>

<div class="group-left">
  <?php print ds_render_region($content, 'left', $ds_layout); ?>
</div>

<div class="group-middle">
  <?php print ds_render_region($content, 'middle', $ds_layout); ?>
</div>

<div class="group-right">
  <?php print ds_render_region($content, 'right', $ds_layout); ?>
</div>

<div class="clear-fix"></div>
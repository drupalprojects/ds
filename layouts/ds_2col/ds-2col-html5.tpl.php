<?php
// $Id$

/**
 * @file
 * Display Suite 2 column template HTML 5 version.
 */
?>

<aside>
  <?php print ds_render_region($content, 'left', $ds_layout); ?>
</aside>

<aside>
  <?php print ds_render_region($content, 'right', $ds_layout); ?>
<aside>

<div class="clear-fix"></div>
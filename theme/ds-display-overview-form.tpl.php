<?php
// $Id$

/**
 * @file
 *   Template file for the display settings overview form
 *
 * @var
 * $build_mode String
 *   Current selected display mode
 * $rows Array of field objects
 *   Fields declared in drupal core and custom fields
 *   Properties (human_name, weight, stickyorder, build_mode, class, label_class)
 */

// Synced.
if ($synced) {
  print $synced;
}

if ($rows): ?>

<div id="ds-display-content">
  <div id="ds-tabs">
    <div id="field-tab" class="tab selected"><a href="javascript:;" onClick="Drupal.DisplaySuite.toggleDisplayTab('field-tab'); return false;"><?php print t('Fields'); ?></a></div>
    <?php if ($sync_copy_tab): ?>
      <div id="sync-copy-tab" class="tab"><a href="javascript:;" onClick="Drupal.DisplaySuite.toggleDisplayTab('sync-copy-tab'); return false;"><?php print t('Sync / copy'); ?></a></div>
    <?php endif; ?>
    <?php if (!empty($plugins_tabs)): ?>
      <?php foreach ($plugins_tabs as $key => $title): ?>
      <div id="<?php print $key; ?>-tab" class="tab"><a href="javascript:;" onClick="Drupal.DisplaySuite.toggleDisplayTab('<?php print $key; ?>-tab'); return false;"><?php print $title; ?></a></div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  <div style="clear: both"></div>

  <div id="field-content" class="ds-display">

    <table id="fields" class="sticky-enabled">
      <thead>
        <tr>
          <th><?php print t('Field'); ?></th>
          <th><?php print t('Label'); ?></th>
          <th><?php print t('Format'); ?></th>
          <th><?php print t('Style'); ?></th>
          <th><?php print t('Region'); ?></th>
          <th><?php print t('Weight'); ?></th>
        </tr>
      </thead>
      <tbody>

      <!-- Node regions -->
      <?php foreach ($regions as $region => $title): ?>
        <tr class="region region-<?php print $region?> tabledrag-leaf">
          <td colspan="6" class="region">
            <?php print $title; ?>
            <input type="hidden" class="ds-field-id" value="" size="2" id="edit-<?php print $region; ?>-full-field-id" name="region_<?php print $region; ?>[full][field_id]" maxlength="128"/>
            <input type="hidden" class="ds-parent-id" value="" size="2" id="edit-<?php print $region; ?>-full-parent-id" name="region_<?php print $region; ?>[full][parent_id]" maxlength="128"/>
          </td>
        </tr>
        <tr class="tabledrag-leaf region-message region-<?php print $region?>-message <?php print empty($rows[$region]) ? 'region-empty' : 'region-populated'; ?>">
          <td colspan="6">
          <em><?php print t('No fields in this region'); ?></em>
            <input type="hidden" class="ds-field-id" value="" size="2" id="edit-<?php print $region; ?>empty-full-field-id" name="empty<?php print $region; ?>[full][field_id]" maxlength="128"/>
            <input type="hidden" class="ds-parent-id" value="" size="2" id="edit-<?php print $region; ?>empty-full-parent-id" name="empty<?php print $region; ?>[full][parent_id]" maxlength="128"/>
          </td>
        </tr>

        <!-- fields -->
        <?php
        if (!empty($rows[$region])):
          $count = 0;
          foreach ($rows[$region] as $row): ?>
            <tr class="<?php print $count % 2 == 0 ? 'odd' : 'even'; ?> <?php print $row->class ?>">
              <td class="ds-label">
              <?php print $row->{$build_mode}->indentation; ?>
              <span class="<?php print $row->label_class; ?>"><?php print $row->human_name; ?></span><span class="label-edit"><?php print $row->{$build_mode}->label_edit; ?></span><?php print $row->{$build_mode}->label_value; ?></td>
              <td><?php print $row->{$build_mode}->label; ?></td>
              <td><?php print $row->{$build_mode}->format; ?></td>
              <td><?php print $row->{$build_mode}->class . $row->{$build_mode}->field_id . $row->{$build_mode}->parent_id; ?></td>
              <td><?php print $row->{$build_mode}->region; ?></td>
              <td><?php print $row->ds_weight; ?></td>
            </tr>
            <?php
            $count++;
          endforeach;
        endif;
      endforeach;
      ?>
      </tbody>
    </table>
  </div>
  <?php if ($sync_copy_tab): ?>
    <div id="sync-copy-content" class="ds-hidden"><?php print $sync_copy_tab; ?></div>
  <?php endif; ?>
  <?php if (!empty($plugins_tabs)): ?>
    <?php foreach ($plugins_content as $key => $form): ?>
      <div id="<?php print $key; ?>-content" class="ds-hidden"><?php print $form; ?></div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>
<?php
print $submit;
endif;

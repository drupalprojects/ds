<?php

/**
 * @file
 * Contains \Drupal\ds\Plugin\DsFieldLayout\Expert.
 */

namespace Drupal\ds\Plugin\DsFieldLayout;
use Drupal\Component\Utility\String;
use Drupal\Component\Utility\Xss;

/**
 * Plugin for the expert field template.
 *
 * @DsFieldLayout(
 *   id = "expert",
 *   title = @Translation("Expert"),
 *   theme = "theme_ds_field_expert",
 *   path = "includes/theme.inc"
 * )
 */
class Expert extends DsFieldLayoutBase {

  /**
   * {@inheritdoc}
   */
  public function alterForm(&$form) {
    $config = $this->getConfiguration();

    parent::alterForm($form);

    // We are going to move this to a different spot
    unset($form['lb-col']);

    $wrappers = array(
      'lbw' => array('title' => t('Label')),
      'ow' => array('title' => t('Outer wrapper')),
      'fis' => array('title' => t('Field items')),
      'fi' => array('title' => t('Field item')),
    );

    foreach ($wrappers as $wrapper_key => $value) {
      $form[$wrapper_key] = array(
        '#type' => 'checkbox',
        '#title' => $value['title'],
        '#prefix' => '<div class="ft-group ' . $wrapper_key . '">',
        '#default_value' => $config[$wrapper_key],
      );
      $form[$wrapper_key . '-el'] = array(
        '#type' => 'textfield',
        '#title' => t('Element'),
        '#size' => '10',
        '#description' => t('E.g. div, span, h2 etc.'),
        '#default_value' => $config[$wrapper_key . '-el'],
      );
      $form[$wrapper_key . '-cl'] = array(
        '#type' => 'textfield',
        '#title' => t('Classes'),
        '#size' => '10',
        '#default_value' => $config[$wrapper_key . '-cl'],
        '#description' => t('E.g.') .' field-expert',
      );
      $form[$wrapper_key . '-at'] = array(
        '#type' => 'textfield',
        '#title' => t('Attributes'),
        '#size' => '20',
        '#default_value' => $config[$wrapper_key . '-at'],
        '#description' => t('E.g. name="anchor"'),
      );

      // Hide colon.
      if ($wrapper_key == 'lbw') {
        $form['lb-col'] = array(
          '#type' => 'checkbox',
          '#title' => t('show label colon'),
          '#default_value' => $config['lb-col'],
          '#attributes' => array(
            'class' => array('colon-checkbox'),
          ),
        );
      }
      $form[$wrapper_key . '-def-at'] = array(
        '#type' => 'checkbox',
        '#title' => t('Add default attributes'),
        '#default_value' => $config[$wrapper_key . '-def-at'],
        '#suffix' => ($wrapper_key == 'ow') ? '' : '</div><div class="clearfix"></div>',
      );

      // Default classes for outer wrapper.
      if ($wrapper_key == 'ow') {
        $form[$wrapper_key . '-def-cl'] = array(
          '#type' => 'checkbox',
          '#title' => t('Add default classes'),
          '#default_value' => $config[$wrapper_key . '-def-cl'],
          '#suffix' => '</div><div class="clearfix"></div>',
        );
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $config = parent::defaultConfiguration();

    $wrappers = array(
      'lbw' => array('title' => t('Label')),
      'ow' => array('title' => t('Outer wrapper')),
      'fis' => array('title' => t('Field items')),
      'fi' => array('title' => t('Field item')),
    );
    foreach ($wrappers as $wrapper_key => $value) {
      $config[$wrapper_key] = FALSE;
      $config[$wrapper_key . '-el'] = '';
      $config[$wrapper_key . '-at'] = '';
      $config[$wrapper_key . '-cl'] = '';

      $config[$wrapper_key . '-def-at'] = FALSE;
      $config[$wrapper_key . '-def-cl'] = FALSE;
    }

    return $config;
  }

  /**
   * {@inheritdoc}
   */
  public function massageRenderValues(&$field_settings, $values) {
    parent::massageRenderValues($field_settings, $values);

    $wrappers = array(
      'lbw' => t('Label wrapper'),
      'ow' => t('Wrapper'),
      'fis' => t('Field items'),
      'fi' => t('Field item')
    );

    foreach ($wrappers as $wrapper_key => $title) {
      if (!empty($values[$wrapper_key])) {
        // Enable.
        $field_settings[$wrapper_key] = TRUE;
        // Element.
        $field_settings[$wrapper_key . '-el'] = !(empty($values[$wrapper_key . '-el'])) ? String::checkPlain($values[$wrapper_key . '-el']) : 'div';
        // Classes.
        $field_settings[$wrapper_key . '-cl'] = !(empty($values[$wrapper_key . '-cl'])) ? String::checkPlain($values[$wrapper_key . '-cl']) : '';
        // Default Classes.
        if (in_array($wrapper_key, array('ow', 'lb'))) {
          $field_settings[$wrapper_key . '-def-cl'] = !(empty($values[$wrapper_key . '-def-cl'])) ? TRUE : FALSE;
        }
        // Attributes.
        $field_settings[$wrapper_key . '-at'] = !(empty($values[$wrapper_key . '-at'])) ? Xss::filter($values[$wrapper_key . '-at']) : '';
        // Default attributes.
        $field_settings[$wrapper_key . '-def-at'] = !(empty($values[$wrapper_key . '-def-at'])) ? TRUE : FALSE;
      }
    }
  }
}

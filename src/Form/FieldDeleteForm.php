<?php

/**
 * @file
 * Contains \Drupal\ds\Form\FieldDeleteForm.
 */

namespace Drupal\ds\Form;

use Drupal\Core\Cache\CacheTagsInvalidator;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Config\ConfigFactory;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Provides a form to delete a DS field.
 */
class FieldDeleteForm extends ConfirmFormBase implements ContainerInjectionInterface {

  /**
   * Stores the configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Holds the cache invalidator
   *
  * @var \Drupal\Core\Cache\CacheTagsInvalidatorInterface
*/
  protected $cacheInvalidator;

  /**
   * The field being deleted
   *
   * @var array
   */
  protected $field;

  /**
   * Constructs a FieldDeleteForm object.
   *
   * @param \Drupal\Core\Cache\CacheTagsInvalidatorInterface
   *   The cache invalidator.
   * @param \Drupal\Core\Config\ConfigFactory $config_factory
   *   The factory for configuration objects.
   */
  public function __construct(CacheTagsInvalidator $cache_invalidator, ConfigFactory $config_factory) {
    $this->cacheInvalidator = $cache_invalidator;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('cache_tags.invalidator'), $container->get('config.factory'));
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete %field ?', array('%field' => $this->field['label']));
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('ds.fields_list');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'field_delete_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, Request $request = NULL, $field = '') {
    $config = $this->configFactory->get('ds.field.' . $field);
    $this->field = $config->get();

    if (empty($this->field)) {
      drupal_set_message(t('Field not found.'));
      return new RedirectResponse('/admin/structure/ds/fields');
    }

    return parent::buildForm($form, $form_state, $request);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field = $this->field;

    // Remove field and clear caches.
    $this->configFactory->get('ds.field.' . $field['id'])->delete();
    $this->cacheInvalidator->invalidateTags(array('ds_fields_info'));

    // Also clear the ds plugin cache
    \Drupal::service('plugin.manager.ds')->clearCachedDefinitions();

    // Redirect.
    $url = new Url('ds.fields_list');
    $form_state->setRedirectUrl($url);
    drupal_set_message(t('The field %field has been deleted.', array('%field' => $field['label'])));
  }

}

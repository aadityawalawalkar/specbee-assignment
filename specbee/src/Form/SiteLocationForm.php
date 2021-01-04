<?php

namespace Drupal\specbee\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SiteLocationForm.
 */
class SiteLocationForm extends ConfigFormBase {

  /**
   *  Specbee Site Timezone Service.
   *
   * @var \Drupal\specbee\SpecbeeSiteTimezone
   */
  protected $siteTimezone;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->siteTimezone = $container->get('specbee.site_timezone');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'specbee.sitelocation',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_loc_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('specbee.sitelocation');
    $form['country'] = [
      '#type' => 'textfield',
      '#size' => 40,
      '#required' => TRUE,
      '#title' => $this->t('Country'),
      '#description' => $this->t('Name of the Country.'),
      '#default_value' => $config->get('country'),
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#size' => 40,
      '#required' => TRUE,
      '#title' => $this->t('City'),
      '#description' => $this->t('Name of the City.'),
      '#default_value' => $config->get('city'),
    ];
    $form['timezone'] = array(
      '#type' => 'select',
      '#required' => TRUE,
      '#title' => t('Select Timezone'),
      '#description' => 'Select the desired timezone.',
      '#options' => $this->siteTimezone->listTimezones(),
      '#default_value' => $config->get('timezone'),
    );
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $this->config('specbee.sitelocation')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();
  }

}

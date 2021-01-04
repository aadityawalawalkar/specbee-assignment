<?php

namespace Drupal\specbee\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SpecbeeSiteLocTimeBlock' block.
 *
 * @Block(
 *  id = "specbee_site_loc_time_block",
 *  admin_label = @Translation("Specbee Site Location & Time block"),
 * )
 */
class SpecbeeSiteLocTimeBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   *  Specbee Site Timezone Service.
   *
   * @var \Drupal\specbee\SpecbeeSiteTimezone
   */
  protected $config;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    $instance = new static($configuration, $plugin_id, $plugin_definition);
    $instance->siteTimezone = $container->get('specbee.site_timezone');
    return $instance;
  }

  // public function getCacheMaxAge() {
  //   return 0;
  // }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    // Custom theme name.
    $build['#theme'] = 'specbee_site_loc_time_block';
    // $build['#cache']['max-age'] = 0;
    // Add configuration cache tags.
    $location = $this->siteTimezone->getLocation();
    // Pass content variable to twig template.
    if ($location) {
      $build['#content']['location'] = $this->t("Location: " . $location);
      $build['#content']['time'] = $this->t("Time: " . $this->siteTimezone->getTimeByTimezone());
    }
    $build['#cache']['tags'] = ['config:specbee.sitelocation'];
    return $build;
  }

}

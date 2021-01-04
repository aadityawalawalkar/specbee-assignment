<?php

namespace Drupal\specbee;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class SpecbeeSiteTimezone.
 */
class SpecbeeSiteTimezone {

  /**
   * Drupal\Core\Config\ConfigFactoryInterface definition.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Drupal\Core\Datetime\DateFormatterInterface definition.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * Constructs a new SpecbeeSiteTimezone object.
   */
  public function __construct(ConfigFactoryInterface $config_factory, DateFormatterInterface $date_formatter) {
    $this->configFactory = $config_factory;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * Function to return timezones.
   */
  public function listTimezones() {
    return [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London',
    ];
  }

  /**
   * Function to fetch time by timezone.
   *
   * @return string
   *   Return time by timezone from config.
   */
  public function getTimeByTimezone() {
    $timezone = $this->configFactory->get('specbee.sitelocation')->get('timezone');
    $time = $this->dateFormatter->format(strtotime('now'), 'custom', 'dS M Y - h:i A', $timezone);
    return $time;
  }

  /**
   * Function to fetch city & country from config.
   *
   * @return string
   *   Return city & coutry from config.
   */
  public function getLocation() {
    $city = $this->configFactory->get('specbee.sitelocation')->get('city');
    $country = $this->configFactory->get('specbee.sitelocation')->get('country');

    if ($city & $country) {
      return $city . ', ' . $country;
    }
    else {
      return '';
    }
  }

}

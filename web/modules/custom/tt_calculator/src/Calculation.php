<?php

namespace Drupal\tt_calculator;

use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Defines Calculation service.
 */
class Calculation implements CalculationInterface {

  /**
   * The config factory service.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Calculation constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory service.
   */
  public function __construct(ConfigFactoryInterface $config_factory) {
    $this->configFactory = $config_factory;
  }
  /**
   * {@inheritdoc}
   */
  public function getTotalPrice($age, $car_size) {
    $config = $this->configFactory->get('tt_calculator.settings');
    $k_age = self::AGE_MULTIPLIER[$age];
    $k_car_size = self::CAR_SIZE_MULTIPLIER[$car_size];

    $total_price = $config->get('fixed_price') + $config->get('variable_price') *
      (1 + $k_age + $k_car_size);

    return round($total_price);
  }
}
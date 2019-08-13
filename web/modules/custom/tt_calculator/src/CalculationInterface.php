<?php

namespace Drupal\tt_calculator;

/**
 * Defines interface for Calculation service.
 */
interface CalculationInterface {

  /**
   * Contains age options.
   */
  const AGE = [
    0 => '<20',
    1 => '20-24',
    2 => '25+',
  ];

  /**
   * Contains multiplier for age.
   */
  const AGE_MULTIPLIER = [
    1 => 0,
    1 => 0.2,
    2 => 0,
  ];

  /**
   * Contains car size options.
   */
  const CAR_SIZE = [
    'small' => 'Small',
    'medium' => 'Medium',
    'large' => 'Large',
  ];

  /**
   * Contains multiplier for car size.
   */
  const CAR_SIZE_MULTIPLIER = [
    'small' => 0,
    'medium' => 0.5,
    'large' => 1,
  ];

  /**
   * Calculates total price, based on user input.
   *
   * @param int $age
   * @param string $car_size
   *
   * @return int
   */
  public function getTotalPrice($age, $car_size);

}

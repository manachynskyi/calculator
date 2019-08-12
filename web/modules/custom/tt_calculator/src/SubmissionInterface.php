<?php

namespace Drupal\tt_calculator;

/**
 * Defines interface for storing calculation submissions.
 */
interface SubmissionInterface {

  /**
   * Add submission record to DB.
   *
   * @param string $name
   * @param string $total_price
   *
   * @return void
   */
  public function addSubmission($name, $total_price);
}
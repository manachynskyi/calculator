<?php

namespace Drupal\tt_calculator;

use Drupal\Core\Database\Driver\mysql\Connection;

/**
 * Defines SubmissionInterface service.
 */
class Submission implements SubmissionInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Creates an InlineBlockUsage object.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   */
  public function __construct(Connection $database) {
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public function addSubmission($name, $total_price) {
    $this->database
      ->insert('calculation_submissions')
      ->fields([
        'name' => $name,
        'total_price' => $total_price,
      ])
      ->execute();
  }

}

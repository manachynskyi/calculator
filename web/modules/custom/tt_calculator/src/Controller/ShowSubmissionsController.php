<?php

namespace Drupal\tt_calculator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides page callback for showing submissions.
 */
class ShowSubmissionsController extends ControllerBase {

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
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * Show last 20 calculator submissions.
   *
   * @return array
   *   Page render array.
   */
  public function showSubmissions() {
    $result = $this->database
      ->select('calculation_submissions', 'cs')
      ->fields('cs')
      ->orderBy('cs.id', 'DESC')
      ->range(0, 20)
      ->execute()
      ->fetchAll();

    $rows = [];

    foreach ($result as $item) {
      $rows[] = [
        $item->id,
        $item->name,
        $item->total_price,
      ];
    }

    return [
      '#theme' => 'table',
      '#header' => ['Id', 'Name', 'Total price'],
      '#rows' => $rows,
    ];
  }

}

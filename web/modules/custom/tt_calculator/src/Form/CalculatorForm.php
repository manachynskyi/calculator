<?php

namespace Drupal\tt_calculator\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\tt_calculator\CalculationInterface;
use Drupal\tt_calculator\SubmissionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form for calculation total price, based on user input.
 */
class CalculatorForm extends FormBase {

  /**
   * The calculation service.
   *
   * @var \Drupal\tt_calculator\CalculationInterface
   */
  protected $calculation;

  /**
   * The submission service.
   *
   * @var \Drupal\tt_calculator\SubmissionInterface
   */
  protected $submission;

  /**
   * Creates a CalculatorForm object.
   *
   * @param \Drupal\tt_calculator\CalculationInterface $calculation
   *   The calculation service.
   * @param \Drupal\tt_calculator\SubmissionInterface $submission
   *   The submission service.
   */
  public function __construct(CalculationInterface $calculation, SubmissionInterface $submission) {
    $this->calculation = $calculation;
    $this->submission = $submission;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('tt_calculation'),
      $container->get('tt_submission')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tt_calculator_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
    ];

    $form['age'] = [
      '#type' => 'select',
      '#title' => $this->t('Age'),
      '#options' => $this->calculation::AGE,
      '#ajax' => [
        'callback' => '::generateTotalPriceCallback',
        'wrapper' => 'total-price',
        'event' => 'change',
        'method' => 'replace',
      ],
    ];

    $form['car_size'] = [
      '#type' => 'select',
      '#title' => $this->t('Car size'),
      '#options' => $this->calculation::CAR_SIZE,
      '#ajax' => [
        'callback' => '::generateTotalPriceCallback',
        'wrapper' => 'total-price',
        'event' => 'change',
        'method' => 'replace',
      ],
    ];

    $form['total_price'] = [
      '#type' => 'textfield',
      '#title' => $this->t('price'),
      '#attributes' => [
        'readonly' => 'readonly',
      ],
      '#prefix' => '<div id="total-price">',
      '#suffix' => '</div>',
    ];

    $form['actions'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send'),
    ];

    return $form;
  }

  /**
   * Ajax callback for updating total price field.
   */
  public function generateTotalPriceCallback(array $form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    if ($values['age'] == 0) {
      $form['total_price']['#value'] = $this->t('You must be at least 20 years old');
    }
    else {
      $form['total_price']['#value'] = '$' . $this->calculation
        ->getTotalPrice($values['age'], $values['car_size']);;
    }
    return $form['total_price'];
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->submission->addSubmission($values['name'], $values['total_price']);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if ($form_state->getValue('age') == 0) {
      $form_state->setErrorByName('age', $this->t('You must be at least 20 years old'));
    }
  }

}

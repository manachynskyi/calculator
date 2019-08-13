<?php

namespace Drupal\tt_calculator\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form for calculator variables settings.
 */
class CalculatorSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getEditableConfigNames() {
    return ['tt_calculator.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'tt_calculator_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('tt_calculator.settings');

    $form['fixed_price'] = [
      '#type' => 'number',
      '#title' => $this->t('Fixed price value'),
      '#min' => 0,
      '#step' => 0.1,
      '#required' => TRUE,
      '#default_value' => $config->get('fixed_price') ? $config->get('fixed_price') : 20,
    ];

    $form['variable_price'] = [
      '#type' => 'number',
      '#title' => $this->t('Variable price value'),
      '#min' => 0,
      '#step' => 0.1,
      '#required' => TRUE,
      '#default_value' => $config->get('variable_price') ? $config->get('variable_price') : 100,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('tt_calculator.settings')
      ->set('fixed_price', $form_state->getValue('fixed_price'))
      ->set('variable_price', $form_state->getValue('variable_price'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}

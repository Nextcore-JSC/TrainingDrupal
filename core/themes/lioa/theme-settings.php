<?php
use Drupal\Core\Form\FormStateInterface;
/**
 * @file
 * Custom setting for lioa theme.
 */
function lioa_form_system_theme_settings_alter(&$form, FormStateInterface $form_state) {

  $form['lioa'] = [
    '#type'       => 'vertical_tabs',
    '#title'      => '<h3>' . t('Settings Lioa') . '</h3>',
    '#default_tab' => 'general',
  ];
   // Slider tab.
   $form['slider'] = [
    '#type'  => 'details',
    '#title' => t('Homepage Slider'),
    '#description' => t('<h4>Manage Homepage Slider</h4>'),
    '#group' => 'lioa',
  ];
  
  
}
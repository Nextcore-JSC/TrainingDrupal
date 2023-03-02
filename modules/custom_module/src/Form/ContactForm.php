<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ContactForm extends FormBase
{
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Your name'),
            '#required' => true,
            '#weight' => 1

        );
        $form['phone_number'] = array(
            '#type' => 'tel',
            '#title' => $this->t('Your phone'),
            '#weight' => 2

        );
        $form['message'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Your message'),
            '#weight' => 3

        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Send'),
            '#button_type' => 'error',
        );

        return $form;
    }
    public function getFormId()
    {
        return 'contact_form';
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if (strlen($form_state->getValue('phone_number')) < 3) {
            $form_state->setErrorByName('phone_number', $this->t('The phone number is too short. Please enter a full phone number.'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $this->messenger()->addStatus($this->t('Your phone number is @number', ['@number' => $form_state->getValue('phone_number')]));
    }
}

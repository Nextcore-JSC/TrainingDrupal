<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

class RegisterForm extends FormBase
{
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['account_information'] = array(
            '#type' => 'fieldset',
            '#title' => $this->t('Register Form'),
            '#collapsible' => TRUE,
            '#collapsed' => TRUE,
            '#attributes' => array(
                'style' => 'font-size: 20px; color: red;',
            ),
        );
        $form['account_information']['name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Your name'),
            '#size' => 50,
            '#required' => true,
        );
        $form['account_information']['Email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Your Email'),
            '#size' => 50,
            '#required' => true,
        );
        $form['account_information']['Password'] = array(
            '#type' => 'password',
            '#title' => $this->t('Your password'),
            '#size' => 50,
            '#required' => true,
        );
        $form['account_information']['Confirm_password'] = array(
            '#type' => 'password',
            '#title' => $this->t('Confirm password'),
            '#size' => 50,
            '#required' => true,
        );
        $form['account_information']['Gender'] = array(
            '#type' => 'radios',
            '#title' => $this->t('Gender'),
            '#options' => array(0 => 'Nam', 1 => 'Nữ', 2 => 'Khác'),
        );
        $form['account_information']['Birthday'] = array(
            '#type' => 'date',
            '#title' => $this->t('Birthday'),
        );
        $form['account_information']['Message'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Điều khoản'),
            '#rows' => 5
        );
        $form['agree'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Đồng ý điều khoản'),
            '#rows' => 5
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Register'),
            '#attributes' => array(
                'style' => 'background-color: #C0EEF2; color: black;',
            ),
        );
        return $form;
    }
    public function getFormId()
    {
        return 'register_form';
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {

        if ($form_state->getValue('Password') != $form_state->getValue('Confirm_password')) {
            $form_state->setErrorByName('Password', $this->t('Pass không trùng khớp'));
        }
        if ($form_state->getValue('agree') != 1) {
            $form_state->setErrorByName('Agree', $this->t('Agree please check'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $values = array(
            'name' => $form_state->getValue('name'),
            'email' => $form_state->getValue('Email'),
            'password' => md5($form_state->getValue('Password')),
            'gender' => $form_state->getValue('Gender'),
            'birthday' => $form_state->getValue('Birthday'),
        );
        $query = \Drupal::database()->insert('custom_users')->fields($values);
        $query->execute();
        $this->messenger()->addStatus($this->t('Registration successful.'));
        $url = Url::fromUri('internal:/login-form');
        $form_state->setRedirectUrl($url);
    }
}

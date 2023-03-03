<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
class ListUserForm extends FormBase
{
    public function buildForm(array $form, FormStateInterface $form_state)
    {
            // Get all data from custom_users table.
        $query = Database::getConnection()->select('custom_users', 'cu');
        $query->fields('cu', ['id', 'name', 'email', 'gender', 'birthday']);
        $results = $query->execute()->fetchAll();
        // Build table header.
        $header = [
        'id' => $this->t('ID'),
        'name' => $this->t('Name'),
        'email' => $this->t('Email'),
        'gender' => $this->t('Gender'),
        'birthday' => $this->t('Birthday'),

        ];

        // Build table rows.
        $rows = [];
        foreach ($results as $result) {
        $rows[] = [
            'id' => $result->id,
            'name' => $result->name,
            'email' => $result->email,
            'gender' => $result->gender,
            'birthday' => $result->birthday,
        ];
        }

        // Build table.
        $form['table'] = [
        '#type' => 'table',
        '#header' => $header,
        '#rows' => $rows,
        ];

        return $form;
    }
    public function getFormId()
    {
        return 'list_user_form';
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

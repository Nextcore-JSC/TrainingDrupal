<?php

namespace Drupal\form_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Symfony\Component\HttpFoundation\Response;
use Drupal\Core\Url;

class ContactForm extends FormBase
{
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        // create form
        $form['Name'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Name'),
            '#size' => 50,
            '#required' => true,
        );
        $form['Email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#size' => 50,
            '#required' => true,
        );
        $form['Gender'] = array(
            '#type' => 'select',
            '#title' => $this->t('Gender'),
            '#options' => array(0 => '-- Select --', 1 => 'Nam', 2 => 'Nữ' , 3 => 'Khác'),
        );
        $form['Title'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Title'),
            '#size' => 50,
            '#required' => true,
        );
        $form['Message'] = array(
            '#type' => 'textarea',
            '#title' => $this->t('Contact Message'),
            '#rows' => 5,
            '#required' => true,
        );
        $form['agree'] = array(
            '#type' => 'checkbox',
            '#title' => $this->t('Send yourself a copy'),
            '#rows' => 5
        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Submit'),
        );
        return $form;
    }

    public function getFormId()
    {
        // create id form
        return 'form_module_contact';
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        if ($form_state->getValue('Gender') <= 0) {
            $form_state->setErrorByName('Gender', $this->t('Please select Gender!!'));
        }
    }
    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        // get value form
        $values = array(
            'name' => $form_state->getValue('Name'),
            'email' => $form_state->getValue('Email'),
            'gender' => $form_state->getValue('Gender'),
            'title' => $form_state->getValue('Title'),
            'message' => $form_state->getValue('Message'),
          );
          //conn db
          $query = \Drupal::database()->insert('contact_form_module')->fields($values);
          $query->execute();
          $this->messenger()->addStatus($this->t('Submit successful.'));
            //download file 
          $send_copy = $form_state->getValue('agree');
          if ($send_copy) {
            $name = $form_state->getValue('Name');
            $email = $form_state->getValue('Email');
            $gender = $form_state->getValue('Gender');
            $title = $form_state->getValue('Title');
            $message = $form_state->getValue('Message');
        
            $output = "Name: $name\nEmail: $email\nGender: $gender\nTitle: $title\nMessage: $message";
        
            $response = new Response($output, 200, [
              'Content-Type' => 'text/plain',
              'Content-Disposition' => 'attachment; filename="contact-info.txt"',
            ]);
            $response->send();
            return;
        }
    }
}

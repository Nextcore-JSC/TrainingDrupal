<?php

namespace Drupal\custom_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Database;
use Drupal\Core\Url;

class LoginForm extends FormBase
{
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['account_information'] = array(
            '#type' => 'fieldset',
            '#title' => $this->t('Account information'),
            '#collapsible' => TRUE,
            '#collapsed' => TRUE,
        );
        $form['account_information']['Email'] = array(
            '#type' => 'email',
            '#title' => $this->t('Your Email'),
            '#size' => 50,
            '#required' => true,
            '#weight' => 2

        );
        $form['account_information']['Password'] = array(
            '#type' => 'password',
            '#title' => $this->t('Your password'),
            '#size' => 50,
            '#required' => true,
            '#weight' => 3

        );
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
            '#type' => 'submit',
            '#value' => $this->t('Login'),
            '#attributes' => array(
                'style' => 'background-color: #C0EEF2; color: black;',
            ),
        );
        return $form;
        
    }
    public function getFormId()
    {
        return 'login_form';
    }
    public function validateForm(array &$form, FormStateInterface $form_state)
    {
    }
    public function submitForm(array &$form, FormStateInterface $form_state) {

        $email = $form_state->getValue('Email');
        $password = $form_state->getValue('Password');
      
        // Kiểm tra xem email có tồn tại trong database hay không.
        $query = \Drupal::database()->select('custom_users', 'cu');
        $query->fields('cu', ['id','email', 'password' ]);
        // sql where
        $query->condition('cu.email', $email);

        $result = $query->execute();
        $account = $result->fetchAssoc();
        $hashed_password = md5($password);
        
        // dump($password_hasher);
        // dump($hashed_password);
        // dump($account['password']);
        if ($account) {
          // Kiểm tra mật khẩu.
          if ($account['password'] == $hashed_password) {
            // Đăng nhập thành công.
            $this->messenger()->addStatus($this->t('Đăng nhập thành công'));
            $url = Url::fromUri('internal:/home');
            $form_state->setRedirectUrl($url);
          } else {
            dump('sai mk');

            $form_state->setErrorByName('Password', $this->t('Mật khẩu không chính xác'));
            
          }
        } else {
        //   $form_state->setErrorByName('Email', $this->t('Email không tồn tại'));
          dump('sai email');

        }
    }     
    

      

}
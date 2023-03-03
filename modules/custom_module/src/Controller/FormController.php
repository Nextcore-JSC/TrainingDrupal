<?php

namespace Drupal\contact\Controller;
use Drupal\Core\Controller\ControllerBase;
class FormController extends ControllerBase {
  public function vippro_hello(){
    // phpinfo();
    return array('#markup' => ('Hello !!! đây là hàm hello nha mọi người~~'));
  } 
}
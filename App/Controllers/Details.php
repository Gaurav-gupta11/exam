<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use \App\Flash;

/**
 * Defines the Login controller.
 */
class Details extends \Core\Controller {

  /**
   * Runs before all methods in the Items controller.
   *
   * @return void
   *   The required login.
   */
  protected function before() {
    $this->requiredLogin();
  }

  /**
   * Displays the Details form.
   *
   * @return void
   *   The rendered output of the Detail form.
   */
  public function newAction() {
    View::render('Details/new.php');
  }

  /**
   * Update a user's information.
   *
   * @return void
   */
  public function updateAction()
  {
    $user = new User($_POST);
    if ($user->update($_FILES)) {
        header('Location: /Details/new');
    }
  }


}
<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use \App\Flash;

/**
 * Defines the Login controller.
 */
class Profile extends \Core\Controller {

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
   * Displays the login form.
   *
   * @return void
   *   The rendered output of the login form.
   */
  public function showAction() {
    $user = static::getUserSearch();
    View::render('Profile/new.php', ['user' => $user]);
  }
}
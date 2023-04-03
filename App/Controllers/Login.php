<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use \App\Flash;

/**
 * Defines the Login controller.
 */
class Login extends \Core\Controller {

  /**
   * Displays the login form.
   *
   * @return void
   *   The rendered output of the login form.
   */
  public function newAction() {
    View::render('Login/new.php');
  }

  public function submitAction(){
    $user = User::authenticate($_POST['user'], $_POST['password'], $_POST['user-type']);
    if($user) {
      $_SESSION['user_id'] = $user->id;
      $_SESSION['role'] = $user->role;
      if($user->role == 'admin') {
        header('Location: /Details/new');
        exit;
      }
      elseif ($user->role == 'user') {
        header("Location: /Profile/show");
        exit;
      }
    }
    header("Location: /Login/new");
    exit;
  }  

  /**
   * Logs the user out.
   *
   * @return void
   *   Redirects to the logout confirmation page.
   */
  public function destroyAction() {
    // Unset all of the session variables.
    $_SESSION = array();
    // If it's desired to kill the session, also delete the session cookie.
    // Note: This will destroy the session, and not just the session data!
    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
      );
    }
    // Finally, destroy the session.
    session_destroy();
    header('Location: /Login/showLogout');
  }

  /**
   * Displays the logout confirmation page.
   *
   * @return void
   *   The rendered output of the logout confirmation page.
   */
  public function showLogoutAction() {
    Flash::addMessage('Logout successful');
    header('Location: /Login/new');
    exit;
  }

}
?>
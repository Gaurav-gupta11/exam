<?php

/**
 * @file
 * Contains login functionality for users.
 */

/**
 * A class to handle user authentication.
 */
class UserAuthentication {
  
  /**
   * The database connection.
   *
   * @var object
   */
  protected $conn;

  /**
   * Constructor for the UserAuthentication class.
   */
  public function __construct() {
    session_start();
    include("db.php");
    $this->conn = $conn;
  }

  /**
   * Authenticates a user based on their credentials.
   *
   * @param string $username
   *   The username of the user to authenticate.
   * @param string $password
   *   The password of the user to authenticate.
   * @param string $role
   *   The role of the user to authenticate.
   *
   * @return bool
   *   Returns TRUE if the user is authenticated, otherwise FALSE.
   */
  public function authenticateUser($username, $password, $role) {
    $sql = "SELECT * FROM user WHERE username='$username' AND password='$password' AND role='$role'";
    $result = mysqli_query($this->conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row['role'] == 'admin') {
      $_SESSION['id'] = $row['id'];
      header("Location:addnewbook.php");
      return TRUE;
    }
    elseif ($row['role'] == 'user') {
      $_SESSION['id'] = $row['id'];
      header("location:profile.php");
      return TRUE;
    }
    else {
      // The username, password, or role do not match the values in the database
      header("Location:index.php");
      return FALSE;
    }
  }

  /**
   * Closes the database connection.
   */
  public function closeConnection() {
    mysqli_close($this->conn);
  }

}

// Example usage:
$userAuth = new UserAuthentication();
$username = $_POST['user'];
$password = $_POST['password'];
$role = $_POST['user-type'];
$userAuth->authenticateUser($username, $password, $role);
$userAuth->closeConnection();

?>
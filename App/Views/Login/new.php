<?php use App\Flash;?>
<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="/css/index.css">
</head>
<body>
<?php if (isset($_SESSION['user_id'])):
        $role = $_SESSION['role'];
        if ($role == 'admin'):
         header("Location: /Details/new");
        exit;
        else :
         header("Location: /Profile/new");
        exit;
        endif;
      else:?>
  <form action="/Login/submit" method="POST">
    <h2>Login</h2>
    <select name="user-type">
    <option value="admin">Admin</option>
    <option value="user">User</option>
    </select>
    <label for="user">Name</label>
    <input type="text" id="user" name="user" required ><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" value="Login"><br>
    <?php endif; ?>
    <?php  if (isset($_SESSION['flash_notifications'])) {
        foreach($_SESSION['flash_notifications'] as $row){
          echo $row;
          Flash::getMessages();
        }
    }?>
  </form>
</body>
</html>
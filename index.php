<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
  <link rel="stylesheet" href="index.css">
</head>
<body>
  <form action="submit.php" method="POST">
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
  </form>
</body>
</html>
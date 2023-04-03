<?php
include("db.php");
// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve selected sort order
  $sort = $_POST['sort'];

  // Connect to MySQL database

  // Build MySQL query
  $sql = "SELECT * FROM book ORDER BY title $sort";

  // Execute MySQL query
  $result = mysqli_query($conn, $sql);

 

  // Close MySQL connection
  mysqli_close($conn);
}
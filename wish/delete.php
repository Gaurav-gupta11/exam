<?php
/**
 * Inserts a new record in book_detail table for the current user
 *
 * @param object $db The database connection object
 * @param int $user_id The ID of the current user
 * @param string $book_id The ID of the book to add to the user's bucket list
 *
 * @return bool Whether the data was successfully inserted
 */
function add_book_to_bucket_list($db, $user_id, $book_id) {
  // Prepare the SQL statement to insert the data
  $sql = "DELETE FROM book_detail where user_id = $user_id && wish_id = $book_id";
  
  $row = mysqli_query($db, $sql);
  
  if ($row) {
    echo "Data deleted  successfully.";
    return true;
  } else {
    return false;
  }
}

// Start the session and include the database connection file
session_start();
include("../db.php");

// Get the user ID and book ID from the session
$user_id = $_SESSION['id'];
$book_id = $_SESSION['book_id'];

// Call the add_book_to_bucket_list function
if (add_book_to_bucket_list($db, $user_id, $book_id)) {
  echo "Data inserted successfully.";
  header('Location:../wishlist.php');
} else {
  echo "Error inserting data: " . mysqli_error($db);
}

// Close the database connection
$db->close();
?>

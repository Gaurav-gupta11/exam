<link rel="stylesheet" href="/css/profile.css">
<?php 
if (isset($_SESSION['user_id'])): 
  $role = $_SESSION['role'];
  if ($role == 'user'):
    // Store books in separate arrays for each title
    $reading_books = [];
    $bucket_books = [];

    foreach($user as $user) {
      if ($user['reading_title']) {
        $reading_books[] = $user['reading_title'];
      }
      if ($user['bucket_title']) {
        $bucket_books[] = $user['bucket_title'];
      }
    }

    echo "<div class='profile'>";
    echo "<div class='name'>" . $user['full_name'] . "</div>";

    // Display reading books
    if (!empty($reading_books)) {
      echo "<div class='reading'>";
      echo "<h2>Continue Reading</h2>";
      echo "<ul>";
      while ($book = array_shift($reading_books)) {
        echo "<li>" . $book . "</li>";
      }
      echo "</ul>";
      echo "</div>";
    }

    // Display bucket list
    if (!empty($bucket_books)) {
      echo "<div class='bucket'>";
      echo "<h2>Bucket List</h2>";
      echo "<ul>";
      while ($book = array_shift($bucket_books)) {
        echo "<li>" . $book . "</li>";
      }
      echo "</ul>";
      echo "</div>";
    }

    echo "</div>"; // close profile div
  endif;
else :
  header('Location : /Login/new');
endif;
?>

<a href="/Home/new">Home</a>

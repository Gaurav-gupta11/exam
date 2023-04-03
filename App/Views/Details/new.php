<!DOCTYPE html>
<html>
<head>
  <title>Add a new Book</title>
  <link rel="stylesheet" href="/css/index.css">
</head>
<?php if (isset($_SESSION['user_id'])): 
      $role = $_SESSION['role'];
      if ($role == 'admin'):?>
        <form action="/Details/update" method="post" enctype="multipart/form-data">
        <label for="book_id">Book ID:</label>
        <input type="text" id="book_id" name="book_id"><br>

        <label for="poster_image">Poster Image:</label>
        <input type="file" id="poster_image" name="poster_image"><br>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required><br>

        <label for="genre">Genre:</label>
        <input type="text" id="genre" name="genre"><br>

        <label for="publication_date">Publication Date:</label>
        <input type="date" id="publication_date" name="publication_date"><br>

        <label for="author">Author:</label>
        <input type="text" id="author" name="author" required><br>

        <label for="ratings">Ratings:</label>
        <input type="number" id="ratings" name="ratings" step="0.1" min="0" max="5"><br>

        <label for="category">Category:</label>
        <input type="text" id="category" name="category"><br>

        <input type="submit" value="Submit">
        <a href="/Login/destroy">Logout</a>
      <?php else :
        header("Location: /Profile/new");
        endif; 
      else :
        header('Location : /Login/new');
      endif;
        ?>


</form>
</body>
</html>
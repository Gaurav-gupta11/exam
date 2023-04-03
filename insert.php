<?php
	session_start();
	include("db.php");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST["book_id"];
		if(!empty($_FILES['poster_image']['name'])) {
			$img_name = $_FILES['poster_image']['name'];
			$image = $_FILES['poster_image']['tmp_name'];
			$imgData = addslashes(file_get_contents($image)); 
		} 
    $title = $_POST["title"];
    $genre = $_POST["genre"];
    $publication_date = $_POST["publication_date"];
    $author = $_POST["author"];
    $ratings = $_POST["ratings"];
    $category = $_POST["category"];

    $sql = "INSERT INTO book (book_id, poster_image, title, genre, publication_date, author, ratings, category) VALUES ('$book_id', '$imgData', '$title', '$genre', '$publication_date', '$author', '$ratings', '$category')";

    if ($conn->query($sql) === TRUE) {
			header('Location:addnewbook.php');
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
  }
?>

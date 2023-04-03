<?php 
session_start();
include("db.php");


// SQL query to fetch user's reading list, bucket list, and wish list
$sql = "SELECT u.full_name, b1.title AS reading_title, b2.title AS bucket_title, b3.title AS wish_title 
        FROM user u 
        JOIN book_detail bd ON u.id = bd.user_id 
        LEFT JOIN book b1 ON b1.book_id = bd.reading_id 
        LEFT JOIN book b2 ON b2.book_id = bd.bucket_id 
        LEFT JOIN book b3 ON b3.book_id = bd.wish_id";

// execute query
$result = mysqli_query($conn, $sql);

// check if any data is found
if (mysqli_num_rows($result) > 0) {
    include("show_profile.php");

}

// close connection
mysqli_close($conn);


?>
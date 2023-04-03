<? session_start();?>
<a href="bucketlist.php">bucketlist</a>
<a href="wishlist.php">wishlist</a>
<a href="Logout.php">Logout</a>

<?php 
$user_id = $_SESSION['id'];
$sql = "SELECT , book.*
FROM book_detail
INNER JOIN book ON book_detail.wish_id = book.book_id
WHERE book_detail.user_id = $user_id";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<br>";?>
 <?php if (!empty($row['poster_image'])): ?>
                    <img src="data:image/jpg;base64,<?=base64_encode($row['poster_image'])?>" alt="<?=$post['title']?>" class="profile-image">
                <?php endif; ?>
    <?php
    echo $row['title'];
    echo "<br>";
    echo $row['author'];
    $result = mysqli_query($conn, $sql);

 

    // Close MySQL connection
    mysqli_close($conn);
 }
?>
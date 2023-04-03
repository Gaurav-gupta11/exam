<? session_start();?>
<a href="bucketlist.php">bucketlist</a>
<a href="wishlist.php">wishlist</a>
<a href="Logout.php">Logout</a>
<form method="post">
  <label for="sort">Sort Order:</label>
  <select id="sort" name="sort">
    <option value="asc">Ascending</option>
    <option value="desc">Descending</option>
  </select>
  <button type="submit">Sort</button>
</form>
<?php include("home_book.php"); 
         // Loop through query results and display data
  while ($row = mysqli_fetch_assoc($result)) {
    echo "<br>";?>
 <?php if (!empty($row['poster_image'])): ?>
                    <img src="data:image/jpg;base64,<?=base64_encode($row['poster_image'])?>" alt="<?=$post['title']?>" class="profile-image">
                <?php endif; ?>
    <?php
    echo $row['title'];
    echo "<br>";
    echo $row['author'];
    $current_date = date("Y-m-d");
    $bookdate = $row['publication_date'];
    $_SESSION['book_id'] = $row['book_id'];
   
    if (strtotime($current_date) > strtotime($bookdate)) {
        echo "<a href = bucket/add.php>Add</a>";
       echo "<a href = bucket/delete.php>Delete</a>";
    } else {
        echo "<a href = wish/add.php>Add</a>";
        echo "<a href = wish/delete.php>Delete</a>";
    }
  }
  ?>
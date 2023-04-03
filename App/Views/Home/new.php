<!DOCTYPE html>
<html>
<head>
  <title>Books</title>
  <link rel="stylesheet" href="/css/home.css">
</head>
<body>
<?php if (isset($_SESSION['user_id'])): 
  $role = $_SESSION['role'];
  if ($role == 'user'): ?>
  <div class="container">
    <header>
      <h1>Books</h1>
      <nav>
        <a href="/Home/bucket">Bucketlist</a>
        <a href="/Home/wish">Wishlist</a>
        <a href="/Login/destroy">Logout</a>
      </nav>
    </header>
    <form method="post" action="/Home/sort">
      <label for="sort">Sort by title:</label>
      <select id="sort" name="sort">
        <option value="asc">Ascending</option>
        <option value="desc">Descending</option>
      </select>
      <input type="submit" name="submit" value="Sort">
    </form>
    <?php if(isset($_POST['submit'])) :
      foreach($user as $user){
        if (!empty($user['poster_image'])): ?>
          <div class="book">
            <img src="data:image/jpg;base64,<?=base64_encode($user['poster_image'])?>" alt="<?=$user['title']?>">
            <h3><?=$user['title']?></h3>
            <p>Author: <?=$user['author']?></p>
            <?php $current_date = date("Y-m-d");
            $bookdate = $user['publication_date'];
            if (strtotime($current_date) > strtotime($bookdate)) {?>
              <a href = "/Home/<?= $user['book_id'] ?>/addBucket">Add to Bucketlist</a>
              <a href = "/Home/<?= $user['book_id'] ?>/deleteBucket">Delete from Bucketlist</a>
            <?php } else { ?>
              echo "<a href = "/Home/<?= $user['book_id'] ?>/addWish">Add to Wishlist</a>";
              echo "<a href = "/Home/<?= $user['book_id'] ?>/deleteWish">Delete from Wishlist</a>";
           <?php }?>
          </div>
        <?php endif;
      }
    endif; 
endif;
endif;?>
  </div>



</body>
</html>
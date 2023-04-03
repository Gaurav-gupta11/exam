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
    <?php
      foreach($user as $user){
        if (!empty($user['poster_image'])): ?>
          <div class="book">
            <img src="data:image/jpg;base64,<?=base64_encode($user['poster_image'])?>" alt="<?=$user['title']?>">
            <h3><?=$user['bucket_title']?></h3>
            <?php
        endif;
      }
    endif; 
endif;?>
  </div>



</body>
</html>
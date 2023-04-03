<?php
   // fetch data
   $row = mysqli_fetch_assoc($result);
   //var_dump($row);
   echo"<br>";echo $row['full_name'];echo"<br>";
   echo $row['reading_title'];echo"<br>";
   echo $row['bucket_title'];
 
?>
<a href="home.php">Home</a>
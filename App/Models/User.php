<?php

/**
 * @file
 * Contains the User model.
 */

namespace App\Models;

use Core\Model;
use mysqli;

/**
 * Defines the User model.
 */
class User extends Model {

  /**
   * @var int The user ID.
   */
  public $id;

  /**
   * @var string The user's full name.
   */
  public $full_name;

  /**
   * @var string The user's username.
   */
  public $username;

  /**
   * @var string The user's password.
   */
  public $password;

  /**
   * @var string The user's role.
   */
  public $role;

  /**
   * @var int The book ID.
   */
  public $book_id;

  /**
   * @var string The poster image for the book.
   */
  public $poster_image;

  /**
   * @var string The title of the book.
   */
  public $title;

  /**
   * @var string The genre of the book.
   */
  public $genre;

  /**
   * @var string The publication date of the book.
   */
  public $publication_date;

  /**
   * @var string The author of the book.
   */
  public $author;

  /**
   * @var float The ratings for the book.
   */
  public $ratings;

  /**
   * @var string The category of the book.
   */
  public $category;

  /**
   * An array of error messages.
   *
   * @var array
   */
  public $errors = [];


  /**
   * Constructs a User object.
   *
   * @param array $data
   *   An array of data for the User object.
   */
  public function __construct($data =[]) {
    foreach ($data as $key => $value) {
      $this->{$key} = $value;
  	}
  }

  /**
   * Authenticates a user by email and password.
   *
   * @param string $username
   *   The user's email address.
   * @param string $password
   *   The user's password.
   *
   * @return object|false
   *   A user object if authenticated, FALSE otherwise.
   */
  public static function authenticate($username, $password, $role ) {
    $user = static::findByUser($username);
      if($user) {
        if($password == $user->password && $role == $user->role) { 
            return $user;
        }
      }
      return false;
  }

  	/**
   * Gets a user object by email.
   *
   * @param string $email
   *   The email to search for.
   *
   * @return object|null
   *   A user object if found, NULL otherwise.
   */
  public static function findByUser($username) {
    $db = static::getDB();
    $username = mysqli_real_escape_string($db, $username);
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);

    // Convert the row to an object
    $user = null;
    if ($row) {
        $user = new static();
        foreach ($row as $key => $value) {
                $user->$key = $value;
        }
    }

    return $user;
  }

  /**
   * Updates the book with new data.
   *
   * @param array $data An array of data to update the book with.
   *
   * @return bool TRUE if the book was updated, FALSE otherwise.
   */
  public  function update($data = []) {
    $db = self::getDB();
    if(!empty($_FILES['profile_pic']['name'])) {
      $img_name = $_FILES['profile_pic']['name'];
      $image = $_FILES['profile_pic']['tmp_name'];
      $imgData = addslashes(file_get_contents($image)); 
    }  
    $sql = "INSERT INTO book (book_id, poster_image, title, genre, publication_date, author, ratings, category) VALUES ('$this->book_id', '$imgData', '$this->title', '$this->genre', '$this->publication_date', '$this->author', '$this->ratings', '$this->category')";
    return mysqli_query($db, $sql);     
  }

  /**
   * Retrieve the reading list, bucket list, and wish list of a user
   *
   * @param int $id The ID of the user
   * @return array An array containing the user's reading list, bucket list, and wish list
   */
  public static function showBooks($id){
    $db = static::getDB();
    // SQL query to fetch user's reading list, bucket list, and wish list
    $sql = "SELECT u.full_name, b1.title AS reading_title, b2.title AS bucket_title, b3.title AS wish_title 
    FROM user u 
    JOIN book_detail bd ON u.id = bd.user_id 
    LEFT JOIN book b1 ON b1.book_id = bd.reading_id 
    LEFT JOIN book b2 ON b2.book_id = bd.bucket_id 
    LEFT JOIN book b3 ON b3.book_id = bd.wish_id
    WHERE u.id = $id";
    $result = mysqli_query($db, $sql);
    $data =[];
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($data, $row);
  }
  return $data;
  }

  /**
   * Retrieve all books sorted by title
   *
   * @param string $sort The sorting order (ASC or DESC)
   * @return array An array containing all books sorted by title
   */
  public static function sortBooks($sort){
    $db = static::getDB();
    $sql = "SELECT * FROM book ORDER BY title $sort";
    $result = mysqli_query($db, $sql);
    $data =[];
    while ($row = mysqli_fetch_assoc($result)) {
      array_push($data, $row);
    }
    return($data);
  }

  /**
   * Add a book to the bucket list of the current user
   *
   * @return bool True if the book was added successfully, false otherwise
   */
  public static function updateBucketAction(){
    $db = static::getDB();
    $id = $_SESSION['user_id'];
    $bookid = $_SESSION['book_id'];
    $sql = "INSERT INTO book_detail (user_id, bucket_id) VALUES ($id,$bookid)";
    return mysqli_query($db, $sql); 
  }

  /**
   * Add a book to the wish list of the current user
   *
   * @return bool True if the book was added successfully, false otherwise
   */
  public static function updateWishAction(){
    $db = static::getDB();
    $id = $_SESSION['user_id'];
    $bookid = $_SESSION['book_id'];
    $sql = "INSERT INTO book_detail (user_id, wish_id) VALUES ($id,$bookid)";
    return mysqli_query($db, $sql); 
  }

  /**
   * Remove a book from the bucket list of the current user
   *
   * @return bool True if the book was removed successfully, false otherwise
   */
  public static function deleteBucketAction(){
    $db = static::getDB();
    $id = $_SESSION['user_id'];
    $bookid = $_SESSION['book_id'];
    $sql = "DELETE FROM book_detail where user_id = $id && bucket_id = $bookid";
    return mysqli_query($db, $sql); 
  }

  /**
   * Remove a book from the wish list of the current user
   *
   * @return bool True if the book was removed successfully, false otherwise
   */
  public static function deleteWishAction(){
    $db = static::getDB();
    $id = $_SESSION['user_id'];
    $bookid = $_SESSION['book_id'];
    $sql = "DELETE FROM book_detail where user_id = $id && wish_id = $bookid";
    return mysqli_query($db, $sql); 
  }

  /**
   * Get a user's bucket list.
   *
   * @param int $id The user ID.
   *
   * @return array An array of bucket list items for the user.
   */
  public static function getBucket($id){
    $db = static::getDB();
     // SQL query to fetch user's reading list, bucket list, and wish list
     $sql = "SELECT b2.title AS bucket_title
     FROM user u 
     JOIN book_detail bd ON u.id = bd.user_id 
     LEFT JOIN book b1 ON b1.book_id = bd.reading_id 
     LEFT JOIN book b2 ON b2.book_id = bd.bucket_id 
     LEFT JOIN book b3 ON b3.book_id = bd.wish_id
     WHERE u.id = $id";
     $result = mysqli_query($db, $sql);
     $data =[];
     while ($row = mysqli_fetch_assoc($result)) {
       array_push($data, $row);
   }
   return $data;
  }

  /**
   * Get a user's wish list.
   *
   * @param int $id The user ID.
   *
   * @return array An array of wish list items for the user.
   */
  public static function getWish($id){
    $db = static::getDB();
     // SQL query to fetch user's reading list, bucket list, and wish list
     $sql = "SELECT b2.title AS bucket_title
     FROM user u 
     JOIN book_detail bd ON u.id = bd.user_id 
     LEFT JOIN book b1 ON b1.book_id = bd.reading_id 
     LEFT JOIN book b2 ON b2.book_id = bd.bucket_id 
     LEFT JOIN book b3 ON b3.book_id = bd.wish_id
     WHERE u.id = $id";
     $result = mysqli_query($db, $sql);
     $data =[];
     while ($row = mysqli_fetch_assoc($result)) {
       array_push($data, $row);
   }
   return $data;
  }

}
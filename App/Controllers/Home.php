<?php

namespace App\Controllers;

use \Core\View;
use App\Models\User;
use \App\Flash;

/**
 * Defines the Login controller.
 */
class Home extends \Core\Controller {

  /**
   * Runs before all methods in the Items controller.
   *
   * @return void
   *   The required login.
   */
  protected function before() {
    $this->requiredLogin();
  }

  /**
   * Displays the new form.
   *
   * @return void
   *   The rendered output of the new form.
   */
  public function newAction() {
    View::render('Home/new.php');
  }
   
  /**
   * Sorts the books based on user input.
   * 
   * @return void
   * 
   * The rendered output of the sorted books.
   */
  public function sortAction() {
    $sort = $_POST['sort'];
    $user = User::sortBooks($sort);
    if($user)
    View::render('Home/new.php', ['user' => $user]);
  }

  /**
   * Adds a book to the user's bucketlist.
   * 
   * @return void
   * 
   * Redirects to the newAction method.
   * 
   */
  public function addBucketAction(){
    $this->idFetch($_SERVER['REQUEST_URI']);
    $user = User::updateBucketAction();
    if($user){
      header("Location: /Home/new");
    }
  }

  /**
   * 
   * Removes a book from the user's bucketlist.
   * @return void
   * Redirects to the newAction method.
   * 
   */
  public function deleteBucketAction(){
    $this->idFetch($_SERVER['REQUEST_URI']);
    $user = User::deleteBucketAction();
    if($user){
      header("Location: /Home/new");
    }
  }

  /**
   * Adds a book to the user's wishlist.
   * 
   * @return void
   * 
   * Redirects to the newAction method.
   * 
   */
  public function addWishAction(){
    $this->idFetch($_SERVER['REQUEST_URI']);
    $user = User::updateWishAction();
    if($user){
      header("Location: /Home/new");
    }
  }

  /**
   * Removes a book from the user's wishlist.
   * 
   * @return void
   * 
   * Redirects to the newAction method.
   */
  public function deleteWishAction(){
    $this->idFetch($_SERVER['REQUEST_URI']);
    $user = User::deleteWishAction();
    if($user){
      header("Location: /Home/new");
    }
  }

  /** 
   * Extracts the post ID from the URL.
   */
  public function idFetch($url) {
    // Parse the URL to get its different parts.
    $url_parts = parse_url($url);

    // Get the path of the URL.
    $path = $url_parts['path'];

    // Extract the post ID from the path using regular expressions.
    $pattern = '/\/Home\/(\d+)\/(\w+)/';
    if (preg_match($pattern, $path, $matches)) {
      // The post ID is in the first captured group.
      $post_id = $matches[1];
      $_SESSION['book_id'] = $post_id;
    }
  }

  /**
   * Show all the book in the user's bucketlist.
   * 
   * @return void
   * 
   * Redirects to the newAction method.
   */
  public function BucketAction(){
    $user = static::getUserBucket();
    View::render('Home/bucket.php', ['user' => $user]);
  }

  /**
   * Show all the book in the user's wishlist.
   * 
   * @return void
   * 
   * Redirects to the newAction method.
   */
  public function WishAction(){
    $user = static::getUserBucket();
    View::render('Home/wish.php', ['user' => $user]);
  }
}
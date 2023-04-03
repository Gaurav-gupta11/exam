<?php

namespace Core;

use \App\Models\User;
use \App\Models\Postsdb;
use \App\Flash;

/**
 * Provides a base controller for all other controllers to extend from.
 */
abstract class Controller
{
	/**
	 * Parameters from the matched route.
	 *
	 * @var array
	 */
	protected $route_params = [];

	/**
	 * Class constructor.
	 *
	 * @param array $route_params
	 *   Parameters from the route.
	 */
	public function __construct($route_params) {
		$this->route_params = $route_params;
	}

	/**
	 * Magic method called when a non-existent or inaccessible method is
	 * called on an object of this class. Used to execute before and after
	 * filter methods on action methods. Action methods need to be named
	 * with an "Action" suffix, e.g. indexAction, showAction etc.
	 *
	 * @param string $name
	 *   Method name.
	 * @param array $args
	 *   Arguments passed to the method.
	 *
	 * @throws \Exception
	 *   Throws an exception if the method is not found in the controller.
	 */
	public function __call($name, $args) {
		$method = $name . 'Action';
		if (method_exists($this, $method)) {
			if ($this->before() !== false) {
					call_user_func_array([$this, $method], $args);
					$this->after();
			}
		} else {
			throw new \Exception("Method $method not found in controller " . get_class($this));
		}
	}

	/**
	 * Before filter - called before an action method.
	 */
	protected function before()
	{
	}

	/**
	 * After filter - called after an action method.
	 */
	protected function after()
	{
	}

	/**
	 * Checks if the user is logged in. If not, redirects to the login page.
	 */
	public function requiredLogin() {
		if (!isset($_SESSION['user_id'])) {
			Flash::addMessage('Please Login first');
			$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
			header('Location: /Login/new');
			exit;
		}
	}

  /**
   * Returns the search results for a logged in user
   * @return array|null An array of book search results or null if user is not logged in
   */
	public function getUserSearch() {
		if (isset($_SESSION['user_id'])) {
			return User::showBooks($_SESSION['user_id']);
		}

		return null;
	}

  /**
   * Returns the bucket list for a logged in user
   * @return array|null An array of bucket list items or null if user is not logged in
   *
   */

  public function getUserBucket() {
		if (isset($_SESSION['user_id'])) {
			return User::getBucket($_SESSION['user_id']);
		}

		return null;
	}

  /**
   * Returns the wishlist for a logged in user
   *
   * @return array|null An array of wishlist items or null if user is not logged in
   *
   */
  public function getUserWish() {
		if (isset($_SESSION['user_id'])) {
			return User::getWish($_SESSION['user_id']);
		}

		return null;
	}



	
}
?>
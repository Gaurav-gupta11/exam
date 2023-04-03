<?php
/**
 * @file
 * Provides a connection to the books database using OOPs principles.
 */

/**
 * The Database class provides a connection to the books database.
 */
class Database {

  /**
   * The database server name.
   *
   * @var string
   */
  private $servername;

  /**
   * The database username.
   *
   * @var string
   */
  private $username;

  /**
   * The database password.
   *
   * @var string
   */
  private $password;

  /**
   * The database name.
   *
   * @var string
   */
  private $dbname;

  /**
   * The database connection object.
   *
   * @var mysqli
   */
  private $conn;

  /**
   * Constructs a new Database object.
   *
   * @param string $servername
   *   The database server name.
   * @param string $username
   *   The database username.
   * @param string $password
   *   The database password.
   * @param string $dbname
   *   The database name.
   */
  public function __construct($servername, $username, $password, $dbname) {
    $this->servername = $servername;
    $this->username = $username;
    $this->password = $password;
    $this->dbname = $dbname;
  }

  /**
   * Connects to the database.
   *
   * @throws Exception
   *   If the connection fails.
   */
  public function connect() {
    $this->conn = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);

    if (!$this->conn) {
      throw new Exception("Connection failed: " . mysqli_connect_error());
    }
  }

  /**
   * Returns the database connection object.
   *
   * @return mysqli
   *   The database connection object.
   */
  public function getConnection() {
    return $this->conn;
  }

}

// Create a new Database object.
$database = new Database('localhost', 'gaurav', 'Gaurav@123', 'books');

try {
  // Connect to the database.
  $database->connect();

  // Get the database connection object.
  $conn = $database->getConnection();

  // Check the connection.
  if ($conn) {
    echo "Connected successfully";
  }
}
catch (Exception $e) {
  // Handle the exception.
  echo "Connection failed: " . $e->getMessage();
}

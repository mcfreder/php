<?php

class Database
{
  private $fileName = __DIR__ . '/db.sqlite';
  private $dsn = "mysql:host=here!";
  private $user = "username";
  private $pw = "password";
  public $query;

  /**
   * Connects to the MySQL database.
   * @return db
   */
  public function connect()
  {
    try {
      $db = new PDO($this->dsn, $this->user, $this->pw);

      /* Set the PDO error mode to exception */
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      echo "Failed to connect to the database using DSN:<br>$this->dsn<br>";
      throw $e;
    }

    /* Return the database */
    return $db;
  }

  /**
   * Handle a table, DROP or CREATE
   * @param $query - SQL query
   */
  public function table()
  {
    try {
      $db = $this->connect();

      /* Use exec() because no results are returned */
      $db->exec($this->query);

      echo 'Executed table script successfully.';
    } catch (PDOException $e) {
      echo $this->query . "<br>" . $e->getMessage();
    }
  }


  /**
   * Fetch data from db
   * @param $status - how data structure from database should look like.
   * @return array
   */
  public function select($status = false)
  {
    $db = $this->connect();
    /* Note that PDO::prepare() helps to prevent SQL injection 
        attacks by eliminating the need to manually quote the parameters. */
    $stmt = $db->prepare($this->query);
    $stmt->execute();

    (!$status) ?
      $res = $stmt->fetchAll(PDO::FETCH_ASSOC) :
      $res = $stmt->fetch(PDO::FETCH_ASSOC);

    return $res;
  }

  /**
   * Insert into database
   */
  public function insert()
  {
    $db = $this->connect();
    $stmt = $db->prepare($this->query);
    $stmt->execute();
  }
}

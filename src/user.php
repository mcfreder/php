<?php

class User extends Database
{
  private $base_path = '/~erimam-9/projekt';

  /**
   * Register input data from client.
   * @return string
   */
  public function register(): ?string
  {
    $username = $_POST['username'] ?? null;
    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    /* Insert user to database. */
    try {
      $this->query = "INSERT INTO users (username, password) 
                VALUES ('$username', '$hash');";

      $this->insert();

      /* When done set username to session */
      $_SESSION['username'] = $username;

      return null;
    }
    /* Catch exception */ catch (Exception $e) {
      return 'Användarnamnet finns redan.';
    }
  }

  /**
   * Login user.
   * @return string
   */
  public function login(): ?string
  {
    /* Setup query */
    $this->query = "SELECT * FROM users WHERE username = '{$_POST["username"]}'";
    $msg = 'Felaktigt användarnamn och/eller lösenord.';

    /* Match user in database. */
    $user = $this->select(true);

    if ($user) {
      $verify = password_verify($_POST['password'], $user['password']);

      if ($verify) {
        $_SESSION['username'] = $user["username"];

        return null;
      }

      return $msg;
    }

    /* Return the same message even if user exist. 
        Never tell the client what input is incorrect. */
    return $msg;
  }

  /**
   * Logout user.
   */
  public function logout(): void
  {
    /* Destroy session */
    session_unset();
    session_destroy();

    header("Location: $this->base_path");
    exit;
  }
}

/**
 * Init user and include it in index.php.
 */
$user = new User();

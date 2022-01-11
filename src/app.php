<?php

/**
 * This class handles page content like, view, posts etc.
 */
class App extends Database
{
  public $base_path = '/base/path';
  public $base_url = 'http://www.example.se';
  public $is_logged = null;
  public $title = null;
  public $blog = null;
  public $posts = null;
  public $post = null;
  public $data = null;

  /**
   * All mighty constructor, start session.
   */
  public function __construct()
  {
    session_start();
  }

  /**
   * Get all posts.
   */
  public function posts()
  {
    $this->query = "SELECT * FROM posts ORDER BY createdAt DESC LIMIT 6";

    $this->posts = $this->select();
  }

  /**
   * Get all "bloggers".
   */
  public function users()
  {
    $this->query = "SELECT * FROM users";

    $this->data = $this->select();
  }

  /**
   * Get all posts by username
   * @param $username
   */
  public function get_posts($username): void
  {
    $this->query = "SELECT * FROM posts WHERE author = '$username' ORDER BY createdAt DESC";

    $this->data = $this->select();
    $this->blog = $username;
  }

  /**
   * Get post by slug
   * @param $slug
   */
  public function get_post($slug): void
  {
    $this->query = "SELECT * FROM posts WHERE slug = '$slug'";

    $this->post = $this->select(true);
  }

  /**
   * Set latest post.
   */
  public function get_latest_post(): void
  {
    /* If any posts where returned from the get_posts() function then 
        we can set first element to the post property */
    if ($this->data)
      $this->post = $this->data[0];
  }

  /**
   * Create post.
   */
  public function create(): void
  {
    $title = $_POST['title'];
    $slug = $this->slug($title);
    $content = $_POST['content'];
    $author = $_SESSION['username'];

    $this->query = "INSERT INTO posts (title, slug, content, author) 
            VALUES ('$title', '$slug', '$content', '$author');";

    $this->insert();

    header("Location: $author/$slug");
    exit;
  }

  /**
   * Update post.
   */
  public function update(): void
  {
    $id = $_POST['id'];
    $author = $_POST['author'];
    $content = $_POST['content'];

    $this->query = "UPDATE posts SET content = '$content', createdAt = NOW(), updated = true 
            WHERE id = $id";
    $this->insert();

    header("Location: $author");
    exit;
  }

  /**
   * Delete post.
   */
  public function delete(): void
  {
    $id = $_POST['id'];
    $author = $_POST['author'];

    $this->query = "DELETE FROM posts WHERE id = '$id'";
    $this->insert();

    header("Location: $author");
    exit;
  }

  /**
   * Create a slug for database to use.
   * @param string $string
   * @return string
   */
  private function slug($string): string
  {
    $slug = trim($string); /* Trim the string */
    $slug = preg_replace('/[^a-öA-Ö0-9 -]/', '', $slug); /* Only take alphanumerical characters, but keep the spaces and dashes too... */
    $slug = str_replace(' ', '-', $slug); /* Replace spaces by dashes */
    $slug = strtolower($slug); /* Make it lowercase */

    /* Check if generated slug collides with a slug in db */
    $this->query = "SELECT * FROM posts WHERE slug = '$slug'";
    $result = $this->select();

    if ($result)
      $slug = "$slug-" . count($result);

    return $slug;
  }

  /**
   * Create a read more tag after an amount of characters.
   * @param $content
   * @return string
   */
  public function read_more($content): string
  {
    $string = str_replace('&', '&amp;', $content);

    if (strlen($string) > 150) {
      $stringCut = substr($string, 0, 150);
      $endPoint = strrpos($stringCut, ' ');
      $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
      $string .= " ...";
    }

    return $string;
  }

  /**
   * Create a date string.
   */
  public function date(): string
  {
    $date = strtotime($this->post['createdAt']);
    $type = ($this->post['updated']) ? 'Uppdaterad' : 'Publicerad';

    $day = date("d", $date);
    $month = date("m", $date);

    $day = $this->number($day);
    $month = $this->number($month);

    $month = $this->month($month);
    $year = date("Y", $date);

    return "$type den $day $month $year";
  }

  /**
   * Remove the 0 from numbers below 10.
   * @param $value
   * @return string
   */
  public function number($value): string
  {
    if ($value[0] == '0') {
      return $value[1];
    }

    return $value;
  }

  /**
   * Return month in string format.
   * @param $index
   * @return string
   */
  public function month($index): string
  {
    $months = [
      'januari',
      'februari',
      'mars',
      'april',
      'maj',
      'juni',
      'juli',
      'augusti',
      'september',
      'oktober',
      'november',
      'december'
    ];

    return $months[$index - 1];
  }

  /**
   * Render view.
   * @param $title - title of the page.
   * @param $tmp - what template to render.
   * @param $redirect - set true to redirect.
   * @param $auth - set true check if a user is logged in.
   */
  public function render($title, $tmp, $redirect, $auth = false): void
  {
    $this->is_logged = $_SESSION['username'] ?? null;
    $this->title = $this->post['title'] ?? $title;

    /* Load header for all pages. */
    require TMP_PATH . "/header.php";

    /* If a pge needs to be redirected, such as signin or signup. */
    if ($redirect) {
      if (!$this->is_logged) {
        require TMP_PATH . $tmp;
      } else {
        header("Location: {$this->is_logged}");
        exit;
      }
    } else {
      /* User needs to be logged in to view a page. */
      ($auth) ?
        (($this->is_logged) ?
          require TMP_PATH . $tmp :
          require TMP_PATH . '/signin.php') :
        require TMP_PATH . $tmp;
    }

    /* Load footer for all pages. */
    require TMP_PATH . "/footer.php";
  }
}

/**
 * Init user and include it in index.php.
 */
$app = new App();

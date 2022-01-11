<?php

class Image
{
  private $base_path = '/~erimam-9/projekt';

  /**
   * Upload image
   */
  public function upload(): void
  {
    /* Setup all necessary variables. */
    $path = $this->path(); /* Create the pathname. */
    $size = $_FILES['upload']['size'];
    $file_tmp = $_FILES['upload']['tmp_name'];

    /* Check file size. Max 5MB */
    if ($size > 5000000) {
      $res = [
        "path" => null,
        "error" => 'Filen är för stor att ladda upp.'
      ];

      /* Prefer to return as json for CKEditor to handle it but not necessary. */
      echo json_encode($res);
    } else {
      /* Upload file. */
      move_uploaded_file($file_tmp, $path);

      $res = [
        "path" => "$this->base_path/$path",
        "error" => null
      ];

      echo json_encode($res);
    }
  }

  /**
   * Create the pathname for the uploaded image.
   * Make sure it does not collide with an existing image on the server.
   * @return string
   */
  private function path(): string
  {
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
    $size = strlen($chars);
    $str = '';

    for ($i = 0; $i < 20; $i++) {
      $str = $str . $chars[rand(0, $size - 1)];
    }

    $path = "public/img/"  . $str;

    if (file_exists($path)) {
      $this->path();
    }

    return $path;
  }

  /**
   * Delete image from server
   */
  public function delete(): void
  {
    $filename = $_POST['image'];
    $path = "public/img/"  . $filename;

    if (file_exists($path)) {
      unlink($path);
    }
  }
}

/**
 * Init image and include it in index.php.
 */
$image = new Image();

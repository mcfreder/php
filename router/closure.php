<?php

/* Match current request url */
$match = $router->match();

/* Call closure or load 404 page. */
(is_array($match) && is_callable($match['target'])) ?
  call_user_func_array($match['target'], $match['params']) :
  require TMP_PATH . '/404.php'; /* No route was matched. Load 404. */
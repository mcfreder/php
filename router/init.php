<?php

/**
 * This file initialize the router, also set base path.
 */
require __DIR__ . "/router.php";

/* Initialize the router */
$router = new Router();

/* Base path */
$router->setBasePath($GLOBALS["basePath"]);

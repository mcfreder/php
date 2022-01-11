<?php

/**
 * Creating constants for heavily used paths makes things a lot easier.
 */
defined("TMP_PATH")
  or define("TMP_PATH", realpath(dirname(__FILE__) . '/templates'));

defined("SRC_PATH")
  or define("SRC_PATH", realpath(dirname(__FILE__) . '/src'));

/**
 * Error reporting.
 */
error_reporting(-1);
ini_set("display_errors", 1);

<?php

/**
 * This is the global file for the website.
 */
require __DIR__ . "/config.php";
require __DIR__ . "/router/init.php";
require SRC_PATH . "/database.php";
require SRC_PATH . "/app.php";
require SRC_PATH . "/user.php";
require SRC_PATH . "/image.php";

/**
 * GET home page.
 */
$router->map('GET', '/', function () use ($app) {
  $app->posts();
  $app->users();

  $app->render('Nyheter från Sveriges bästa blogg!', '/index.php', false);
});

/**
 * GET signup.
 */
$router->map('GET', '/signup', function () use ($app) {
  $app->render('Skapa konto', '/signup.php', true);
});

/**
 * POST signup data
 */
$router->map('POST', '/signup', function () use ($user) {
  echo $user->register();
});

/**
 * GET signin.
 */
$router->map('GET', '/signin', function () use ($app) {
  $app->render('Logga in', '/signin.php', true);
});

/**
 * POST signin data
 */
$router->map('POST', '/signin', function () use ($user) {
  echo $user->login();
});

/**
 * Logout
 */
$router->map('GET', '/signout', function () use ($user) {
  $user->logout();
});

/**
 * GET create - create a post view.
 */
$router->map('GET', '/create', function () use ($app) {
  $app->render("Skapa ett nytt inlägg", '/post.php', false, true);
});

/**
 * POST create data
 */
$router->map('POST', '/create', function () use ($app) {
  $app->create();
});

/**
 * POST upload data
 */
$router->map('POST', '/upload', function () use ($image) {
  $image->upload();
});

/**
 * POST image data to delete on server
 */
$router->map('POST', '/image-delete', function () use ($image) {
  $image->delete();
});

/**
 * GET dynamic named blog, 
 */
$router->map('GET', '/[a:username]', function ($username) use ($app) {
  $app->get_posts($username);
  $app->get_latest_post();

  $app->render("@$username", '/blog.php', false);
});

/**
 * GET dynamic named blog with selected post, 
 */
$router->map('GET', '/[a:username]/[:slug]', function ($username, $slug) use ($app) {
  $app->get_posts($username);
  $app->get_post(urldecode($slug));

  $app->render('Finns inte!', '/blog.php', false);
});

/**
 * GET dynamic edit post, 
 */
$router->map('GET', '/[a:username]/[:slug]/edit', function ($username, $slug) use ($app) {
  $app->get_post(urldecode($slug));
  $app->blog = $username;

  $app->render("Redigera", '/update.php', false, true);
});

/**
 * POST edited post data, 
 */
$router->map('POST', '/update', function () use ($app) {
  $app->update();
});

/**
 * GET delete post page, 
 */
$router->map('GET', '/[a:username]/[:slug]/delete', function ($username, $slug) use ($app) {
  $app->get_post(urldecode($slug));
  $app->blog = $username;

  $app->render("Redigera", '/delete.php', false, true);
});

/**
 * POST edited post data, 
 */
$router->map('POST', '/delete', function () use ($app) {
  $app->delete();
});


/* Set closure to router */
require __DIR__ . "/router/closure.php";

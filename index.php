<?php
require_once './bootstrap.php';
// \trimination\cors();
$router = new router\Router(new router\Request());
$postsController = new \trimination\PostsController();

$router->get('/', $postsController->home);
$router->get('/:slug', $postsController->post);
$router->get('/', function() {

});

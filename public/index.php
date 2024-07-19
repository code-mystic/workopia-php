<?php
session_start();

require __DIR__ . '/../vendor/autoload.php';
require '../helper.php';
// require basePath('Framework/Database.php');
// require basePath('Framework/Router.php');

use Framework\Router;

$router = new Router();

$routes = require basePath('routes.php');

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->route($uri);


// loadView('home');

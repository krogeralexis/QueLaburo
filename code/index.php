<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once 'core/Router.php';
require_once 'config/database.php';

use Core\Router;

session_start();

$router = new Router();
$router->route();

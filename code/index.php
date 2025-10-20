<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/core/Router.php';
require_once __DIR__ . '/config/database.php';

use Core\Router;

session_start();

$url = $_GET['url'] ?? '';
$parts = explode('/', trim($url, '/'));

if ($parts[0] === 'admin') {
    $_SESSION['isAdminPanel'] = true;
    $_GET['url'] = implode('/', array_slice($parts, 1));
} else {
    $_SESSION['isAdminPanel'] = false;
}

$router = new Router();
$router->route();

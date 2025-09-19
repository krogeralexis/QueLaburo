<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'core/Router.php';
require_once 'config/database.php';

use Core\Router;

session_start();

// Detectamos si es panel de admin
$url = $_GET['url'] ?? '';
$parts = explode('/', trim($url, '/'));

    // Marcamos que estamos en panel de admin

if ($parts[0] === 'admin') {
    $_SESSION['isAdminPanel'] = true;

    // Quitamos el prefijo 'admin' para que el router siga funcionando normalmente
    
    $_GET['url'] = implode('/', array_slice($parts, 1));
} else {
    $_SESSION['isAdminPanel'] = false;
}

$router = new Router();
$router->route();

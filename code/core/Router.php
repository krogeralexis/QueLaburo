<?php
namespace Core;

class Router {

    public static function route() {
        // URL limpia o fallback
        $url = $_GET['url'] ?? '';

        if (empty($url)) 
        {
            // Toma la ruta directamente del REQUEST_URI
            $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            // Quita la carpeta base (si tu proyecto está dentro de /queLaburochill o similar)
            $basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
            $url = trim(str_replace($basePath, '', $uri), '/');
        }

        // Valores por defecto
        $controller = 'usuario';
        $action = 'index';

        if ($url) {
            $parts = explode('/', trim($url, '/'));

            // Rutas especiales: /admin o cualquier subruta de admin
            if ($parts[0] === 'admin') {
                $controller = 'adminauth';        // controlador para admin login
                $action = $parts[1] ?? 'login';   // si no hay acción, va a login
            } else {
                // URL normal tipo /usuario/index
                $controller = $parts[0] ?? 'usuario';
                $action = $parts[1] ?? 'index';
            }
        } else {
            // fallback con ?controller=usuario&action=index
            $controller = $_GET['controller'] ?? 'usuario';
            $action = $_GET['action'] ?? 'index';
        }

        // Limpieza básica para evitar caracteres extraños
        $controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
        $action = preg_replace('/[^a-zA-Z0-9]/', '', $action);

        $controllerClass = ucfirst($controller) . 'Controller';
        $controllerFile = __DIR__ . "/../controllers/{$controllerClass}.php";

        if (!file_exists($controllerFile)) die("Controlador no encontrado: {$controllerClass}");
        require_once $controllerFile;

        if (!class_exists($controllerClass)) die("Clase controlador no encontrada: {$controllerClass}");

        $controllerObj = new $controllerClass();

        if (!method_exists($controllerObj, $action)) die("Acción no encontrada: {$action}");

        $controllerObj->$action();
    }
}

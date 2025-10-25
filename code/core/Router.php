<?php
namespace Core;

class Router {
    public static function route() {
        // URL limpia o fallback
        $url = $_GET['url'] ?? '';

        // Valores por defecto
        $controller = 'usuario';
        $action = 'index';

        if ($url) 
        {
            $parts = explode('/', trim($url, '/'));

            // Rutas especiales: /admin o cualquier subruta de admin
            if ($parts[0] === 'admin') {
                $controller = 'adminauth';
                $action = $parts[1] ?? 'login';
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

        if (!file_exists($controllerFile)) die("Controlador no encontrado");
        require_once $controllerFile;

        if (!class_exists($controllerClass)) die("Clase controlador no encontrada");

        $controllerObj = new $controllerClass();

        if (!method_exists($controllerObj, $action)) die("Acción no encontrada");

        $controllerObj->$action();
    }
}

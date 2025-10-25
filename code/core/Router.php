<?php
namespace Core;

class Router {

    public static function route() {
        // URL limpia o fallback
        $url = $_GET['url'] ?? '';

        // Valores por defecto
        // $controller = 'usuario';
        // $action = 'index';

        if ($url) {
            $parts = explode('/', trim($url, '/'));
            echo "1";
            // Rutas especiales: /admin o cualquier subruta de admin
            if ($parts[0] === 'admin') {
                $controller = 'adminauth';        // controlador para admin login
                $action = $parts[1] ?? 'login';   // si no hay acción, va a login
                echo "2";
            } else {
                // URL normal tipo /usuario/index
                $controller = $parts[0] ?? 'usuario';
                $action = $parts[1] ?? 'index';
                echo "3";
            }
        } else {
            // fallback con ?controller=usuario&action=index
            echo "4";
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

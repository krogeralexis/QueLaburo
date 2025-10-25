<?php
namespace Core;

class Router {
    public static function route() {
        // Soporta URL limpia con ?url=usuario/index o fallback
        $url = $_GET['url'] ?? '';

        if ($url === 'admin') {
            // Atajo para /admin → login admin
            $controller = 'adminAuth';
            $action = 'login';
        } elseif ($url) {
            // URL limpia tipo /usuario/index
            $parts = explode('/', trim($url, '/'));
            $controller = $parts[0] ?? 'usuario';
            $action = $parts[1] ?? 'index';
        } else {
            // fallback con ?controller=usuario&action=index
            $controller = $_GET['controller'] ?? 'usuario';
            $action = $_GET['action'] ?? 'index';
        }

        // Limpieza básica
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

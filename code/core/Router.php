<?php
namespace Core;

class Router {
    public static function route() {
        // Obtener la URL desde ?url=usuario/index o fallback
        $url = $_GET['url'] ?? '';
        $controller = 'usuario';
        $action = 'index';

        if ($url) {
            // Quitar slashes y limpiar
            $parts = explode('/', trim($url, '/'));
            $controller = preg_replace('/[^a-zA-Z0-9]/', '', $parts[0] ?? $controller);
            $action     = preg_replace('/[^a-zA-Z0-9]/', '', $parts[1] ?? $action);
        } else {
            // Soporte por compatibilidad con ?controller=&action=
            $controller = preg_replace('/[^a-zA-Z0-9]/', '', $_GET['controller'] ?? $controller);
            $action     = preg_replace('/[^a-zA-Z0-9]/', '', $_GET['action'] ?? $action);
        }

        $controllerClass = ucfirst($controller) . 'Controller';
        $controllerFile  = __DIR__ . "/../controllers/{$controllerClass}.php";

        if (!file_exists($controllerFile)) {
            http_response_code(404);
            die("Controlador '{$controllerClass}' no encontrado");
        }

        require_once $controllerFile;

        if (!class_exists($controllerClass)) {
            http_response_code(500);
            die("Clase controlador '{$controllerClass}' no encontrada");
        }

        $controllerObj = new $controllerClass();

        if (!method_exists($controllerObj, $action)) {
            http_response_code(404);
            die("Acción '{$action}' no encontrada en controlador '{$controllerClass}'");
        }

        // Ejecutar acción
        $controllerObj->$action();
    }

    /**
     * Método helper para generar URLs “bonitas”
     * Ejemplo: Router::url('usuario/index') → /usuario/index
     */
    public static function url(string $path): string {
        $path = trim($path, '/');
        return "/{$path}";
    }
}

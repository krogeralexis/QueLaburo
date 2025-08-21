<?php
namespace Core;

class Router {
    public static function route() {
        $controller = $_GET['controller'] ?? 'login';
        $action = $_GET['action'] ?? 'index';

        // Limpieza básica
        $controller = preg_replace('/[^a-zA-Z0-9]/', '', $controller);
        $action = preg_replace('/[^a-zA-Z0-9]/', '', $action);

        $controllerClass = ucfirst($controller) . 'Controller';
        $controllerFile = "controllers/{$controllerClass}.php";

        if (!file_exists($controllerFile)) {
            die("Controlador no encontrado");
        }

        require_once $controllerFile;
        if (!class_exists($controllerClass)) {
            die("Clase controlador no encontrada");
        }

        $controllerObj = new $controllerClass();

        if (!method_exists($controllerObj, $action)) {
            die("Acción no encontrada");
        }

        $controllerObj->$action();
    }
}

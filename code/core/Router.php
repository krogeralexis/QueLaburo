<?php
namespace Core;

class Router {
/**
 * Función para enrutar la lógica de routing de la aplicación.
 * Recibe la URL limpia o fallback, y devuelve los valores por defecto
 * de controller y action. Luego, dependiendo de la URL, se establecen
 * los valores de controller y action. Si no se proporciona una URL,
 * se utiliza el fallback con ?controller=usuario&action=index. Se
 * proporciona una URL, se establecen los valores de controller y action
 * según la ruta especificada. Por último, se verifica si el controlador
 * y la acción existen, y si no es así, se muere un mensaje de error.
 */
    public static function route() {
        // URL limpia o fallback
        $url = $_GET['url'] ?? '';

        // Valores por defecto
        $controller = 'usuario';
        $action = 'index';

        if ($url) 
        {
            $parts = explode('/', trim($url, '/'));

            echo $url;

            // Rutas especiales: /admin o cualquier subruta de admin
            if ($parts[0] == 'admin') {
                $controller = 'adminauth';
                $action = $parts[1] ?? 'login';
                echo $url;
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

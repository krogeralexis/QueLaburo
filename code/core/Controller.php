<?php
namespace Core;

class Controller {
    protected function loadModel(string $modelName) {
        $modelClass = "Models\\$modelName";
        if (class_exists($modelClass)) {
            return new $modelClass();
        }
        throw new \Exception("Modelo $modelName no encontrado");
    }

    protected function redirect(string $url) {
        header("Location: $url");
        exit;
    }
}

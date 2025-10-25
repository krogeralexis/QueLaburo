<?php
namespace Core;

class Controller {
    protected function render($view, $data = []) {
        \Core\View::render($view, $data);
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }
}

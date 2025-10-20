<?php
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../core/View.php';

class ServicioController {
    public function __construct() {
        $action = $_GET['action'] ?? '';
        $accionesPermitidas = [];

        if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    public function index() {
        $servicioModel = new Servicio();
        $servicios = $servicioModel->getAll(); // Trae los servicios de la BD
        View::render('servicio/index', ['servicios' => $servicios]);
    }

    public function create() {
        Core\View::render('servicio/create');
    }

    public function store() {
        $disponibilidad = filter_input(INPUT_POST, 'disponibilidad', FILTER_SANITIZE_STRING);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING);

        if ($titulo && $precio !== false) {
            $servicio = new Servicio();
            $servicio->create($disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen);
        }

        header('Location: index.php?controller=servicio&action=index');
    }

    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $servicio = new Servicio();
            $data = $servicio->getById($id);
            Core\View::render('servicio/edit', ['servicio' => $data]);
        }
    }

    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $disponibilidad = filter_input(INPUT_POST, 'disponibilidad', FILTER_SANITIZE_STRING);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING);

        if ($id && $titulo && $precio !== false) {
            $servicio = new Servicio();
            $servicio->update($id, $disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen);
        }

        header('Location: index.php?controller=servicio&action=index');
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $servicio = new Servicio();
            $servicio->delete($id);
        }

        header('Location: index.php?controller=servicio&action=index');
    }
}

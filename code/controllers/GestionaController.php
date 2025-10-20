<?php
require_once __DIR__ . '/../models/Gestiona.php';
require_once __DIR__ . '/../core/View.php';

class GestionaController {
    public function __construct() 
    {
        /*Premade de seguridad para no permitr a usuarios no
        logeados entrar a los controller, metodo $accionesPermitidas
        permite evadirlo para poder hacer pruebas
        */
    $action = $_GET['action'] ?? '';

    $accionesPermitidas = [];

    if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) 
        {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }
    public function index() {
        $gestiona = new Gestiona();
        $datos = $gestiona->getAll();
        Core\View::render('gestiona/index', ['datos' => $datos]);
    }

    public function create() {
        Core\View::render('gestiona/create');
    }

    public function store() {
        $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
        $id_administrador = filter_input(INPUT_POST, 'id_administrador', FILTER_VALIDATE_INT);
        $fecha_gestion = filter_input(INPUT_POST, 'fecha_gestion', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);

        if ($id_usuario && $id_administrador) {
            $gestiona = new Gestiona();
            $gestiona->create($id_usuario, $id_administrador, $fecha_gestion, $descripcion);
        }
        header('Location: index.php?controller=gestiona&action=index');
    }

    public function edit() {
        $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
        $id_administrador = filter_input(INPUT_GET, 'id_administrador', FILTER_VALIDATE_INT);

        if ($id_usuario && $id_administrador) {
            $gestiona = new Gestiona();
            $dato = $gestiona->getById($id_usuario, $id_administrador);
            Core\View::render('gestiona/edit', ['dato' => $dato]);
        }
    }

    public function update() {
        $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
        $id_administrador = filter_input(INPUT_POST, 'id_administrador', FILTER_VALIDATE_INT);
        $fecha_gestion = filter_input(INPUT_POST, 'fecha_gestion', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);

        if ($id_usuario && $id_administrador) {
            $gestiona = new Gestiona();
            $gestiona->update($id_usuario, $id_administrador, $fecha_gestion, $descripcion);
        }
        header('Location: index.php?controller=gestiona&action=index');
    }

    public function delete() {
        $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
        $id_administrador = filter_input(INPUT_GET, 'id_administrador', FILTER_VALIDATE_INT);

        if ($id_usuario && $id_administrador) {
            $gestiona = new Gestiona();
            $gestiona->delete($id_usuario, $id_administrador);
        }
        header('Location: index.php?controller=gestiona&action=index');
    }
}

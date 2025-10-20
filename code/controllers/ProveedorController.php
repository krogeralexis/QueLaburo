<?php
require_once 'models/Proveedor.php';
require_once 'core/View.php';

class ProveedorController {
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
        $proveedor = new Proveedor();
        $proveedores = $proveedor->getAll();
        Core\View::render('adminPanel/proveedor/index', ['proveedores' => $proveedores]);
    }

    public function create() {
        Core\View::render('adminPanel/proveedor/create');
    }

    public function store() {
    // Sanitización manual
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_UNSAFE_RAW);
        $nombre = $nombre ? trim(strip_tags($nombre)) : null;

        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);

        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_UNSAFE_RAW);
        $telefono = $telefono ? trim(strip_tags($telefono)) : null;

        $referencias = filter_input(INPUT_POST, 'referencias', FILTER_UNSAFE_RAW);
        $referencias = $referencias ? trim(strip_tags($referencias)) : null;

        $calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT);
        $ventas = filter_input(INPUT_POST, 'cantidad_ventas', FILTER_VALIDATE_INT);

    // Validación mínima: que nombre, correo y telefono existan
    if ($nombre && $correo && $telefono) 
    {
        $proveedor = new Proveedor();
        $proveedor->create($nombre, $correo, $telefono, $referencias, $calificacion, $ventas);
    }

    header('Location: index.php?controller=proveedor&action=index');
}

    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $proveedor = new Proveedor();
            $data = $proveedor->getById($id);
            Core\View::render('adminPanel/proveedor/edit', ['proveedor' => $data]);
        }
    }

    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $referencias = filter_input(INPUT_POST, 'referencias', FILTER_SANITIZE_STRING);
        $calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT);
        $ventas = filter_input(INPUT_POST, 'cantidad_ventas', FILTER_VALIDATE_INT);

        if ($id && $nombre && $correo && $telefono !== false) {
            $proveedor = new Proveedor();
            $proveedor->update($id, $nombre, $correo, $telefono, $referencias, $calificacion, $ventas);
        }
        header('Location: index.php?controller=proveedor&action=index');
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $proveedor = new Proveedor();
            $proveedor->delete($id);
        }
        header('Location: index.php?controller=proveedor&action=index');
    }
}
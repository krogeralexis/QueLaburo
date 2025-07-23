<?php
// controllers/ProveedorController.php
require_once 'models/Proveedor.php';
require_once 'core/View.php';

class ProveedorController {
    public function index() {
        $proveedor = new Proveedor();
        $proveedores = $proveedor->getAll();
        Core\View::render('proveedor/index', ['proveedores' => $proveedores]);
    }

    public function create() {
        Core\View::render('proveedor/create');
    }

    public function store() {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $referencias = filter_input(INPUT_POST, 'referencias', FILTER_SANITIZE_STRING);
        $calificacion = filter_input(INPUT_POST, 'calificacion', FILTER_VALIDATE_FLOAT);
        $ventas = filter_input(INPUT_POST, 'cantidad_ventas', FILTER_VALIDATE_INT);

        if ($nombre && $correo && $telefono !== false) {
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
            Core\View::render('proveedor/edit', ['proveedor' => $data]);
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
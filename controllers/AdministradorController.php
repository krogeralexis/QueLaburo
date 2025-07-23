<?php
// controllers/AdministradorController.php
require_once 'models/Administrador.php';
require_once 'core/View.php';

class AdministradorController {
    public function index() {
        $admin = new Administrador();
        $admins = $admin->getAll();
        Core\View::render('administrador/index', ['administradores' => $admins]);
    }

    public function create() {
        Core\View::render('administrador/create');
    }

    public function store() {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $especialidad = filter_input(INPUT_POST, 'especialidad', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        $cantrep = filter_input(INPUT_POST, 'cantrep_resuelto', FILTER_VALIDATE_INT);

        if ($nombre && $correo && $telefono) {
            $admin = new Administrador();
            $admin->create($nombre, $correo, $telefono, $especialidad, $estado, $cantrep);
        }
        header('Location: index.php?controller=administrador&action=index');
    }

    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $admin = new Administrador();
            $data = $admin->getById($id);
            Core\View::render('administrador/edit', ['admin' => $data]);
        }
    }

    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $especialidad = filter_input(INPUT_POST, 'especialidad', FILTER_SANITIZE_STRING);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        $cantrep = filter_input(INPUT_POST, 'cantrep_resuelto', FILTER_VALIDATE_INT);

        if ($id && $nombre && $correo && $telefono) {
            $admin = new Administrador();
            $admin->update($id, $nombre, $correo, $telefono, $especialidad, $estado, $cantrep);
        }
        header('Location: index.php?controller=administrador&action=index');
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $admin = new Administrador();
            $admin->delete($id);
        }
        header('Location: index.php?controller=administrador&action=index');
    }
}
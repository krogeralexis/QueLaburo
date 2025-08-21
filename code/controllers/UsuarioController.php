<?php
// controllers/UsuarioController.php
require_once 'models/Usuario.php';
require_once 'core/View.php';

class UsuarioController {
    public function __construct() {
    $action = $_GET['action'] ?? '';

    // Permitimos temporalmente acceder a estas acciones sin login
    $accionesPermitidas = ['index', 'create', 'store'];

    if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
        header('Location: index.php?controller=login&action=index');
        exit;
    }
}

    public function index() {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll();
        require 'views/usuario/index.php';
    }
    

    public function create() {
        Core\View::render('usuario/create');
    }

   public function store() {
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
    $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
    $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
    $password = $_POST['password'] ?? null;

    if ($nombre && $correo && $telefono && $password) {
        $usuario = new Usuario();
        $usuario->create($nombre, $correo, $telefono, $password);
        header('Location: index.php?controller=login&action=index');
        exit;
    }

    // Si hay campos faltantes, podrías mostrar error o redirigir
    header('Location: index.php?controller=login&action=register');
    exit;
}


    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $usuario = new Usuario();
            $data = $usuario->getById($id);
            Core\View::render('usuario/edit', ['usuario' => $data]);
        }
    }

    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);

        if ($id && $nombre && $correo && $telefono) {
            $usuario = new Usuario();
            $usuario->update($id, $nombre, $correo, $telefono);
        }
        header('Location: index.php?controller=usuario&action=index');
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $usuario = new Usuario();
            $usuario->delete($id);
        }
        header('Location: index.php?controller=usuario&action=index');
    }
}

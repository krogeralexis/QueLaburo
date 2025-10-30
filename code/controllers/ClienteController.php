<?php
// controllers/ClienteController.php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../core/View.php';

class ClienteController {

    public function __construct() 
    {
        // Bloqueo general de acceso a usuarios no logueados
        $action = $_GET['action'] ?? '';

        if (!isset($_SESSION['usuario']) && !in_array($action, )) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    // ---------- CRUD ADMIN ----------
    public function index() {
        $cliente = new Cliente();
        $clientes = $cliente->getAll();
        Core\View::render('adminPanel/cliente/index', ['clientes' => $clientes]);
    }

    public function create() {
        Core\View::render('adminPanel/cliente/create');
    }

    public function store() {
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $calificaciones = filter_input(INPUT_POST, 'calificaciones', FILTER_VALIDATE_INT);

        if ($nombre && $correo && $telefono !== false) {
            $cliente = new Cliente();
            $cliente->create($nombre, $correo, $telefono, $calificaciones);
        }
        header('Location: index.php?controller=cliente&action=index');
    }

    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $cliente = new Cliente();
            $data = $cliente->getById($id);
            Core\View::render('adminPanel/cliente/edit', ['cliente' => $data]);
        }
    }

    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
        $telefono = filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING);
        $calificaciones = filter_input(INPUT_POST, 'calificaciones', FILTER_VALIDATE_INT);

        if ($id && $nombre && $correo && $telefono !== false) {
            $cliente = new Cliente();
            $cliente->update($id, $nombre, $correo, $telefono, $calificaciones);
        }
        header('Location: index.php?controller=cliente&action=index');
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $cliente = new Cliente();
            $cliente->delete($id);
        }
        header('Location: index.php?controller=cliente&action=index');
    }

    // ---------- CLIENTE PANEL ----------

    
    public function verReservas() {
    $id_usuario = $_SESSION['usuario']['id'] ?? null;

    if (!$id_usuario) {
        $_SESSION['flash_error'] = "Debes iniciar sesión.";
        header('Location: index.php?controller=login&action=index');
        exit;
    }

    $servicioModel = new Servicio();
    $servicios = $servicioModel->getServiciosPorCliente($id_usuario);

    Core\View::render('cliente/misReservas', [
        'servicios' => $servicios
    ]);
}



}

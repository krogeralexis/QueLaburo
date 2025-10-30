<?php
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../core/View.php';

class ReservaController {
    public function __construct() 
    {
        $action = $_GET['action'] ?? '';
        $accionesPermitidas = [];

        if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    public function index() {
        $reserva = new Reserva();
        $reservas = $reserva->getAll();
        Core\View::render('reserva/index', ['reservas' => $reservas]);
    }

    public function create() {
        Core\View::render('reserva/create');
    }

    // ✅ CREA RESERVA + MENSAJE AUTOMÁTICO
    public function store() {
        $id_servicio    = isset($_POST['id_servicio']) ? (int)$_POST['id_servicio'] : 0;
        $fecha_reserva  = trim($_POST['fecha_reserva'] ?? '');
        $resena         = htmlspecialchars($_POST['resena'] ?? '', ENT_QUOTES, 'UTF-8');
        $notas          = htmlspecialchars($_POST['notas'] ?? '', ENT_QUOTES, 'UTF-8');

        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        if (!$id_usuario) {
            $_SESSION['flash_error'] = "Debes iniciar sesión para reservar.";
            header('Location: index.php?controller=login&action=index');
            exit;
        }

        if ($fecha_reserva && strpos($fecha_reserva, 'T') !== false) {
            $fecha_reserva = str_replace('T', ' ', $fecha_reserva) . ':00';
        }

        require_once __DIR__ . '/../models/Servicio.php';
        $servicioModel = new Servicio();
        $serv = $servicioModel->getById($id_servicio);
        if (!$serv) {
            $_SESSION['flash_error'] = "Servicio no encontrado.";
            header('Location: index.php?controller=servicio&action=index');
            exit;
        }

        $id_proveedor = $serv['id_proveedor'];

        require_once __DIR__ . '/../models/Cliente.php';
        $clienteModel = new Cliente();
        if (!$clienteModel->getById($id_usuario)) {
            $clienteModel->create($id_usuario);
        }

        $reservaModel = new Reserva();
        if (!$reservaModel->isDisponible($id_servicio, $fecha_reserva)) {
            $_SESSION['flash_error'] = "La fecha/hora seleccionada ya está reservada.";
            header("Location: index.php?controller=servicio&action=verServicio&id={$id_servicio}");
            exit;
        }

        // Crear la reserva
        $id_reserva = $reservaModel->create(
            $id_usuario,
            $id_proveedor,
            $id_servicio,
            $resena,
            $fecha_reserva,
            $notas
        );

        // 🔔 Enviar mensaje automático al proveedor
        require_once __DIR__ . '/../models/Mensaje.php';
        $mensajeModel = new Mensaje();

        $clienteNombre = $_SESSION['usuario']['nombre'] ?? 'Un usuario';
        $contenido = "📅 Nueva reserva creada:  
Servicio: {$serv['titulo']}  
Fecha: {$fecha_reserva}  
Cliente: {$clienteNombre}  
ID de reserva: {$id_reserva}.  
Notas: {$notas}";

        $mensajeModel->createAutomatic($id_usuario, $id_proveedor, $contenido);

        $_SESSION['flash_success'] = "Reserva creada y proveedor notificado.";
        header('Location: index.php?controller=cliente&action=verReservas');
        exit;
    }

    // ✅ CONFIRMAR RESERVA (envía mensaje automático al cliente)
    public function confirm() {
        $id_reserva = filter_input(INPUT_POST, 'id_reserva', FILTER_VALIDATE_INT);
        if (!$id_reserva) {
            header('Location: index.php?controller=proveedor&action=misServicios');
            exit;
        }

        $reservaModel = new Reserva();
        $res = $reservaModel->getById($id_reserva);
        if (!$res) {
            $_SESSION['flash_error'] = "Reserva no encontrada.";
            header('Location: index.php?controller=proveedor&action=misServicios');
            exit;
        }

        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id'] != $res['id_proveedor']) {
            $_SESSION['flash_error'] = "No tenés permisos para confirmar esta reserva.";
            header('Location: index.php?controller=proveedor&action=misServicios');
            exit;
        }

        $reservaModel->updateEstado($id_reserva, 'confirmada');

        require_once __DIR__ . '/../models/Mensaje.php';
        $mensajeModel = new Mensaje();
        $mensajeModel->createAutomatic(
            $_SESSION['usuario']['id'],
            $res['id_cliente'],
            "✅ Tu reserva #{$id_reserva} fue confirmada por el proveedor."
        );

        $_SESSION['flash_success'] = "Reserva confirmada y cliente notificado.";
        header('Location: index.php?controller=proveedor&action=misServicios');
    }

    // ✅ CANCELAR RESERVA (mensaje automático a la otra parte)
    public function cancel() {
        $id_reserva = filter_input(INPUT_POST, 'id_reserva', FILTER_VALIDATE_INT);
        if (!$id_reserva) {
            header('Location: index.php?controller=cliente&action=verReservas');
            exit;
        }

        $reservaModel = new Reserva();
        $res = $reservaModel->getById($id_reserva);
        if (!$res) {
            $_SESSION['flash_error'] = "Reserva no encontrada.";
            header('Location: index.php?controller=cliente&action=verReservas');
            exit;
        }

        if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['id'], [$res['id_cliente'], $res['id_proveedor']])) {
            $_SESSION['flash_error'] = "No tenés permisos para cancelar esta reserva.";
            header('Location: index.php?controller=cliente&action=verReservas');
            exit;
        }

        $reservaModel->cancel($id_reserva);

        require_once __DIR__ . '/../models/Mensaje.php';
        $mensajeModel = new Mensaje();

        $actor = $_SESSION['usuario']['nombre'] ?? 'Usuario';
        $destino = ($_SESSION['usuario']['id'] == $res['id_cliente']) ? $res['id_proveedor'] : $res['id_cliente'];

        $mensajeModel->createAutomatic(
            $_SESSION['usuario']['id'],
            $destino,
            "❌ La reserva #{$id_reserva} fue cancelada por {$actor}."
        );

        $_SESSION['flash_success'] = "Reserva cancelada y mensaje enviado.";
        header('Location: index.php?controller=cliente&action=verReservas');
    }
}

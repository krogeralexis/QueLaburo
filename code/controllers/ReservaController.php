<?php
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../core/View.php';

class ReservaController {
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
        $reserva = new Reserva();
        $reservas = $reserva->getAll();
        Core\View::render('reserva/index', ['reservas' => $reservas]);
    }

    public function create() {
        Core\View::render('reserva/create');
    }

public function store() {
    // Recibir y sanitizar POST
    $id_servicio    = isset($_POST['id_servicio']) ? (int)$_POST['id_servicio'] : 0;
    $fecha_reserva  = trim($_POST['fecha_reserva'] ?? '');
    $resena         = htmlspecialchars($_POST['resena'] ?? '', ENT_QUOTES, 'UTF-8');
    $notas          = htmlspecialchars($_POST['notas'] ?? '', ENT_QUOTES, 'UTF-8'); // nuevo campo

    // Validar sesión de usuario
    $id_usuario = $_SESSION['usuario']['id'] ?? null;
    if (!$id_usuario) {
        $_SESSION['flash_error'] = "Debes iniciar sesión para reservar.";
        header('Location: index.php?controller=login&action=index');
        exit;
    }

    // Normalizar datetime-local (si vino con T)
    if ($fecha_reserva && strpos($fecha_reserva, 'T') !== false) {
        $fecha_reserva = str_replace('T', ' ', $fecha_reserva) . ':00';
    }

    // Validar servicio
    require_once __DIR__ . '/../models/Servicio.php';
    $servicioModel = new Servicio();
    $serv = $servicioModel->getById($id_servicio);
    if (!$serv) {
        $_SESSION['flash_error'] = "Servicio no encontrado.";
        header('Location: index.php?controller=servicio&action=index');
        exit;
    }

    $id_proveedor = $serv['id_proveedor'];

    // Crear cliente si no existe
    require_once __DIR__ . '/../models/Cliente.php';
    $clienteModel = new Cliente();
    if (!$clienteModel->getById($id_usuario)) {
        $clienteModel->create($id_usuario); // Adaptado a tu tabla Cliente
    }

    // Verificar disponibilidad exacta (misma fecha y hora)
    $reservaModel = new Reserva();
    if (!$reservaModel->isDisponible($id_servicio, $fecha_reserva)) {
        $_SESSION['flash_error'] = "La fecha/hora seleccionada ya está reservada para este servicio.";
        header("Location: index.php?controller=servicio&action=verServicio&id={$id_servicio}");
        exit;
    }

    // Crear la reserva con notas
    $id_reserva = $reservaModel->create(
        $id_usuario,
        $id_proveedor,
        $id_servicio,
        $resena,
        $fecha_reserva,
        $notas
    );

    // Crear mensaje automático al proveedor
    require_once __DIR__ . '/../models/Mensaje.php';
    $mensajeModel = new Mensaje();
    $clienteNombre = $_SESSION['usuario']['nombre'] ?? 'Un usuario';
    $contenido = "Nueva reserva pendiente para el servicio '{$serv['titulo']}' el {$fecha_reserva}. 
Cliente: {$clienteNombre}. 
ID de reserva: {$id_reserva}. Notas: {$notas}";
    $mensajeModel->createAutomatic($id_usuario, $id_proveedor, $contenido);

    // Redirigir al panel del cliente
    $_SESSION['flash_success'] = "Reserva creada correctamente. El proveedor fue notificado.";
    header('Location: index.php?controller=cliente&action=verReservas');
    exit;
}



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
    // Validar que el usuario sea el proveedor dueño
    if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id'] != $res['id_proveedor']) {
        $_SESSION['flash_error'] = "No tenés permisos para confirmar esta reserva.";
        header('Location: index.php?controller=proveedor&action=misServicios');
        exit;
    }
    $reservaModel->updateEstado($id_reserva, 'confirmada');

    // Notificar cliente
    require_once __DIR__ . '/../models/Mensaje.php';
    $mensajeModel = new Mensaje();
    $contenido = "Tu reserva #{$id_reserva} para el servicio fue confirmada por el proveedor.";
    $mensajeModel->createAutomatic($_SESSION['usuario']['id'], $res['id_cliente'], $contenido);

    $_SESSION['flash_success'] = "Reserva confirmada.";
    header('Location: index.php?controller=proveedor&action=misServicios');
}

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
    // Solo cliente dueño o proveedor dueño puede cancelar (ajustalo si querés)
    if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['id'], [$res['id_cliente'], $res['id_proveedor']])) {
        $_SESSION['flash_error'] = "No tenés permisos para cancelar esta reserva.";
        header('Location: index.php?controller=cliente&action=verReservas');
        exit;
    }
    $reservaModel->cancel($id_reserva);

    // Notificar la otra parte
    require_once __DIR__ . '/../models/Mensaje.php';
    $mensajeModel = new Mensaje();
    $actor = $_SESSION['usuario']['nombre'] ?? 'Usuario';
    $destino = ($_SESSION['usuario']['id'] == $res['id_cliente']) ? $res['id_proveedor'] : $res['id_cliente'];
    $mensajeModel->createAutomatic($_SESSION['usuario']['id'], $destino, "La reserva #{$id_reserva} fue cancelada por {$actor}.");

    $_SESSION['flash_success'] = "Reserva cancelada.";
    header('Location: index.php?controller=cliente&action=verReservas');
}




    public function edit() {
        $id_reserva = filter_input(INPUT_GET, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_GET, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_GET, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_GET, 'id_servicio', FILTER_VALIDATE_INT);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) {
            $reserva = new Reserva();
            $data = $reserva->getById($id_reserva, $id_cliente, $id_proveedor, $id_servicio);
            Core\View::render('reserva/edit', ['reserva' => $data]);
        }
    }

    public function update() {
        $id_reserva = filter_input(INPUT_POST, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT);
        $recordatorio = filter_input(INPUT_POST, 'recordatorio', FILTER_SANITIZE_STRING);
        $resena = filter_input(INPUT_POST, 'resena', FILTER_SANITIZE_STRING);
        $fecha_reserva = filter_input(INPUT_POST, 'fecha_reserva', FILTER_SANITIZE_STRING);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) {
            $reserva = new Reserva();
            $reserva->update($id_reserva, $id_cliente, $id_proveedor, $id_servicio, $recordatorio, $resena, $fecha_reserva);
        }
        header('Location: index.php?controller=reserva&action=index');
    }

    public function delete() {
        $id_reserva = filter_input(INPUT_GET, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_GET, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_GET, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_GET, 'id_servicio', FILTER_VALIDATE_INT);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) {
            $reserva = new Reserva();
            $reserva->delete($id_reserva, $id_cliente, $id_proveedor, $id_servicio);
        }
        header('Location: index.php?controller=reserva&action=index');
    }
}

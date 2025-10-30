<?php
require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../models/Servicio.php';
class MensajeController {

    public function __construct() {
        $action = $_GET['action'] ?? '';
        $accionesPermitidas = []; // Para acciones públicas o test

        if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    // Mostrar buzón de mensajes (modo admin)
    public function index() {
        $msg = new Mensaje();
        $id_usuario = $_SESSION['usuario']['id'] ?? null;

        if (!$id_usuario) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }

        $mensajes = $msg->getByUsuario($id_usuario);
        Core\View::render('adminPanel/mensaje/index', ['mensajes' => $mensajes]);
    }

    // Mostrar formulario para crear mensaje (admin)
    public function create() {
        Core\View::render('adminPanel/mensaje/create');
    }

    // Guardar mensaje desde formulario (admin)
    public function store() {
        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        $id_emisor = filter_input(INPUT_POST, 'id_emisor', FILTER_VALIDATE_INT);
        $id_receptor = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);
        $contenido = htmlspecialchars($_POST['contenido'] ?? '', ENT_QUOTES, 'UTF-8');
        $estado = $_POST['estado'] ?? 'recibido_noleido';

        if (!$id_usuario || !$id_emisor || !$id_receptor || empty($contenido)) {
            header('Location: index.php?controller=mensaje&action=create&error=1');
            exit;
        }

        $msg = new Mensaje();
        $msg->create($id_emisor, $id_receptor, $contenido, $estado);
        header('Location: index.php?controller=mensaje&action=index');
    }

    // Editar mensaje
    public function edit() {
        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);

        if (!$id_usuario || !$id_mensaje) {
            header('Location: index.php?controller=mensaje&action=index');
            exit;
        }

        $msg = new Mensaje();
        $data = $msg->getById($id_usuario, $id_mensaje);
        if (!$data) {
            header('Location: index.php?controller=mensaje&action=index');
            exit;
        }

        Core\View::render('adminPanel/mensaje/edit', ['mensaje' => $data]);
    }

    // Actualizar mensaje
    public function update() {
        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        $id_mensaje = filter_input(INPUT_POST, 'id_mensaje', FILTER_VALIDATE_INT);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        $contenido = htmlspecialchars($_POST['contenido'] ?? '', ENT_QUOTES, 'UTF-8');

        if (!$id_usuario || !$id_mensaje) {
            header('Location: index.php?controller=mensaje&action=index');
            exit;
        }

        $msg = new Mensaje();
        $msg->update($id_usuario, $id_mensaje, $estado, $contenido);
        header('Location: index.php?controller=mensaje&action=index');
    }

    // Eliminar mensaje
    public function delete() {
        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);

        if (!$id_usuario || !$id_mensaje) {
            header('Location: index.php?controller=mensaje&action=index');
            exit;
        }

        $msg = new Mensaje();
        $msg->delete($id_usuario, $id_mensaje);
        header('Location: index.php?controller=mensaje&action=index');
    }

    // Marcar mensaje como leído
    public function marcarLeido() {
        $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);
        if ($id_mensaje) {
            $msg = new Mensaje();
            $msg->marcarLeido($id_mensaje);
        }
        header('Location: index.php?controller=mensaje&action=index');
    }

    // Vista principal del chat (panel del usuario)
    public function mensajeria() {
    $usuario = $_SESSION['usuario'] ?? null;
    if (!$usuario) {
        header('Location: index.php?controller=login&action=index');
        exit;
    }

    $id_usuario = $usuario['id'] ?? null;
    if (!$id_usuario) {
        header('Location: index.php?controller=login&action=index');
        exit;
    }

    // Cargamos contactos a partir de reservas (sin crear tablas nuevas)
    require_once __DIR__ . '/../models/Reserva.php';
    $reservaModel = new Reserva();

    try {
        $contactos = $reservaModel->getContactosPorReservas($id_usuario);
    } catch (\Exception $e) {
        // En caso de error devolvemos lista vacía para no romper la vista
        $contactos = [];
        error_log("Error al obtener contactos por reservas: " . $e->getMessage());
    }

    Core\View::render('usuario/mensajeria', [
        'contactos' => $contactos,
        'usuario' => $usuario
    ]);
}


    // API: obtener contactos
    public function getContactos() {
        $usuario = new Usuario();
        $id_actual = $_SESSION['usuario']['id'];
        $usuarios = $usuario->getAll();
        $contactos = array_filter($usuarios, fn($u) => $u['id'] != $id_actual);
        header('Content-Type: application/json');
        echo json_encode(array_values($contactos));
    }

    // API: obtener conversación
    public function getConversacion() {
        $msg = new Mensaje();
        $id_emisor = $_SESSION['usuario']['id'];
        $id_receptor = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $conversacion = $msg->getConversacionEntre($id_emisor, $id_receptor);
        header('Content-Type: application/json');
        echo json_encode($conversacion);
    }

    // API: enviar mensaje
    public function enviarMensaje() {
        header('Content-Type: application/json');

        $id_emisor = $_SESSION['usuario']['id'] ?? null;
        $id_receptor = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);
        $contenido = trim($_POST['contenido'] ?? '');

        if (!$id_emisor || !$id_receptor || empty($contenido)) {
            echo json_encode(['error' => 'Datos incompletos']);
            return;
        }

        $msg = new Mensaje();
        $msg->create($id_emisor, $id_receptor, htmlspecialchars($contenido, ENT_QUOTES, 'UTF-8'));

        echo json_encode(['success' => true]);
    }
}

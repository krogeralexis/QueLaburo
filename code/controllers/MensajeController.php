<?php
require_once 'models/Mensaje.php';
require_once 'core/View.php';

class MensajeController {

    public function __construct() 
    {
        /*Premade de seguridad para no permitr a usuarios no
        logeados entrar a los controller, metodo $accionesPermitidas
        permite evadirlo para poder hacer pruebas
        */
    $action = $_GET['action'] ?? '';

    $accionesPermitidas = []; // ['function','function'] para acceder a alguna funcion

    if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) 
        {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    public function index() {
        $msg = new Mensaje();
        $mensajes = $msg->getAll();
        Core\View::render('mensaje/index', ['mensajes' => $mensajes]);
    }

    public function create() {
        Core\View::render('mensaje/create');
    }

    public function store() {
        $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
        $id_emisor = filter_input(INPUT_POST, 'id_emisor', FILTER_VALIDATE_INT);
        $id_receptor = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);
        $id_mensaje = filter_input(INPUT_POST, 'id_mensaje', FILTER_VALIDATE_INT);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        $notificacion = filter_input(INPUT_POST, 'notificacion', FILTER_SANITIZE_STRING);
        $fecha = filter_input(INPUT_POST, 'fecha', FILTER_SANITIZE_STRING);

        if ($id_usuario && $id_emisor && $id_receptor && $id_mensaje) {
            $msg = new Mensaje();
            $msg->create($id_usuario, $id_emisor, $id_receptor, $id_mensaje, $estado, $notificacion, $fecha);
        }
        header('Location: index.php?controller=mensaje&action=index');
    }

    public function edit() {
        $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
        $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);

        if ($id_usuario && $id_mensaje) {
            $msg = new Mensaje();
            $data = $msg->getById($id_usuario, $id_mensaje);
            Core\View::render('mensaje/edit', ['mensaje' => $data]);
        }
    }

    public function update() {
        $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
        $id_mensaje = filter_input(INPUT_POST, 'id_mensaje', FILTER_VALIDATE_INT);
        $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
        $notificacion = filter_input(INPUT_POST, 'notificacion', FILTER_SANITIZE_STRING);

        if ($id_usuario && $id_mensaje) {
            $msg = new Mensaje();
            $msg->update($id_usuario, $id_mensaje, $estado, $notificacion);
        }
        header('Location: index.php?controller=mensaje&action=index');
    }

    public function delete() {
        $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
        $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);

        if ($id_usuario && $id_mensaje) {
            $msg = new Mensaje();
            $msg->delete($id_usuario, $id_mensaje);
        }
        header('Location: index.php?controller=mensaje&action=index');
    }
}

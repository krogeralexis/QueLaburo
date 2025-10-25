<?php
require_once __DIR__ . '/../models/Reserva.php';
require_once __DIR__ . '/../core/View.php';

class ReservaController 
{
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
    public function index() 
    {
        $reserva = new Reserva();
        $reservas = $reserva->getAll();
        Core\View::render('reserva/index', ['reservas' => $reservas]);
    }

    public function create() 
    {
        Core\View::render('reserva/create');
    }

    public function store() 
    {
        $id_reserva = filter_input(INPUT_POST, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT);
        $recordatorio = filter_input(INPUT_POST, 'recordatorio', FILTER_SANITIZE_STRING);
        $resena = filter_input(INPUT_POST, 'resena', FILTER_SANITIZE_STRING);
        $fecha_reserva = filter_input(INPUT_POST, 'fecha_reserva', FILTER_SANITIZE_STRING);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) 
        {
            $reserva = new Reserva();
            $reserva->create($id_reserva, $id_cliente, $id_proveedor, $id_servicio, $recordatorio, $resena, $fecha_reserva);
        }
        header('Location: index.php?controller=reserva&action=index');
    }

    public function edit() 
    {
        $id_reserva = filter_input(INPUT_GET, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_GET, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_GET, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_GET, 'id_servicio', FILTER_VALIDATE_INT);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) 
        {
            $reserva = new Reserva();
            $data = $reserva->getById($id_reserva, $id_cliente, $id_proveedor, $id_servicio);
            Core\View::render('reserva/edit', ['reserva' => $data]);
        }
    }

    public function update() 
    {
        $id_reserva = filter_input(INPUT_POST, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT);
        $recordatorio = filter_input(INPUT_POST, 'recordatorio', FILTER_SANITIZE_STRING);
        $resena = filter_input(INPUT_POST, 'resena', FILTER_SANITIZE_STRING);
        $fecha_reserva = filter_input(INPUT_POST, 'fecha_reserva', FILTER_SANITIZE_STRING);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) 
        {
            $reserva = new Reserva();
            $reserva->update($id_reserva, $id_cliente, $id_proveedor, $id_servicio, $recordatorio, $resena, $fecha_reserva);
        }
        header('Location: index.php?controller=reserva&action=index');
    }

    public function delete() 
    {
        $id_reserva = filter_input(INPUT_GET, 'id_reserva', FILTER_VALIDATE_INT);
        $id_cliente = filter_input(INPUT_GET, 'id_cliente', FILTER_VALIDATE_INT);
        $id_proveedor = filter_input(INPUT_GET, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_GET, 'id_servicio', FILTER_VALIDATE_INT);

        if ($id_reserva && $id_cliente && $id_proveedor && $id_servicio) 
        {
            $reserva = new Reserva();
            $reserva->delete($id_reserva, $id_cliente, $id_proveedor, $id_servicio);
        }
        header('Location: index.php?controller=reserva&action=index');
    }
}

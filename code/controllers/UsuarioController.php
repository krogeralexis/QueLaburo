<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../core/View.php';

class UsuarioController extends \Core\Controller {

    public function __construct() {
        $action = $_GET['action'] ?? '';
        // Seguridad comentada, si quieres activarla ajusta $accionesPermitidas
        // if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
        //     $this->redirect('index.php?controller=usuario&action=index');
        // }
    }

    /**
     * Vista principal de usuario
     */
    public function index() {
        
        $servicioModel = new Servicio();
        $servicios = $servicioModel->getAll();

        
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll(); 

        // Renderizamos la vista usuario/index.php pasando $servicios
        $this->render('usuario/index', [
            'servicios' => $servicios,
            'usuarios' => $usuarios 
        ]);
    }

    /**
     * Vista principal para admin
     */
    public function indexA() {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll();
        $this->render('adminPanel/usuario/indexA', ['usuarios' => $usuarios]);
    }

    /**
     * Crear usuario
     */
    public function create() 
    {
        $this->render('adminPanel/usuario/create');
    }

    /**
     * Editar usuario
     */
    public function edit() 
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) 
        {
            $usuarioModel = new Usuario();
            $data = $usuarioModel->getById($id);
            $this->render('adminPanel/usuario/edit', ['usuario' => $data]);
        }
    }

    /**
     * Ver perfil de usuario
     */
    public function verPerfil() 
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) 
        {
            $id = 1; // Valor predeterminado
        }

        $usuarioModel = new Usuario();
        $data = $usuarioModel->getById($id);

        if ($data) 
        {
            // Determinar si es cliente o proveedor
            $es_cliente = $usuarioModel->esCliente($id);
            $es_proveedor = $usuarioModel->esProveedor($id);

            // Obtener calificaciones y cantidad
            $calif_cliente = $es_cliente ? $usuarioModel->getCalificacionCliente($id) : null;
            $cant_calif_cliente = $es_cliente ? $usuarioModel->getPerfilCompleto($id)['cant_calif_cliente'] : 0;

            $calif_proveedor = $es_proveedor ? $usuarioModel->getCalificacionProveedor($id) : null;
            $cant_calif_proveedor = $es_proveedor ? $usuarioModel->getPerfilCompleto($id)['cant_calif_proveedor'] : 0;

            // Renderizar la vista pasando toda la información
            $this->render('usuario/perfil', 
            [
                'usuario' => $data,
                'es_cliente' => $es_cliente,
                'es_proveedor' => $es_proveedor,
                'calif_cliente' => $calif_cliente,
                'cant_calif_cliente' => $cant_calif_cliente,
                'calif_proveedor' => $calif_proveedor,
                'cant_calif_proveedor' => $cant_calif_proveedor
            ]);
            return;
        }

        $this->redirect('index.php?controller=usuario&action=index');
    }


}

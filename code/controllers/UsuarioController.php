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
        // Cargamos los servicios para el carrusel
        $servicioModel = new Servicio();
        $servicios = $servicioModel->getAll();

        // Opcional: si quieres usuarios también
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll(); 

        // Renderizamos la vista usuario/index.php pasando $servicios
        $this->render('usuario/index', [
            'servicios' => $servicios,
            'usuarios' => $usuarios // si quieres usar usuarios en la vista
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
    public function create() {
        $this->render('adminPanel/usuario/create');
    }

    /**
     * Editar usuario
     */
    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $usuarioModel = new Usuario();
            $data = $usuarioModel->getById($id);
            $this->render('adminPanel/usuario/edit', ['usuario' => $data]);
        }
    }

    /**
     * Ver perfil de usuario
     */
    public function verPerfil() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            $id = 1; // Valor predeterminado
        }

        $usuarioModel = new Usuario();
        $data = $usuarioModel->getById($id);

        if ($data) {
            $this->render('usuario/perfil', ['usuario' => $data]);
            return;
        }

        $this->redirect('index.php?controller=usuario&action=index');
    }
}

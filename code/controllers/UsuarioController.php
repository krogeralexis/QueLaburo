<?php
require_once 'core/Controller.php';
require_once 'models/Usuario.php';
require_once 'core/View.php';

class UsuarioController extends \Core\Controller {
    public function __construct() {
        $action = $_GET['action'] ?? '';
        if (!isset($_SESSION['usuario']) && !in_array($action)) {
            $this->redirect('index.php?controller=usuario&action=index');
        }
    }
    
    public function indexA() {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll();
        $this->render('usuario/indexA', ['usuarios' => $usuarios]);
    }

    

    public function index() {
        $usuarioModel = new Usuario();
        $usuarios = $usuarioModel->getAll();
        $this->render('usuario/index', ['usuarios' => $usuarios]);
    }

    public function create() { $this->render('usuario/create'); }
    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $usuario = new Usuario();
            $data = $usuario->getById($id);
            $this->render('usuario/edit', ['usuario' => $data]);
        }
    }
    public function verPerfil() 
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (!$id) 
            {
                $id = 1; // Valor predeterminado
            }

        $usuario = new Usuario();
        $data = $usuario->getById($id);
            if ($data) 
            {
                $this->render('usuario/perfil', ['usuario' => $data]);
                return;
            }
        
        $this->redirect('index.php?controller=usuario&action=index');
    }
}
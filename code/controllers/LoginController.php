<?php
require_once 'models/Usuario.php';

class LoginController 
{
    private $usuarioModel;

    public function __construct() 
    {
        $this->usuarioModel = new Usuario();
    }

   public function index($error = '') {
    require 'views/login/index.php';
}
    

    public function authenticate() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = $this->usuarioModel->login($correo, $password);

            if ($user) 
            {
                session_start();

                $_SESSION['usuario'] = [
                    'id' => $user['id_usuario'],
                    'nombre' => $user['nombre'],
                    'correo' => $user['correo']
                ];

                header('Location: index.php?controller=usuario&action=index');
                exit;
            } else 
            {
                $error = "Correo o contraseña incorrectos";
                require 'views/login/index.php';
            }
        }
    }
    public function register() {
    require 'views/login/register.php';
}

    public function logout() 
    {
        session_start();
        session_destroy();
        header('Location: index.php?controller=login&action=index');
        exit;
    }
}

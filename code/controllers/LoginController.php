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
    require 'views/login/login.php';
}
    

    public function authenticate() 
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $correo = $_POST['correo'] ?? '';
        $password = $_POST['password'] ?? '';

        // Patrón de SQLi común (puedes agregar más si querés)
        $sqli_patterns = [
            '/(\bor\b|\band\b)\s+\d+=\d+/i', 
            '/(\'|")\s*--/', 
            '/union\s+select/i', 
            '/drop\s+table/i', 
            '/insert\s+into/i', 
            '/delete\s+from/i', 
            '/--|;|#/'
        ];

        $sqli_detected = false;

        foreach ($sqli_patterns as $pattern) {
            if (preg_match($pattern, $correo) || preg_match($pattern, $password)) {
                $sqli_detected = true;
                break;
            }
        }

        if ($sqli_detected) {
            $error = "Intento de inyección SQL detectado.";
            require 'views/login/index.php';
            return;
        }

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
        } 
        else 
        {
            $error = "Correo o contraseña incorrectos";
            require 'views/login/index.php';
        }
    }
}

    public function register() 
{
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
        $nombre   = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $correo   = trim($_POST['correo'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm_password'] ?? '');
        $terms    = isset($_POST['terms']);

        $errors = [];

        // Validaciones básicas
        if (!$nombre || !$apellido || !$correo || !$password || !$confirm) 
        {
            $errors[] = "Todos los campos son obligatorios.";
        }

        if ($password !== $confirm) 
        {
            $errors[] = "Las contraseñas no coinciden.";
        }

        if (!$terms) 
        {
            $errors[] = "Debe aceptar los términos y condiciones.";
        }

        // Validar que no exista el correo
        if ($this->usuarioModel->exists($correo)) 
        {
            $errors[] = "El correo ya está registrado.";
        }
        if (!$telefono) 
        {
            $errors[] = "Debe ingresar su teléfono.";
        }

        if (empty($errors)) 
        {
            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Crear usuario
            $this->usuarioModel->create
            (
                $nombre . ' ' . $apellido,
                 $correo,
                $telefono,
                $hashedPassword
            );

            // Redirigir a login
            header('Location: index.php?controller=usuario&action=index&success=1');
            exit;
        } else {
            // Mostrar errores
            require 'views/login/register.php';
        }
    }   else 
        {
            // Si no es POST, solo mostrar formulario
            require 'views/login/register.php';
        }   
}


    public function logout() 
    {
        session_start();
        session_destroy();
        header('Location: index.php?controller=login&action=index');
        exit;
    }
}

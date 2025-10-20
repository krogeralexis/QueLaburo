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

            // ... (Lógica de validación SQLi - SIN CAMBIOS) ...
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
                $es_cliente = $this->usuarioModel->esCliente($usuario_id);
                $es_proveedor = $this->usuarioModel->esProveedor($usuario_id);
                // El array $user ahora incluye 'es_cliente' y 'es_proveedor' gracias al modelo.
                $_SESSION['usuario'] = [
                    'id'           => $user['id'], // Usamos 'id' de la tabla Usuario
                    'nombre'       => $user['nombre'],
                    'correo'       => $user['correo'],
                    // NUEVO: Guardamos los roles en la sesión
                    'es_cliente'   => $user['es_cliente'],
                    'es_proveedor' => $user['es_proveedor']
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
    public function registerview() 
    {
        require 'views/login/register.php';
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
        session_destroy();
        header('Location: index.php?controller=usuario&action=index');
        exit;
    }
}

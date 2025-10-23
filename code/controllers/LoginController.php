<?php
require_once __DIR__ . '/../models/Usuario.php';

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

    // =========================================================
    // LOGIN CON GOOGLE
    // =========================================================
    public function googleLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = $_POST['correo'] ?? '';
            $nombre = $_POST['nombre'] ?? '';
            $google_uid = $_POST['google_uid'] ?? '';

            if (!$correo || !$nombre || !$google_uid) {
                echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
                return;
            }

            $user = $this->usuarioModel->getByEmail($correo);

            if (!$user) {
                // Usuario nuevo, creamos con contraseña random y UID de Google
                $passwordRandom = password_hash(bin2hex(random_bytes(5)), PASSWORD_DEFAULT);
                $this->usuarioModel->create($nombre, $correo, '000000000', $passwordRandom, $google_uid);
                $user = $this->usuarioModel->getByEmail($correo);
            } else {
                // Usuario existente: aseguramos que su google_uid esté registrado
                if (empty($user['google_uid'])) {
                    $this->usuarioModel->setGoogleUid($user['id'], $google_uid);
                }
            }

            $_SESSION['usuario'] = [
                'id' => $user['id'],
                'nombre' => $user['nombre'],
                'correo' => $user['correo'],
                'es_cliente' => $this->usuarioModel->esCliente($user['id']),
                'es_proveedor' => $this->usuarioModel->esProveedor($user['id'])
            ];

            echo json_encode(['success' => true]);
        }
    }

    // =========================================================
    // LOGIN NORMAL
    // =========================================================
    public function authenticate() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $correo = $_POST['correo'] ?? '';
            $password = $_POST['password'] ?? '';

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
                require 'views/login/login.php';
                return;
            }

            $user = $this->usuarioModel->login($correo, $password);

            if ($user) 
            {   
                $_SESSION['usuario'] = [
                    'id'           => $user['id'],
                    'nombre'       => $user['nombre'],
                    'correo'       => $user['correo'],
                    'es_cliente'   => $user['es_cliente'],
                    'es_proveedor' => $user['es_proveedor']
                ];

                header('Location: index.php?controller=usuario&action=index');
                exit;
            } 
            else 
            {
                $error = "Correo o contraseña incorrectos";
                require 'views/login/login.php';
            }
        }
    }

    // =========================================================
    // REGISTRO
    // =========================================================
    public function registerview() 
    {
        header('Location: index.php?controller=usuario&action=index&mode=register');
        exit;
    }

    /**
     * Registro de usuario
     *
     * Verifica que se haya realizado un pedido POST y que se hayan proporcionado
     * todos los campos necesarios. Luego, verifica que las contraseñas sean iguales, que
     * se haya aceptado los términos y condiciones, y que el correo no esté registrado.
     * Si no hay errores, crea un nuevo usuario con la contraseña hasheada y redirige
     * a la página de inicio con un parámetro de éxito.
     * Si hay errores, muestra la vista de login con los mensajes de error correspondientes.
     */
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

            if (!$nombre || !$apellido || !$correo || !$password || !$confirm) 
                $errors[] = "Todos los campos son obligatorios.";
            if ($password !== $confirm) 
                $errors[] = "Las contraseñas no coinciden.";
            if (!$terms) 
                $errors[] = "Debe aceptar los términos y condiciones.";
            if ($this->usuarioModel->exists($correo)) 
                $errors[] = "El correo ya está registrado.";
            if (!$telefono) 
                $errors[] = "Debe ingresar su teléfono.";

            if (empty($errors)) 
            {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $this->usuarioModel->create($nombre . ' ' . $apellido, $correo, $telefono, $hashedPassword);
                header('Location: index.php?controller=usuario&action=index&success=1');
                exit;
            } else {
                require 'views/login/login.php';
            }
        } else {
            require 'views/login/login.php';
        }   
    }

    // =========================================================
    // LOGOUT
    // =========================================================
    public function logout() 
    {
        session_destroy();
        header('Location: index.php?controller=usuario&action=index');
        exit;
    }
}

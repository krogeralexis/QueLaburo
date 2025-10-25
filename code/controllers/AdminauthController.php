<?php
// controllers/AdminAuthController.php
require_once __DIR__ . '/../models/AdminAuth.php';
require_once __DIR__ . '/../core/View.php';

class AdminAuthController {

    // Muestra el login
    public function login() {

        // Si ya hay sesión, redirige al panel
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=adminauth&action=panel');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $auth = new AdminAuth();
            $adminId = $auth->verificarCredenciales($correo, $password);

            if ($adminId) {
                $_SESSION['admin_id'] = $adminId;
                header('Location: index.php?controller=adminauth&action=panel');
                exit;
            } else {
                Core\View::render('adminPanel/login/login', ['error' => 'Correo o contraseña inválidos.']);
                return;
            }
        }

        Core\View::render('adminPanel/login/login');
    }

    // Panel de administración
    public function panel() {

        // Aquí se podría agregar verificación de sesión manual si quieres. 
        if (!isset($_SESSION['admin_id'])) { header('Location: index.php?controller=adminauth&action=login'); exit; }

        Core\View::render('adminPanel/administrador/index', [
            'admin_id' => $_SESSION['admin_id'] ?? null
        ]);
    }

    // Logout
    public function logout() {
        session_destroy();
        header('Location: index.php?controller=adminauth&action=login');
        exit;
    }
}

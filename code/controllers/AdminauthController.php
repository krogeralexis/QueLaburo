<?php
// controllers/AdminAuthController.php
require_once __DIR__ . '/../models/AdminAuth.php';
require_once __DIR__ . '/../core/View.php';
require_once __DIR__ . '/../core/AdminMiddleware.php';


class AdminAuthController {

    // Muestra el login
    public function login() {
        session_start();

        // Si ya hay sesión, redirige al panel
        if (isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=adminAuth&action=panel');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $auth = new AdminAuth();
            $adminId = $auth->verificarCredenciales($correo, $password);

            if ($adminId) {
                $_SESSION['admin_id'] = $adminId;
                header('Location: index.php?controller=adminAuth&action=panel');
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
        \Core\AdminMiddleware::handle(); // protege toda la acción

        Core\View::render('adminPanel/administrador/index', [
            'admin_id' => $_SESSION['admin_id']
        ]);
    }

    // Logout
    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=adminAuth&action=login');
        exit;
    }
}

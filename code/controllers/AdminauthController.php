<?php
require_once __DIR__ . '/../models/AdminAuth.php';
require_once __DIR__ . '/../core/View.php';

class AdminAuthController {

    public function login() {
        if (isset($_SESSION['admin_id'])) {
            header('Location: /admin/panel');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $correo = filter_input(INPUT_POST, 'correo', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $auth = new AdminAuth();
            $adminId = $auth->verificarCredenciales($correo, $password);

            if ($adminId) {
                $_SESSION['admin_id'] = $adminId;
                header('Location: /admin/panel');
                exit;
            } else {
                Core\View::render('admin/login', ['error' => 'Correo o contraseña inválidos.']);
                return;
            }
        }

        Core\View::render('admin/login');
    }

    public function panel() {
        \Core\AdminMiddleware::handle(); // protege toda la acción
        Core\View::render('admin/panel', ['admin_id' => $_SESSION['admin_id']]);
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /admin');
    }
}

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
                Core\View::render('admin/login', ['error' => 'Correo o contraseña inválidos.']);
                return;
            }
        }

        Core\View::render('admin/login');
    }

    // Panel de administración
    public function panel() {

        // Verifica si hay sesión
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?controller=adminauth&action=login');
            exit;
        }

        // Verifica que el ID realmente sea de un admin
        $auth = new AdminAuth();
        if (!$auth->esAdmin($_SESSION['admin_id'])) {
            session_unset();
            session_destroy();
            header('Location: index.php?controller=adminauth&action=login');
            exit;
        }

        // Renderiza el panel
        Core\View::render('admin/administrador/index', [
            'admin_id' => $_SESSION['admin_id']
        ]);
    }

    // Logout
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?controller=adminauth&action=login');
        exit;
    }
}

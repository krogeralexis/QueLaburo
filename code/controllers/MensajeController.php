    <?php
    require_once __DIR__ . '/../models/Mensaje.php';
    require_once __DIR__ . '/../core/View.php';

class MensajeController {

        public function __construct() {
        $action = $_GET['action'] ?? '';
        $accionesPermitidas = []; // para tests

        if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

       public function index() {
        $msg = new Mensaje();
        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        $mensajes = $msg->getByUsuario($id_usuario);
        Core\View::render('adminPanel/mensaje/index', ['mensajes' => $mensajes]);
    }

        public function create() {
            Core\View::render('adminPanel/mensaje/create');
        }

        public function store() {
        $id_usuario  = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
        $id_emisor   = filter_input(INPUT_POST, 'id_emisor', FILTER_VALIDATE_INT);
        $id_receptor = filter_input(INPUT_POST, 'id_receptor', FILTER_VALIDATE_INT);
        $contenido   = htmlspecialchars($_POST['contenido'] ?? '', ENT_QUOTES, 'UTF-8');
        $estado      = $_POST['estado'] ?? 'recibido_noleido';
        $fecha       = date('Y-m-d H:i:s');

        if ($id_usuario && $id_emisor && $id_receptor && $contenido) {
            $msg = new Mensaje();
            $msg->create($id_usuario, $id_emisor, $id_receptor, null, $estado, $contenido, $fecha);
        }

        header('Location: index.php?controller=mensaje&action=index');
    }

        public function edit() {
            $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
            $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);

            if ($id_usuario && $id_mensaje) {
                $msg = new Mensaje();
                $data = $msg->getById($id_usuario, $id_mensaje);
                Core\View::render('adminPanel/mensaje/edit', ['mensaje' => $data]);
            }
        }

        public function update() {
            $id_usuario = filter_input(INPUT_POST, 'id_usuario', FILTER_VALIDATE_INT);
            $id_mensaje = filter_input(INPUT_POST, 'id_mensaje', FILTER_VALIDATE_INT);
            $estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
            $notificacion = filter_input(INPUT_POST, 'notificacion', FILTER_SANITIZE_STRING);

            if ($id_usuario && $id_mensaje) {
                $msg = new Mensaje();
                $msg->update($id_usuario, $id_mensaje, $estado, $notificacion);
            }
            header('Location: index.php?controller=mensaje&action=index');
        }

        public function delete() {
            $id_usuario = filter_input(INPUT_GET, 'id_usuario', FILTER_VALIDATE_INT);
            $id_mensaje = filter_input(INPUT_GET, 'id_mensaje', FILTER_VALIDATE_INT);

            if ($id_usuario && $id_mensaje) {
                $msg = new Mensaje();
                $msg->delete($id_usuario, $id_mensaje);
            }
            header('Location: index.php?controller=mensaje&action=index');
        }
}

<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../models/Proveedor.php';
require_once __DIR__ . '/../core/View.php';

class ServicioController extends \Core\Controller {

    private $servicioModel;
    private $proveedorModel;

    public function __construct() {
        $this->servicioModel = new Servicio();
        $this->proveedorModel = new Proveedor();

        $action = $_GET['action'] ?? '';
        $accionesPermitidas = ['verServicio'];

        if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    public function verServicio() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php?controller=home&action=index');
            exit;
        }

        $servicio = $this->servicioModel->obtenerServicioPorId($id);
        if (!$servicio) {
            header('Location: index.php?controller=home&action=index');
            exit;
        }

        $this->render('servicio/verServicio', ['servicio' => $servicio]);
    }

    public function indexA() {
        $servicios = $this->servicioModel->getAll();
        $this->render('adminPanel/servicio/index', ['servicios' => $servicios]);
    }

    public function create() {
        $this->render('adminPanel/servicio/create');
    }

    public function store() {
        $id_usuario = $_SESSION['usuario']['id'] ?? null;
        if (!$id_usuario) {
            die("Error: No se detectó un usuario logueado.");
        }

        // Verificamos si el usuario ya es proveedor
        $proveedor = $this->proveedorModel->getById($id_usuario);
        if (!$proveedor) {
            $nuevoProveedorId = $this->proveedorModel->create(
                $id_usuario,  // id_proveedor
                '',           // referencias
                0,            // cantidad_ventas
                0,            // calif_promedio
                0             // cant_calif
            );
            $_SESSION['usuario']['es_proveedor'] = true;
        } else {
            $nuevoProveedorId = $proveedor['id_proveedor'];
        }

        // Capturamos los datos del formulario
        $disponibilidad = htmlspecialchars(trim($_POST['disponibilidad'] ?? 'Disponible'));
        $categoria      = htmlspecialchars(trim($_POST['categoria'] ?? ''));
        $descripcion    = htmlspecialchars(trim($_POST['descripcion'] ?? ''));
        $precio         = floatval($_POST['precio'] ?? 0);
        $titulo         = htmlspecialchars(trim($_POST['titulo'] ?? ''));

        // Imagen como BLOB
        $imagen = $_FILES['imagen']['tmp_name'] ?? null;
        $imagenBlob = $imagen ? file_get_contents($imagen) : null;

        if (!empty($titulo) && $precio > 0) {
            $this->servicioModel->create(
                $nuevoProveedorId,
                $disponibilidad,
                $categoria,
                $descripcion,
                $precio,
                $titulo,
                $imagenBlob
            );
        }

        header('Location: index.php?controller=servicio&action=indexA');
        exit;
    }

    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: index.php?controller=servicio&action=indexA');
            exit;
        }

        $servicio = $this->servicioModel->getById($id);
        if (!$servicio) {
            header('Location: index.php?controller=servicio&action=indexA');
            exit;
        }

        $this->render('adminPanel/servicio/edit', ['servicio' => $servicio]);
    }

    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $disponibilidad = filter_input(INPUT_POST, 'disponibilidad', FILTER_SANITIZE_STRING);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);

        // Imagen como BLOB (si se subió)
        $imagen = $_FILES['imagen']['tmp_name'] ?? null;
        $imagenBlob = $imagen ? file_get_contents($imagen) : null;

        if ($id && $titulo && $precio !== false) {
            $this->servicioModel->update(
                $id,
                $disponibilidad,
                $categoria,
                $descripcion,
                $precio,
                $titulo,
                $imagenBlob
            );
        }

        header('Location: index.php?controller=servicio&action=indexA');
        exit;
    }

    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->servicioModel->delete($id);
        }
        header('Location: index.php?controller=servicio&action=indexA');
        exit;
    }
}
?>

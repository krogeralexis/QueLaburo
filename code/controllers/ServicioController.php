<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../models/Servicio.php';
require_once __DIR__ . '/../core/View.php';

class ServicioController extends \Core\Controller {

    private $servicioModel;

    public function __construct() {
        // Instanciar el modelo
        $this->servicioModel = new Servicio();

        $action = $_GET['action'] ?? '';
        $accionesPermitidas = ['verServicio'];

        // Si no está logueado y no es acción pública, redirige
        if (!isset($_SESSION['usuario']) && !in_array($action, $accionesPermitidas)) {
            header('Location: index.php?controller=login&action=index');
            exit;
        }
    }

    /**
     * Muestra un servicio específico
     */
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

    /**
     * Vista principal del panel admin (listar servicios)
     */
    public function indexA() {
        $servicios = $this->servicioModel->getAll();
        $this->render('adminPanel/servicio/index', ['servicios' => $servicios]);
    }

    /**
     * Formulario de creación de servicio
     */
    public function create() {
        $this->render('adminPanel/servicio/create');
    }

    /**
     * Guardar nuevo servicio
     */
    public function store() {
        $disponibilidad = filter_input(INPUT_POST, 'disponibilidad', FILTER_SANITIZE_STRING);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING);

        if ($titulo && $precio !== false) {
            $this->servicioModel->create($disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen);
        }

        header('Location: index.php?controller=servicio&action=indexA');
        exit;
    }

    /**
     * Formulario de edición
     */
    public function edit() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $data = $this->servicioModel->getById($id);
            $this->render('adminPanel/servicio/edit', ['servicio' => $data]);
        } else {
            header('Location: index.php?controller=servicio&action=indexA');
            exit;
        }
    }

    /**
     * Actualiza un servicio
     */
    public function update() {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $disponibilidad = filter_input(INPUT_POST, 'disponibilidad', FILTER_SANITIZE_STRING);
        $categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
        $descripcion = filter_input(INPUT_POST, 'descripcion', FILTER_SANITIZE_STRING);
        $precio = filter_input(INPUT_POST, 'precio', FILTER_VALIDATE_FLOAT);
        $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
        $imagen = filter_input(INPUT_POST, 'imagen', FILTER_SANITIZE_STRING);

        if ($id && $titulo && $precio !== false) {
            $this->servicioModel->update($id, $disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen);
        }

        header('Location: index.php?controller=servicio&action=indexA');
        exit;
    }

    /**
     * Elimina un servicio
     */
    public function delete() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $this->servicioModel->delete($id);
        }

        header('Location: index.php?controller=servicio&action=indexA');
        exit;
    }
}

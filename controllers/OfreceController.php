<?php
require_once 'models/Ofrece.php';
require_once 'core/View.php';

class OfreceController {
    public function index() {
        $ofrece = new Ofrece();
        $datos = $ofrece->getAll();
        Core\View::render('ofrece/index', ['datos' => $datos]);
    }

    public function create() {
        Core\View::render('ofrece/create');
    }

    public function store() {
        $id_proveedor = filter_input(INPUT_POST, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_POST, 'id_servicio', FILTER_VALIDATE_INT);

        if ($id_proveedor && $id_servicio) {
            $ofrece = new Ofrece();
            $ofrece->create($id_proveedor, $id_servicio);
        }
        header('Location: index.php?controller=ofrece&action=index');
    }

    public function delete() {
        $id_proveedor = filter_input(INPUT_GET, 'id_proveedor', FILTER_VALIDATE_INT);
        $id_servicio = filter_input(INPUT_GET, 'id_servicio', FILTER_VALIDATE_INT);

        if ($id_proveedor && $id_servicio) {
            $ofrece = new Ofrece();
            $ofrece->delete($id_proveedor, $id_servicio);
        }
        header('Location: index.php?controller=ofrece&action=index');
    }
}

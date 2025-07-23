<?php
require_once 'core/Model.php';

class Ofrece extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Ofrece");
        return $stmt->fetchAll();
    }

    public function getById($id_proveedor, $id_servicio) {
        $stmt = $this->db->prepare("SELECT * FROM Ofrece WHERE id_proveedor = :id_proveedor AND id_servicio = :id_servicio");
        $stmt->execute([
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio
        ]);
        return $stmt->fetch();
    }

    public function create($id_proveedor, $id_servicio) {
        $stmt = $this->db->prepare("INSERT INTO Ofrece (id_proveedor, id_servicio) VALUES (:id_proveedor, :id_servicio)");
        $stmt->execute([
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio
        ]);
    }

    public function delete($id_proveedor, $id_servicio) {
        $stmt = $this->db->prepare("DELETE FROM Ofrece WHERE id_proveedor = :id_proveedor AND id_servicio = :id_servicio");
        $stmt->execute([
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio
        ]);
    }
}

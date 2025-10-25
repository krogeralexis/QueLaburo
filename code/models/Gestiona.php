<?php
require_once 'core/Model.php';

class Gestiona extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Gestiona");
        return $stmt->fetchAll();
    }

    public function getById($id_usuario, $id_administrador) {
        $stmt = $this->db->prepare("SELECT * FROM Gestiona WHERE id_usuario = :id_usuario AND id_administrador = :id_administrador");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_administrador' => $id_administrador
        ]);
        return $stmt->fetch();
    }

    public function create($id_usuario, $id_administrador, $fecha_gestion, $descripcion) {
        $stmt = $this->db->prepare("INSERT INTO Gestiona (id_usuario, id_administrador, fecha_gestion, descripcion) VALUES (:id_usuario, :id_administrador, :fecha_gestion, :descripcion)");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_administrador' => $id_administrador,
            'fecha_gestion' => $fecha_gestion,
            'descripcion' => $descripcion
        ]);
    }

    public function update($id_usuario, $id_administrador, $fecha_gestion, $descripcion) {
        $stmt = $this->db->prepare("UPDATE Gestiona SET fecha_gestion = :fecha_gestion, descripcion = :descripcion WHERE id_usuario = :id_usuario AND id_administrador = :id_administrador");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_administrador' => $id_administrador,
            'fecha_gestion' => $fecha_gestion,
            'descripcion' => $descripcion
        ]);
    }

    public function delete($id_usuario, $id_administrador) {
        $stmt = $this->db->prepare("DELETE FROM Gestiona WHERE id_usuario = :id_usuario AND id_administrador = :id_administrador");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_administrador' => $id_administrador
        ]);
    }
}

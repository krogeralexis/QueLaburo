<?php
require_once 'core/Model.php';

class Mensaje extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Mensaje");
        return $stmt->fetchAll();
    }

    public function getById($id_usuario, $id_mensaje) {
        $stmt = $this->db->prepare("SELECT * FROM Mensaje WHERE id_usuario = :id_usuario AND id_mensaje = :id_mensaje");
        $stmt->execute(['id_usuario' => $id_usuario, 'id_mensaje' => $id_mensaje]);
        return $stmt->fetch();
    }

    public function create($id_usuario, $id_emisor, $id_receptor, $id_mensaje, $estado, $notificacion, $fecha) {
        $stmt = $this->db->prepare("INSERT INTO Mensaje (id_usuario, id_emisor, id_receptor, id_mensaje, estado, notificacion, fecha) VALUES (:id_usuario, :id_emisor, :id_receptor, :id_mensaje, :estado, :notificacion, :fecha)");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_emisor' => $id_emisor,
            'id_receptor' => $id_receptor,
            'id_mensaje' => $id_mensaje,
            'estado' => $estado,
            'notificacion' => $notificacion,
            'fecha' => $fecha
        ]);
    }

    public function update($id_usuario, $id_mensaje, $estado, $notificacion) {
        $stmt = $this->db->prepare("UPDATE Mensaje SET estado = :estado, notificacion = :notificacion WHERE id_usuario = :id_usuario AND id_mensaje = :id_mensaje");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_mensaje' => $id_mensaje,
            'estado' => $estado,
            'notificacion' => $notificacion
        ]);
    }

    public function delete($id_usuario, $id_mensaje) {
        $stmt = $this->db->prepare("DELETE FROM Mensaje WHERE id_usuario = :id_usuario AND id_mensaje = :id_mensaje");
        $stmt->execute(['id_usuario' => $id_usuario, 'id_mensaje' => $id_mensaje]);
    }
}

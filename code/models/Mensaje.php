<?php
// models/Mensaje.php
require_once 'core/Model.php';

class Mensaje extends Core\Model {

    // Crea mensaje automático desde reservas
    public function createAutomatic($id_emisor, $id_receptor, $contenido) {
        $stmt = $this->db->prepare("
            INSERT INTO Mensaje (id_usuario, id_emisor, id_receptor, contenido, estado, fecha)
            VALUES (:id_usuario, :id_emisor, :id_receptor, :contenido, 'recibido_noleido', :fecha)
        ");
        $stmt->execute([
            'id_usuario' => $id_receptor,
            'id_emisor' => $id_emisor,
            'id_receptor' => $id_receptor,
            'contenido' => $contenido,
            'fecha' => date('Y-m-d H:i:s')
        ]);
        return $this->db->lastInsertId();
    }

    // Crea mensaje manual (por formulario o panel)
    public function create($id_usuario, $id_emisor, $id_receptor, $id_mensaje, $estado, $notificacion, $fecha) {
        $stmt = $this->db->prepare("
            INSERT INTO Mensaje (id_usuario, id_emisor, id_receptor, contenido, estado, fecha)
            VALUES (:id_usuario, :id_emisor, :id_receptor, :contenido, :estado, :fecha)
        ");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_emisor' => $id_emisor,
            'id_receptor' => $id_receptor,
            'contenido' => $notificacion ?? '',
            'estado' => $estado ?? 'recibido_noleido',
            'fecha' => $fecha ?? date('Y-m-d H:i:s')
        ]);
        return $this->db->lastInsertId();
    }

    // Buzón de mensajes del usuario (recibidos y enviados)
    public function getByUsuario($id_usuario) {
        $stmt = $this->db->prepare("
            SELECT m.*, u.nombre AS emisor_nombre
            FROM Mensaje m
            LEFT JOIN Usuario u ON m.id_emisor = u.id_usuario
            WHERE m.id_usuario = :id_usuario
            ORDER BY m.fecha DESC
        ");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function marcarLeido($id_mensaje) {
        $stmt = $this->db->prepare("UPDATE Mensaje SET estado = 'recibido_leido' WHERE id_mensaje = :id");
        $stmt->execute(['id' => $id_mensaje]);
    }
}

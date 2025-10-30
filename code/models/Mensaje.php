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
    public function create($id_usuario, $id_emisor, $id_receptor, $contenido, $estado = 'recibido_noleido', $fecha = null) {
        $fecha = $fecha ?? date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("
            INSERT INTO Mensaje (id_usuario, id_emisor, id_receptor, contenido, estado, fecha)
            VALUES (:id_usuario, :id_emisor, :id_receptor, :contenido, :estado, :fecha)
        ");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_emisor' => $id_emisor,
            'id_receptor' => $id_receptor,
            'contenido' => $contenido,
            'estado' => $estado,
            'fecha' => $fecha
        ]);
        return $this->db->lastInsertId();
    }

    // Obtener mensaje por ID (para edición)
    public function getById($id_usuario, $id_mensaje) {
        $stmt = $this->db->prepare("
            SELECT m.*, u.nombre AS emisor_nombre
            FROM Mensaje m
            LEFT JOIN Usuario u ON m.id_emisor = u.id_usuario
            WHERE m.id_usuario = :id_usuario AND m.id_mensaje = :id_mensaje
        ");
        $stmt->execute(['id_usuario' => $id_usuario, 'id_mensaje' => $id_mensaje]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buzón de mensajes del usuario (recibidos y enviados)
    public function getByUsuario($id_usuario) {
        $stmt = $this->db->prepare("
            SELECT m.*, u.nombre AS emisor_nombre, r.nombre AS receptor_nombre
            FROM Mensaje m
            LEFT JOIN Usuario u ON m.id_emisor = u.id_usuario
            LEFT JOIN Usuario r ON m.id_receptor = r.id_usuario
            WHERE m.id_usuario = :id_usuario
            ORDER BY m.fecha DESC
        ");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar mensaje
    public function update($id_usuario, $id_mensaje, $estado, $contenido) {
        $stmt = $this->db->prepare("
            UPDATE Mensaje 
            SET estado = :estado, contenido = :contenido 
            WHERE id_usuario = :id_usuario AND id_mensaje = :id_mensaje
        ");
        $stmt->execute([
            'estado' => $estado,
            'contenido' => $contenido,
            'id_usuario' => $id_usuario,
            'id_mensaje' => $id_mensaje
        ]);
    }

    // Eliminar mensaje
    public function delete($id_usuario, $id_mensaje) {
        $stmt = $this->db->prepare("
            DELETE FROM Mensaje 
            WHERE id_usuario = :id_usuario AND id_mensaje = :id_mensaje
        ");
        $stmt->execute(['id_usuario' => $id_usuario, 'id_mensaje' => $id_mensaje]);
    }

        // Obtener todos los mensajes entre dos usuarios
    public function getConversacion($id_usuario, $id_otro) {
        $stmt = $this->db->prepare("
            SELECT m.*, u.nombre AS emisor_nombre
            FROM Mensaje m
            LEFT JOIN Usuario u ON m.id_emisor = u.id
            WHERE (m.id_emisor = :id_usuario AND m.id_receptor = :id_otro)
            OR (m.id_emisor = :id_otro AND m.id_receptor = :id_usuario)
            ORDER BY m.fecha ASC
        ");
        $stmt->execute([
            'id_usuario' => $id_usuario,
            'id_otro' => $id_otro
        ]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener los últimos mensajes de cada conversación del usuario
    public function getUltimosMensajes($id_usuario) {
        $stmt = $this->db->prepare("
            SELECT 
                IF(m.id_emisor = :id_usuario, m.id_receptor, m.id_emisor) AS id_otro,
                MAX(m.fecha) AS ultima_fecha
            FROM Mensaje m
            WHERE m.id_emisor = :id_usuario OR m.id_receptor = :id_usuario
            GROUP BY id_otro
            ORDER BY ultima_fecha DESC
        ");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Marcar como leído
    public function marcarLeido($id_mensaje) {
        $stmt = $this->db->prepare("UPDATE Mensaje SET estado = 'recibido_leido' WHERE id_mensaje = :id");
        $stmt->execute(['id' => $id_mensaje]);
    }


    
    // Obtener conversación entre dos usuarios
public function getConversacionEntre($id1, $id2) {
    $stmt = $this->db->prepare("
        SELECT * FROM Mensaje 
        WHERE (id_emisor = :id1 AND id_receptor = :id2)
           OR (id_emisor = :id2 AND id_receptor = :id1)
        ORDER BY fecha ASC
    ");
    $stmt->execute(['id1' => $id1, 'id2' => $id2]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
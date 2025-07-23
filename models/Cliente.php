<?php
// models/Cliente.php
require_once 'core/Model.php';

class Cliente extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Cliente INNER JOIN Usuario ON Cliente.id_cliente = Usuario.id_usuario");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Cliente INNER JOIN Usuario ON Cliente.id_cliente = Usuario.id_usuario WHERE Cliente.id_cliente = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($nombre, $correo, $telefono, $calificaciones) {
        $this->db->beginTransaction();

        // Insertar en Usuario
        $stmt1 = $this->db->prepare("INSERT INTO Usuario (fecha_creacion, nombre, correo, telefono) VALUES (NOW(), :nombre, :correo, :telefono)");
        $stmt1->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);
        $id_usuario = $this->db->lastInsertId();

        // Insertar en Cliente
        $stmt2 = $this->db->prepare("INSERT INTO Cliente (id_cliente, fecha_creacion, nombre, correo, telefono, calificaciones) VALUES (:id, NOW(), :nombre, :correo, :telefono, :calificaciones)");
        $stmt2->execute([
            'id' => $id_usuario,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'calificaciones' => $calificaciones
        ]);

        $this->db->commit();
    }

    public function update($id, $nombre, $correo, $telefono, $calificaciones) {
        $stmt1 = $this->db->prepare("UPDATE Usuario SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id_usuario = :id");
        $stmt1->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);

        $stmt2 = $this->db->prepare("UPDATE Cliente SET nombre = :nombre, correo = :correo, telefono = :telefono, calificaciones = :calificaciones WHERE id_cliente = :id");
        $stmt2->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'calificaciones' => $calificaciones
        ]);
    }

    public function delete($id) {
        $this->db->beginTransaction();
        $stmt1 = $this->db->prepare("DELETE FROM Cliente WHERE id_cliente = :id");
        $stmt1->execute(['id' => $id]);
        $stmt2 = $this->db->prepare("DELETE FROM Usuario WHERE id_usuario = :id");
        $stmt2->execute(['id' => $id]);
        $this->db->commit();
    }
}
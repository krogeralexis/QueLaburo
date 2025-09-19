<?php
// models/Administrador.php
require_once 'core/Model.php';

class Administrador extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Administrador INNER JOIN Usuario ON Administrador.id_administrador = Usuario.id");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Administrador INNER JOIN Usuario ON Administrador.id_administrador = Usuario.id WHERE Administrador.id_administrador = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($nombre, $correo, $telefono, $especialidad, $estado, $cantrep_resuelto) {
        $this->db->beginTransaction();
        $stmt1 = $this->db->prepare("INSERT INTO Usuario (fecha_creacion, nombre, correo, telefono) VALUES (NOW(), :nombre, :correo, :telefono)");
        $stmt1->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);
        $id = $this->db->lastInsertId();

        $stmt2 = $this->db->prepare("INSERT INTO Administrador (id_administrador, cantrep_resuelto, estado, especialidad, nombre, correo, telefono, fecha_creacion) VALUES (:id, :cantrep, :estado, :especialidad, :nombre, :correo, :telefono, NOW())");
        $stmt2->execute([
            'id' => $id,
            'cantrep' => $cantrep_resuelto,
            'estado' => $estado,
            'especialidad' => $especialidad,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);
        $this->db->commit();
    }

    public function update($id, $nombre, $correo, $telefono, $especialidad, $estado, $cantrep_resuelto) {
        $stmt1 = $this->db->prepare("UPDATE Usuario SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id = :id");
        $stmt1->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);

        $stmt2 = $this->db->prepare("UPDATE Administrador SET nombre = :nombre, correo = :correo, telefono = :telefono, especialidad = :especialidad, estado = :estado, cantrep_resuelto = :cantrep WHERE id_administrador = :id");
        $stmt2->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'especialidad' => $especialidad,
            'estado' => $estado,
            'cantrep' => $cantrep_resuelto
        ]);
    }

    public function delete($id) {
        $this->db->beginTransaction();
        $this->db->prepare("DELETE FROM Administrador WHERE id_administrador = :id")->execute(['id' => $id]);
        $this->db->prepare("DELETE FROM Usuario WHERE id = :id")->execute(['id' => $id]);
        $this->db->commit();
    }
}
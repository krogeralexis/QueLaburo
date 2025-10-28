<?php
// models/Proveedor.php
require_once 'core/Model.php';

class Proveedor extends Core\Model {
    public function getAll() {
    $stmt = $this->db->query("SELECT Proveedor.*, Usuario.*, Proveedor.calificacion AS calificacion_proveedor, Proveedor.cantidad_ventas FROM Proveedor INNER JOIN Usuario ON Proveedor.id_proveedor = Usuario.id");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getById($id) {
    $stmt = $this->db->prepare("SELECT Proveedor.*, Usuario.*, Proveedor.calificacion AS calificacion_proveedor, Proveedor.cantidad_ventas FROM Proveedor INNER JOIN Usuario ON Proveedor.id_proveedor = Usuario.id WHERE Proveedor.id_proveedor = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

    public function create($nombre, $correo, $telefono, $referencias, $calificacion, $cantidad_ventas) {
        $this->db->beginTransaction();

        $stmt1 = $this->db->prepare("INSERT INTO Usuario (fecha_creacion, nombre, correo, telefono) VALUES (NOW(), :nombre, :correo, :telefono)");
        $stmt1->execute([
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);
        $id = $this->db->lastInsertId();

        $stmt2 = $this->db->prepare("INSERT INTO Proveedor (id_proveedor, fecha_creacion, nombre, correo, telefono, referencias, calificacion, cantidad_ventas) VALUES (:id, NOW(), :nombre, :correo, :telefono, :referencias, :calificacion, :ventas)");
        $stmt2->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'referencias' => $referencias,
            'calificacion' => $calificacion,
            'ventas' => $cantidad_ventas
        ]);

        $this->db->commit();
    }

    public function update($id, $nombre, $correo, $telefono, $referencias, $calificacion, $cantidad_ventas) {
        $stmt1 = $this->db->prepare("UPDATE Usuario SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id = :id");
        $stmt1->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);

        $stmt2 = $this->db->prepare("UPDATE Proveedor SET nombre = :nombre, correo = :correo, telefono = :telefono, referencias = :referencias, calificacion = :calificacion, cantidad_ventas = :ventas WHERE id_proveedor = :id");
        $stmt2->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'referencias' => $referencias,
            'calificacion' => $calificacion,
            'ventas' => $cantidad_ventas
        ]);
    }

    public function delete($id) {
        $this->db->beginTransaction();
        $stmt1 = $this->db->prepare("DELETE FROM Proveedor WHERE id_proveedor = :id");
        $stmt1->execute(['id' => $id]);
        $stmt2 = $this->db->prepare("DELETE FROM Usuario WHERE id = :id");
        $stmt2->execute(['id' => $id]);
        $this->db->commit();
    }
}
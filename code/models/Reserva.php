<?php
// models/Reserva.php
require_once 'core/Model.php';

class Reserva extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Reserva");
        return $stmt->fetchAll();
    }

    public function getById($id_reserva, $id_cliente, $id_proveedor, $id_servicio) {
        $stmt = $this->db->prepare("SELECT * FROM Reserva WHERE id_reserva = :id_reserva AND id_cliente = :id_cliente AND id_proveedor = :id_proveedor AND id_servicio = :id_servicio");
        $stmt->execute([
            'id_reserva' => $id_reserva,
            'id_cliente' => $id_cliente,
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio
        ]);
        return $stmt->fetch();
    }

    public function create($id_reserva, $id_cliente, $id_proveedor, $id_servicio, $recordatorio, $resena, $fecha_reserva) {
        $stmt = $this->db->prepare("INSERT INTO Reserva (id_reserva, id_cliente, id_proveedor, id_servicio, recordatorio, reseña, fecha_reserva) VALUES (:id_reserva, :id_cliente, :id_proveedor, :id_servicio, :recordatorio, :resena, :fecha_reserva)");
        $stmt->execute([
            'id_reserva' => $id_reserva,
            'id_cliente' => $id_cliente,
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio,
            'recordatorio' => $recordatorio,
            'resena' => $resena,
            'fecha_reserva' => $fecha_reserva
        ]);
    }

    public function update($id_reserva, $id_cliente, $id_proveedor, $id_servicio, $recordatorio, $resena, $fecha_reserva) {
        $stmt = $this->db->prepare("UPDATE Reserva SET recordatorio = :recordatorio, reseña = :resena, fecha_reserva = :fecha_reserva WHERE id_reserva = :id_reserva AND id_cliente = :id_cliente AND id_proveedor = :id_proveedor AND id_servicio = :id_servicio");
        $stmt->execute([
            'id_reserva' => $id_reserva,
            'id_cliente' => $id_cliente,
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio,
            'recordatorio' => $recordatorio,
            'resena' => $resena,
            'fecha_reserva' => $fecha_reserva
        ]);
    }

    public function delete($id_reserva, $id_cliente, $id_proveedor, $id_servicio) {
        $stmt = $this->db->prepare("DELETE FROM Reserva WHERE id_reserva = :id_reserva AND id_cliente = :id_cliente AND id_proveedor = :id_proveedor AND id_servicio = :id_servicio");
        $stmt->execute([
            'id_reserva' => $id_reserva,
            'id_cliente' => $id_cliente,
            'id_proveedor' => $id_proveedor,
            'id_servicio' => $id_servicio
        ]);
    }
}
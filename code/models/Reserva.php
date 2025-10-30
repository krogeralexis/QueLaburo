<?php
// models/Reserva.php
require_once 'core/Model.php';

class Reserva extends Core\Model {

    /**
     * Obtener todas las reservas
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Reserva ORDER BY fecha_reserva DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtener reserva por ID
     */
    public function getById($id_reserva) {
        $stmt = $this->db->prepare("SELECT * FROM Reserva WHERE id_reserva = :id_reserva");
        $stmt->execute(['id_reserva' => $id_reserva]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
 * Devuelve los usuarios con los que el usuario $id_usuario ha tenido reservas
 * (cliente <-> proveedor) sin crear tablas nuevas.
 *
 * NOTA: usa los nombres de tabla/columnas que asume tu proyecto:
 * - Usuario (tabla de usuarios) con columna id
 * - Servicio con columna id y id_proveedor
 * - Reserva con columnas id_servicio e id_cliente
 *
 * Si tus columnas tienen otros nombres, adáptalos aquí.
 */
public function getContactosPorReservas($id_usuario) {
    try {
        $sql = "
            SELECT DISTINCT u.*
            FROM Usuario u
            WHERE u.id != :id
              AND (
                -- usuarios que son proveedores de servicios que el usuario reservó (si yo soy cliente)
                u.id IN (
                  SELECT s.id_proveedor
                  FROM Servicio s
                  JOIN Reserva r ON r.id_servicio = s.id
                  WHERE r.id_cliente = :id
                )
                OR
                -- usuarios que son clientes que reservaron mis servicios (si yo soy proveedor)
                u.id IN (
                  SELECT r.id_cliente
                  FROM Reserva r
                  JOIN Servicio s ON r.id_servicio = s.id
                  WHERE s.id_proveedor = :id
                )
              )
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        error_log("Reserva::getContactosPorReservas error: " . $e->getMessage());
        return []; // no rompear la app
    }
}



    /**
     * Obtener reservas de un cliente
     */
    public function getByCliente($id_cliente) {
        $stmt = $this->db->prepare("
            SELECT r.*, s.titulo 
            FROM Reserva r 
            LEFT JOIN Servicio s ON r.id_servicio = s.id_servicio 
            WHERE r.id_cliente = :id_cliente 
            ORDER BY r.fecha_reserva DESC
        ");
        $stmt->execute(['id_cliente' => $id_cliente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Comprobar disponibilidad exacta (fecha y hora)
     */
    public function isDisponible($id_servicio, $fechaHora) {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) AS cnt 
            FROM Reserva 
            WHERE id_servicio = :id_servicio 
              AND fecha_reserva = :fecha_reserva 
              AND estado <> 'cancelada'
        ");
        $stmt->execute([
            'id_servicio'   => $id_servicio,
            'fecha_reserva' => $fechaHora
        ]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($r['cnt'] == 0);
    }

    /**
     * Crear una reserva
     */
    public function create($id_cliente, $id_proveedor, $id_servicio, $resena, $fecha_reserva, $notas = null) {
        $stmt = $this->db->prepare("
            INSERT INTO Reserva 
                (id_cliente, id_proveedor, id_servicio, resena, fecha_reserva, notas, estado) 
            VALUES 
                (:id_cliente, :id_proveedor, :id_servicio, :resena, :fecha_reserva, :notas, 'pendiente')
        ");
        $stmt->execute([
            'id_cliente'    => $id_cliente,
            'id_proveedor'  => $id_proveedor,
            'id_servicio'   => $id_servicio,
            'resena'        => $resena,
            'fecha_reserva' => $fecha_reserva,
            'notas'         => $notas
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Actualizar estado de la reserva
     */
    public function updateEstado($id_reserva, $estado) {
        $stmt = $this->db->prepare("
            UPDATE Reserva SET estado = :estado WHERE id_reserva = :id_reserva
        ");
        $stmt->execute([
            'estado'       => $estado,
            'id_reserva'   => $id_reserva
        ]);
    }

    /**
     * Cancelar reserva (actualiza estado)
     */
    public function cancel($id_reserva) {
        $this->updateEstado($id_reserva, 'cancelada');
    }

    /**
     * Actualizar reserva
     */
    public function update($id_reserva, $resena, $fecha_reserva, $notas = null) {
        $stmt = $this->db->prepare("
            UPDATE Reserva 
            SET resena = :resena, fecha_reserva = :fecha_reserva, notas = :notas 
            WHERE id_reserva = :id_reserva
        ");
        $stmt->execute([
            'resena'        => $resena,
            'fecha_reserva' => $fecha_reserva,
            'notas'         => $notas,
            'id_reserva'    => $id_reserva
        ]);
    }
}

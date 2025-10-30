<?php
// models/Cliente.php
require_once 'core/Model.php';

class Cliente extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("
            SELECT Cliente.*, Usuario.*, Cliente.calif_cliente_promedio AS calificacion_cliente
            FROM Cliente
            INNER JOIN Usuario ON Cliente.id_cliente = Usuario.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT Cliente.*, Usuario.*, Cliente.calif_cliente_promedio AS calificacion_cliente
            FROM Cliente
            INNER JOIN Usuario ON Cliente.id_cliente = Usuario.id
            WHERE Cliente.id_cliente = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($id_cliente, $calif_cliente_promedio = 0, $cant_calif_cliente = 0) {
    $stmt = $this->db->prepare("INSERT INTO Cliente (id_cliente, calif_cliente_promedio, cant_calif_cliente) VALUES (:id_cliente, :calif_cliente_promedio, :cant_calif_cliente)");
    $stmt->execute([
        'id_cliente' => $id_cliente,
        'calif_cliente_promedio' => $calif_cliente_promedio,
        'cant_calif_cliente' => $cant_calif_cliente
    ]);
}

    public function update($id, $nombre, $correo, $telefono, $calif_cliente_promedio) {
        $stmt1 = $this->db->prepare("
            UPDATE Usuario
            SET nombre = :nombre, correo = :correo, telefono = :telefono
            WHERE id = :id
        ");
        $stmt1->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);

        $stmt2 = $this->db->prepare("
            UPDATE Cliente
            SET nombre = :nombre, correo = :correo, telefono = :telefono, calif_cliente_promedio = :calif_cliente_promedio
            WHERE id_cliente = :id
        ");
        $stmt2->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'calif_cliente_promedio' => $calif_cliente_promedio
        ]);
    }

    public function delete($id) {
        $this->db->beginTransaction();
        $stmt1 = $this->db->prepare("DELETE FROM Cliente WHERE id_cliente = :id");
        $stmt1->execute(['id' => $id]);
        $stmt2 = $this->db->prepare("DELETE FROM Usuario WHERE id = :id");
        $stmt2->execute(['id' => $id]);
        $this->db->commit();
    }
}

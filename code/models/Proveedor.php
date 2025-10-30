<?php
// models/Proveedor.php
require_once 'core/Model.php';

class Proveedor extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("
            SELECT 
                Proveedor.*, 
                Usuario.*, 
                Proveedor.calif_proveedor_promedio AS calif_proveedor_promedio, 
                Proveedor.cantidad_ventas 
            FROM Proveedor 
            INNER JOIN Usuario ON Proveedor.id_proveedor = Usuario.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("
            SELECT 
                Proveedor.*, 
                Usuario.*, 
                Proveedor.calif_proveedor_promedio AS calif_proveedor_promedio, 
                Proveedor.cantidad_ventas 
            FROM Proveedor 
            INNER JOIN Usuario ON Proveedor.id_proveedor = Usuario.id 
            WHERE Proveedor.id_proveedor = :id
        ");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todos los datos del proveedor asociado a un usuario en particular
     * @param int $id_usuario El ID del usuario
     * @return array|null Los datos del proveedor o null si no se encuentra
     */
    public function getByUsuarioId($id_usuario) {
        $stmt = $this->db->prepare("
            SELECT 
                Proveedor.*, 
                Usuario.*,
                Proveedor.calif_proveedor_promedio AS calif_proveedor_promedio,
                Proveedor.cantidad_ventas 
            FROM Proveedor
            INNER JOIN Usuario ON Proveedor.id_proveedor = Usuario.id
            WHERE Usuario.id = :id_usuario
        ");
        $stmt->execute(['id_usuario' => $id_usuario]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ CORREGIDO: sin fecha_creacion ni NOW()
    public function create($id_usuario, $calif_proveedor_promedio = 0, $cantidad_ventas = 0) {
        $stmt = $this->db->prepare("
            INSERT INTO Proveedor (id_proveedor, calif_proveedor_promedio, cantidad_ventas)
            VALUES (:id_usuario, :calif, :ventas)
        ");

        $stmt->execute([
            'id_usuario' => $id_usuario,
            'calif' => $calif_proveedor_promedio,
            'ventas' => $cantidad_ventas
        ]);

        return $id_usuario; // el id_proveedor es igual al id_usuario
    }

    public function update($id, $nombre, $correo, $telefono, $referencias, $calif_proveedor_promedio, $cantidad_ventas) {
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
            UPDATE Proveedor 
            SET 
                nombre = :nombre, 
                correo = :correo, 
                telefono = :telefono, 
                referencias = :referencias, 
                calif_proveedor_promedio = :calif_proveedor_promedio, 
                cantidad_ventas = :ventas 
            WHERE id_proveedor = :id
        ");
        $stmt2->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono,
            'referencias' => $referencias,
            'calif_proveedor_promedio' => $calif_proveedor_promedio,
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

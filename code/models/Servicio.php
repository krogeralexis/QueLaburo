<?php
// models/Servicio.php
require_once 'core/Model.php';

class Servicio extends Core\Model {

    /**
     * Devuelve todos los servicios con el nombre del proveedor
     */
    public function getAll() {
        $sql = "
            SELECT 
                s.id_servicio, 
                s.categoria, 
                s.descripcion, 
                s.precio, 
                s.titulo, 
                s.imagen,
                u.nombre AS proveedor_nombre
            FROM Servicio s
            JOIN Proveedor p ON s.id_proveedor = p.id_proveedor
            JOIN Usuario u ON p.id_proveedor = u.id
        ";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve un servicio específico por ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Servicio WHERE id_servicio = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo servicio
     */
    public function create($disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen) {
        $stmt = $this->db->prepare(
            "INSERT INTO Servicio (disponibilidad, categoria, descripcion, precio, titulo, imagen) 
             VALUES (:disponibilidad, :categoria, :descripcion, :precio, :titulo, :imagen)"
        );
        $stmt->execute([
            'disponibilidad' => $disponibilidad,
            'categoria' => $categoria,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'titulo' => $titulo,
            'imagen' => $imagen
        ]);
    }

    /**
     * Actualiza un servicio existente
     */
    public function update($id, $disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen) {
        $stmt = $this->db->prepare(
            "UPDATE Servicio 
             SET disponibilidad = :disponibilidad, categoria = :categoria, descripcion = :descripcion, 
                 precio = :precio, titulo = :titulo, imagen = :imagen 
             WHERE id_servicio = :id"
        );
        $stmt->execute([
            'id' => $id,
            'disponibilidad' => $disponibilidad,
            'categoria' => $categoria,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'titulo' => $titulo,
            'imagen' => $imagen
        ]);
    }

    /**
     * Elimina un servicio
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Servicio WHERE id_servicio = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>
<?php
// models/Servicio.php
require_once __DIR__ . '/../core/Model.php';

class Servicio extends \Core\Model 
{
    /**
     * Obtiene un servicio por su ID, junto con datos del proveedor y usuario
     */
    public function obtenerServicioPorId($id_servicio) {
        $sql = "
            SELECT 
                s.*, 
                p.id_proveedor,
                u.nombre AS proveedor_nombre,
                u.correo AS proveedor_correo,
                u.telefono AS proveedor_telefono,
                u.foto_perfil
            FROM Servicio s
            INNER JOIN Proveedor p ON s.id_proveedor = p.id_proveedor
            INNER JOIN Usuario u ON p.id_proveedor = u.id
            WHERE s.id_servicio = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id_servicio, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Devuelve todos los servicios con información del proveedor
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
                u.nombre AS proveedor_nombre,
                u.id AS proveedor_id,
                u.foto_perfil
            FROM Servicio s
            INNER JOIN Proveedor p ON s.id_proveedor = p.id_proveedor
            INNER JOIN Usuario u ON p.id_proveedor = u.id
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
        $stmt = $this->db->prepare("
            INSERT INTO Servicio (disponibilidad, categoria, descripcion, precio, titulo, imagen)
            VALUES (:disponibilidad, :categoria, :descripcion, :precio, :titulo, :imagen)
        ");
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
        $stmt = $this->db->prepare("
            UPDATE Servicio 
            SET disponibilidad = :disponibilidad, 
                categoria = :categoria, 
                descripcion = :descripcion, 
                precio = :precio, 
                titulo = :titulo, 
                imagen = :imagen
            WHERE id_servicio = :id
        ");
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

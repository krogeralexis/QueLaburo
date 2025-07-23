<?php
// models/Servicio.php
require_once 'core/Model.php';

class Servicio extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Servicio");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Servicio WHERE id_servicio = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen) {
        $stmt = $this->db->prepare("INSERT INTO Servicio (disponibilidad, categoria, descripcion, precio, titulo, imagen) VALUES (:disponibilidad, :categoria, :descripcion, :precio, :titulo, :imagen)");
        $stmt->execute([
            'disponibilidad' => $disponibilidad,
            'categoria' => $categoria,
            'descripcion' => $descripcion,
            'precio' => $precio,
            'titulo' => $titulo,
            'imagen' => $imagen
        ]);
    }

    public function update($id, $disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen) {
        $stmt = $this->db->prepare("UPDATE Servicio SET disponibilidad = :disponibilidad, categoria = :categoria, descripcion = :descripcion, precio = :precio, titulo = :titulo, imagen = :imagen WHERE id_servicio = :id");
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

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Servicio WHERE id_servicio = :id");
        $stmt->execute(['id' => $id]);
    }
}
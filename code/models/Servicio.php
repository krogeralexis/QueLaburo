<?php
require_once __DIR__ . '/../core/Model.php';

class Servicio extends \Core\Model 
{
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

    public function getAll() {
        $sql = "
            SELECT 
                s.id_servicio, 
                s.disponibilidad,
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

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Servicio WHERE id_servicio = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsuarioId($id_usuario) {
        $sql = "SELECT * FROM Proveedor WHERE id_proveedor = :id_usuario LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // ✅ Create usando nombres correctos de columnas
    public function create($id_proveedor, $disponibilidad, $categoria, $descripcion, $precio, $titulo, $imagen)
    {
        $sql = "INSERT INTO Servicio 
                (id_proveedor, disponibilidad, categoria, descripcion, precio, titulo, imagen)
                VALUES 
                (:id_proveedor, :disponibilidad, :categoria, :descripcion, :precio, :titulo, :imagen)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id_proveedor', $id_proveedor, PDO::PARAM_INT);
        $stmt->bindParam(':disponibilidad', $disponibilidad);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->bindParam(':precio', $precio);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':imagen', $imagen, PDO::PARAM_LOB);
        
        $stmt->execute();
        return $this->db->lastInsertId();
    }

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

    public function getServiciosPorCliente($id_cliente) {
        $sql = "
            SELECT 
                s.id_servicio,
                s.categoria,
                s.titulo,
                s.descripcion,
                s.imagen,
                u.id AS proveedor_id,
                u.nombre AS proveedor_nombre,
                u.foto_perfil,
                r.id_reserva,
                r.fecha_reserva,
                r.estado,
                r.notas
            FROM Reserva r
            INNER JOIN Servicio s ON r.id_servicio = s.id_servicio
            INNER JOIN Proveedor p ON s.id_proveedor = p.id_proveedor
            INNER JOIN Usuario u ON p.id_proveedor = u.id
            WHERE r.id_cliente = :id_cliente
            ORDER BY s.id_servicio, r.fecha_reserva DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_cliente' => $id_cliente]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $servicios = [];
        foreach ($rows as $r) {
            $id_servicio = $r['id_servicio'];
            if (!isset($servicios[$id_servicio])) {
                $servicios[$id_servicio] = [
                    'id_servicio'      => $r['id_servicio'],
                    'categoria'        => $r['categoria'],
                    'titulo'           => $r['titulo'],
                    'descripcion'      => $r['descripcion'],
                    'imagen'           => $r['imagen'],
                    'proveedor_nombre' => $r['proveedor_nombre'],
                    'foto_perfil'      => $r['foto_perfil'],
                    'proveedor_id'     => $r['proveedor_id'],
                    'rol'              => 'Proveedor',
                    'reservas'         => []
                ];
            }
            $servicios[$id_servicio]['reservas'][] = [
                'id'            => $r['id_reserva'],
                'fecha_reserva' => $r['fecha_reserva'],
                'estado'        => $r['estado'],
                'notas'         => $r['notas']
            ];
        }

        return array_values($servicios);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM Servicio WHERE id_servicio = :id");
        $stmt->execute(['id' => $id]);
    }
}
?>

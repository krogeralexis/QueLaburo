<?php
// models/Usuario.php
require_once __DIR__ . '/../core/Model.php';

class Usuario extends \Core\Model 
{
    public function getAll() 
    {
        $stmt = $this->db->query("SELECT * FROM Usuario");
        return $stmt->fetchAll();
    }

    public function getById($id) 
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }

    public function getByEmail($correo)
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE correo = :correo LIMIT 1");
        $stmt->execute([':correo' => $correo]);
        return $stmt->fetch();
    }

    public function create($nombre, $correo, $telefono, $password, $google_uid = null) 
    {
        try 
        {
            $stmt = $this->db->prepare("
                INSERT INTO Usuario (fecha_creacion, nombre, correo, telefono, password, google_uid) 
                VALUES (NOW(), :nombre, :correo, :telefono, :password, :google_uid)
            ");
            $stmt->execute([
                ':nombre'     => $nombre,
                ':correo'     => $correo,
                ':telefono'   => $telefono,
                ':password'   => $password,
                ':google_uid' => $google_uid
            ]);
            return true;
        } catch (PDOException $e) 
        {
            error_log("Error al crear usuario: " . $e->getMessage());
            return false;
        }
    }

    public function exists($correo) 
    {
        $stmt = $this->db->prepare("SELECT id FROM Usuario WHERE correo = :correo LIMIT 1");
        $stmt->execute([':correo' => $correo]);
        return (bool) $stmt->fetch();
    }

    public function update($id, $nombre, $correo, $telefono) 
    {
        $stmt = $this->db->prepare("UPDATE Usuario SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);
    }

    public function delete($id) 
    {
        $stmt = $this->db->prepare("DELETE FROM Usuario WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function esCliente($id)
    {
        $stmt = $this->db->prepare("SELECT id_cliente FROM Cliente WHERE id_cliente = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return (bool) $stmt->fetch();
    }

    public function esProveedor($id)
    {
        $stmt = $this->db->prepare("SELECT id_proveedor FROM Proveedor WHERE id_proveedor = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return (bool) $stmt->fetch();
    }

    // Obtener calificación promedio como cliente
    public function getCalificacionCliente($id)
    {
        $stmt = $this->db->prepare("SELECT calif_cliente_promedio FROM Cliente WHERE id_cliente = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn();
    }

    // Obtener calificación promedio como proveedor
    public function getCalificacionProveedor($id)
    {
        $stmt = $this->db->prepare("SELECT calif_proveedor_promedio FROM Proveedor WHERE id_proveedor = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetchColumn();
    }

    /**
     * Obtiene todos los datos del usuario junto con sus posibles roles (cliente / proveedor)
     */
    public function getPerfilCompleto($id)
    {
        // Datos base del usuario
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$usuario) return null;

        // Verificar si es cliente
        $stmt = $this->db->prepare("SELECT calif_cliente_promedio, cant_calif_cliente FROM Cliente WHERE id_cliente = :id");
        $stmt->execute([':id' => $id]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario['es_cliente'] = (bool) $cliente;
        $usuario['calif_cliente'] = $cliente['calif_cliente_promedio'] ?? null;
        $usuario['cant_calif_cliente'] = $cliente['cant_calif_cliente'] ?? 0;

        // Verificar si es proveedor
        $stmt = $this->db->prepare("SELECT referencias, cantidad_ventas, calif_proveedor_promedio, cant_calif_proveedor FROM Proveedor WHERE id_proveedor = :id");
        $stmt->execute([':id' => $id]);
        $proveedor = $stmt->fetch(PDO::FETCH_ASSOC);
        $usuario['es_proveedor'] = (bool) $proveedor;
        $usuario['referencias'] = $proveedor['referencias'] ?? null;
        $usuario['cantidad_ventas'] = $proveedor['cantidad_ventas'] ?? 0;
        $usuario['calif_proveedor'] = $proveedor['calif_proveedor_promedio'] ?? null;
        $usuario['cant_calif_proveedor'] = $proveedor['cant_calif_proveedor'] ?? 0;

        return $usuario;
    }

    /**
     * Autentica un usuario mediante su correo y contraseña.
     */
    public function login($correo, $password) 
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE correo = :correo LIMIT 1");
        $stmt->execute(['correo' => $correo]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) 
        {
            $usuario_id = $user['id'];
            $user['es_cliente'] = $this->esCliente($usuario_id);
            $user['es_proveedor'] = $this->esProveedor($usuario_id);
            return $user;
        }
        return false;
    }
}

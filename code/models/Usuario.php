<?php
// models/Usuario.php
require_once 'core/Model.php';

class Usuario extends Core\Model 
{
    /**
     * Devuelve todos los usuarios registrados en la base de datos.
     * * @return array Un array con todos los usuarios.
     */
    public function getAll() 
    {
        $stmt = $this->db->query("SELECT * FROM Usuario");
        return $stmt->fetchAll();
    }

    /**
     * Devuelve un usuario especificado por su ID.
     * * @param int $id El ID del usuario que se desea obtener.
     * @return array Un array con la información del usuario, o false si no se encuentra.
     */
    public function getById($id) 
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    
    /**
     * Registra un nuevo usuario en la base de datos.
     * * @param string $nombre El nombre del usuario.
     * @param string $correo El correo electrónico del usuario.
     * @param string $telefono El telefono del usuario.
     * @param string $password La contraseña del usuario.
     */
    public function create($nombre, $correo, $telefono, $password) 
    {
        try 
        {
            $stmt = $this->db->prepare("
                INSERT INTO Usuario (fecha_creacion, nombre, correo, telefono, password) 
                VALUES (NOW(), :nombre, :correo, :telefono, :password)
            ");
            $stmt->execute([
                ':nombre'   => $nombre,
                ':correo'   => $correo,
                ':telefono' => $telefono,
                ':password' => $password
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
        // Implementación del método exists
        $stmt = $this->db->prepare("SELECT id FROM Usuario WHERE correo = :correo LIMIT 1");
        $stmt->execute([':correo' => $correo]);
        return (bool) $stmt->fetch();
    }


    public function update($id, $nombre, $correo, $telefono) 
    {
        $stmt = $this->db->prepare("UPDATE Usuario SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id = :id");
        // Nota: Cambié id_usuario a id, basado en tu esquema de BD
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
        // Nota: Cambié id_usuario a id, basado en tu esquema de BD
        $stmt->execute(['id' => $id]);
    }
    
    // =========================================================
    // NUEVOS MÉTODOS PARA VERIFICAR ROLES
    // =========================================================

    /**
     * Devuelve true si el usuario con el ID dado existe en la tabla Cliente.
     * * @param int $id El ID del usuario.
     * @return bool
     */
   public function esCliente($id)
{
    // CUIDADO: La columna PK/FK en la tabla Cliente es id_cliente
    $stmt = $this->db->prepare("SELECT id_cliente FROM Cliente WHERE id_cliente = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return (bool) $stmt->fetch();
}

    /**
     * Devuelve true si el usuario con el ID dado existe en la tabla Proveedor.
     * * @param int $id El ID del usuario.
     * @return bool
     */
    public function esProveedor($id)
{
    // CUIDADO: La columna PK/FK en la tabla Proveedor es id_proveedor
    $stmt = $this->db->prepare("SELECT id_proveedor FROM Proveedor WHERE id_proveedor = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return (bool) $stmt->fetch();
}

    // =========================================================
    // MÉTODO LOGIN MODIFICADO
    // =========================================================
    public function login($correo, $password) 
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE correo = :correo LIMIT 1");
        $stmt->execute(['correo' => $correo]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) 
        {
            $usuario_id = $user['id'];
            
            // 1. CONSULTA DE ROLES: Adjuntamos los booleanos de rol al array del usuario
            $user['es_cliente'] = $this->esCliente($usuario_id);
            $user['es_proveedor'] = $this->esProveedor($usuario_id);
            
            return $user; // Devuelve el array con el usuario y las claves 'es_cliente'/'es_proveedor'
        }

        return false;
    }
}
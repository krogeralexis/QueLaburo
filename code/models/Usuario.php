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
        $stmt->execute(['id' => $id]);
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

    /**
     * Autentica un usuario mediante su correo y contraseña.
     * 
     * @param string $correo El correo del usuario.
     * @param string $password La contraseña del usuario.
     * @return array|bool El usuario autenticado o false si no se encuentra.
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

    // =========================================================
    // Métodos para Google Login
    // =========================================================
    
    /**
     * Asigna un identificador de Google a un usuario
     * 
     * @param int $id El identificador del usuario
     * @param string $uid El identificador de Google
     */
    public function setGoogleUid($id, $uid)
    {
        $stmt = $this->db->prepare("UPDATE Usuario SET google_uid = :uid WHERE id = :id");
        $stmt->execute(['id' => $id, 'uid' => $uid]);
    }
}

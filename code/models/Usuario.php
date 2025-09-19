<?php
// models/Usuario.php
require_once 'core/Model.php';

class Usuario extends Core\Model 
{
    /**
     * Devuelve todos los usuarios registrados en la base de datos.
     * 
     * @return array Un array con todos los usuarios.
     */
    public function getAll() 
    {
        $stmt = $this->db->query("SELECT * FROM Usuario");
        return $stmt->fetchAll();
    }

    /**
     * Devuelve un usuario especificado por su ID.
     * 
     * @param int $id El ID del usuario que se desea obtener.
     * @return array Un array con la informaci n del usuario, o false si no se encuentra.
     */
    public function getById($id) 
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    
    /**
     * Registra un nuevo usuario en la base de datos.
     * 
     * @param string $nombre El nombre del usuario.
     * @param string $correo El correo electr nico del usuario.
     * @param string $telefono El telefono del usuario.
     * @param string $password La contrase a del usuario.
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
        // Devuelve true si el correo ya está registrado
    }


    public function update($id, $nombre, $correo, $telefono) 
    {
        $stmt = $this->db->prepare("UPDATE Usuario SET nombre = :nombre, correo = :correo, telefono = :telefono WHERE id_usuario = :id");
        $stmt->execute([
            'id' => $id,
            'nombre' => $nombre,
            'correo' => $correo,
            'telefono' => $telefono
        ]);
    }

    public function delete($id) 
    {
        $stmt = $this->db->prepare("DELETE FROM Usuario WHERE id_usuario = :id");
        $stmt->execute(['id' => $id]);
    }
    public function login($correo, $password) 
    {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE correo = :correo LIMIT 1");
        $stmt->execute(['correo' => $correo]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) 
        {
            return $user;
        }

        return false;
    }
}

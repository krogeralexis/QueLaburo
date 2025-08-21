<?php
// models/Usuario.php
require_once 'core/Model.php';

class Usuario extends Core\Model {
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM Usuario");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM Usuario WHERE id_usuario = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    
public function create($nombre, $correo, $telefono, $password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->db->prepare("INSERT INTO Usuario (fecha_creacion, nombre, correo, telefono, password) 
                                VALUES (NOW(), :nombre, :correo, :telefono, :password)");
    $stmt->execute([
        'nombre' => $nombre,
        'correo' => $correo,
        'telefono' => $telefono,
        'password' => $hashedPassword
    ]);
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

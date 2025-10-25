<?php
require_once 'core/Model.php';

class AdminAuth extends Core\Model {

    public function verificarCredenciales($correo, $password) {
        $sql = "SELECT u.id, u.password 
                FROM Usuario u
                INNER JOIN Administrador a ON a.id_administrador = u.id
                WHERE u.correo = :correo";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $admin = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin['id'];
        }
        return false;
    }
}

<?php
require_once 'core/Model.php';

class AdminAuth extends Core\Model {

    /**
     * Verifica las credenciales de un administrador.
     * 
     * @param string $correo El correo del administrador.
     * @param string $password La contraseña del administrador.
     * @return int|false El id del administrador autenticado o false si no se encuentra.
     */
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
/**
 * Verifica si un usuario es administrador.
 * 
 * @param int $id El id del usuario a verificar.
 * @return bool True si el usuario es administrador, false en caso contrario.
 */
    public function esAdmin($id) {
    $stmt = $this->db->prepare("SELECT id_administrador FROM Administrador WHERE id_administrador = :id LIMIT 1");
    $stmt->execute([':id' => $id]);
    return (bool) $stmt->fetch();
}
}

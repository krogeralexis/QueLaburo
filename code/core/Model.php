<?php
namespace Core;

use PDO;
use PDOException;

class Model {
    protected PDO $db;

    public function __construct() {
    try {
        $this->db = new PDO(
            'mysql:host=sql204.infinityfree.com;dbname=if0_40213381_quelaburo;charset=utf8mb4',
            'if0_40213381',       // usuario
            'H1temJTycUHVo',      // contraseña
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]
        );
    } catch (PDOException $e) {
         die('Error de conexión a base de datos: ' . $e->getMessage());
    }
}

}

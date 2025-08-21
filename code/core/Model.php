<?php
namespace Core;

use PDO;
use PDOException;

class Model {
    protected PDO $db;

    public function __construct() {
        try {
            $this->db = new PDO(
                'mysql:host=localhost;dbname=queLaburo;charset=utf8mb4',
                'root',       
                '',           
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );
        } catch (PDOException $e) {
            die('Error de conexión a base de datos');
        }
    }
}

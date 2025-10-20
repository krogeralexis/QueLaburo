<?php
// models/ModelBase.php
require_once __DIR__ . '/../config/database.php';

class ModelBase {
    protected $db;

    public function __construct() {
        // Usar la clase Database para obtener la conexión
        $this->db = Database::connect();
    }
}

<?php
// config/database.php

class Database {
    private static $host = 'localhost';
    private static $db = 'queLaburo';
    private static $user = 'root';
    private static $pass = 'root';      
    private static $charset = 'utf8mb4';

    public static function connect() {
        try {
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$db . ";charset=" . self::$charset;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            return new PDO($dsn, self::$user, self::$pass, $options);
        } catch (PDOException $e) {
            die("Error en la conexión: " . $e->getMessage());
        }
    }
}

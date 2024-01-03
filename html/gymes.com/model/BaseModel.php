<?php

require_once '/var/www/html/gymes.com/config/config.php';


class BaseModel {
    //propiedad protegida para almacenar la conexión a la base de datos.
    protected $conn;

    //Constructor que acepta una conexión a la base de datos como argumento.
    public function __construct($conn) {
        $this->conn = $conn;
    }

    //método protegido para ejecutar una declaración PDO con un conjunto de datos proporcionado.
    protected function executeStatement($stmt, $data = []) {
        return $stmt->execute($data);
    }

    //método protegido para obtener un único resultado de una declaración PDO.
    protected function fetchOne($stmt) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //método protegido para obtener todos los resultados de una declaración PDO.
    protected function fetchAll($stmt) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
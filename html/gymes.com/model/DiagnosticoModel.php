<?php
require_once 'SesionModel.php';

class DiagnosticoModel extends SesionModel {
  
    public function __construct($conn) {
        parent::__construct($conn);
    }

    // TRATAMIENTO *****************
    public function leerTratamiento($id_sesion) {
        try {
            $sql = "SELECT * FROM tratamiento WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_sesion', $id_sesion);

            if($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Error al leer el tratamiento");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function crearTratamiento($id_sesion, $nombre, $area) {
        try {
            $sql = "INSERT INTO tratamiento (id_sesion, nombre, area) VALUES (:id_sesion, :nombre, :area)";
            
            $stmt = $this->conn->prepare($sql);
            $params = [
                ':id_sesion' => $id_sesion,
                ':nombre' => $nombre,
                ':area' => $area
            ];

            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al insertar el tratamiento");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }

    //Actualizar tratamiento
    public function updateTratamiento($id_sesion, $nombre, $area) {
        try {
            $sql = "UPDATE tratamiento SET nombre = :nombre, area = :area WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $params = [
                ':id_sesion' => $id_sesion,
                ':nombre' => $nombre,
                ':area' => $area
            ];

            if ($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al actualizar el tratamiento");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    

    // ENFERMEDAD *********************
    public function leerEnfermedad($id_sesion) {
        try {
            $sql = "SELECT * FROM enfermedad WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_sesion', $id_sesion);

            if($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Error al leer la enfermedad");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    //Crear enfermedad
    public function crearEnfermedad($id_sesion, $tipo, $detalle) {
        try {
            $sql = "INSERT INTO enfermedad (id_sesion, tipo, detalle) VALUES (:id_sesion, :tipo, :detalle)";
            
            $stmt = $this->conn->prepare($sql);
            $params = [
                ':id_sesion' => $id_sesion,
                ':tipo' => $tipo,
                ':detalle' => $detalle
            ];

            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al insertar la enfermedad");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage();
        }
    }

    //Actualizar enfermedad
    public function updateEnfermedad($id_sesion, $tipo, $detalle) {
        try {
            $sql = "UPDATE enfermedad SET tipo = :tipo, detalle = :detalle WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $params = [
                ':id_sesion' => $id_sesion,
                ':tipo' => $tipo,
                ':detalle' => $detalle
            ];

            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al actualizar la enfermedad");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    
}
?>

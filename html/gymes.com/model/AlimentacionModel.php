<?php
require_once  'SesionModel.php';

class AlimentacionModel extends SesionModel {
  
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function leerAlimentacion($id_sesion) {
        try {
            $sql = "SELECT * FROM alimentacion WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_sesion', $id_sesion);
    
            if($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Error al leer los datos de alimentación");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function crearAlimentacion($id_sesion, $desayuno, $almuerzo, $merienda, $extra, $observaciones, $recomendada) {
        try {
            $sql = "INSERT INTO alimentacion (id_sesion, desayuno, almuerzo, merienda, extra, observaciones, recomendada) 
                    VALUES (:id_sesion, :desayuno, :almuerzo, :merienda, :extra, :observaciones, :recomendada)";
            
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':id_sesion' => $id_sesion,
                ':desayuno' => $desayuno,
                ':almuerzo' => $almuerzo,
                ':merienda' => $merienda,
                ':extra' => $extra,
                ':observaciones' => $observaciones,
                ':recomendada' => $recomendada
            ];
    
            if($stmt->execute($params)) {                
                return true;
            } else {
                throw new Exception("Error al insertar los datos de alimentación");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage(); // Esto retornará el mensaje de error.
        }
    }

    public function updateAlimentacion($id_sesion, $desayuno, $almuerzo, $merienda, $extra, $observaciones, $recomendada) {
        try {
            $sql = "UPDATE alimentacion 
                    SET desayuno = :desayuno, 
                        almuerzo = :almuerzo, 
                        merienda = :merienda, 
                        extra = :extra, 
                        observaciones = :observaciones, 
                        recomendada = :recomendada 
                    WHERE id_sesion = :id_sesion";
                    
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':id_sesion' => $id_sesion,
                ':desayuno' => $desayuno,
                ':almuerzo' => $almuerzo,
                ':merienda' => $merienda,
                ':extra' => $extra,
                ':observaciones' => $observaciones,
                ':recomendada' => $recomendada
            ];
    
            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al actualizar los datos de alimentación");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>

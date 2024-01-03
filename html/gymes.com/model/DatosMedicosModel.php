<?php
require_once 'SesionModel.php';

class DatosMedicosModel extends SesionModel {
  
    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function leerDatosMedicos($id_sesion) {
        try {
            $sql = "SELECT * FROM datos_medicos WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_sesion', $id_sesion);
    
            if($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                throw new Exception("Error al leer los datos médicos");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    public function crearDatosMedicos($id_sesion, $talla, $peso, $ta, $pulso, $fr, $medicamentos) {
        try {
            $sql = "INSERT INTO datos_medicos (id_sesion, talla, peso, ta, pulso, fr, medicamentos) 
                    VALUES (:id_sesion, :talla, :peso, :ta, :pulso, :fr, :medicamentos)";
            
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':id_sesion' => $id_sesion,
                ':talla' => $talla,
                ':peso' => $peso,
                ':ta' => $ta,
                ':pulso' => $pulso,
                ':fr' => $fr,
                ':medicamentos' => $medicamentos
            ];
    
            if($stmt->execute($params)) {                
                return true;
            } else {
                throw new Exception("Error al insertar los datos médicos");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return $e->getMessage(); // Esto retornará el mensaje de error.
        }
    }

    public function updateDatosMedicos($id_sesion, $talla, $peso, $ta, $pulso, $fr, $medicamentos) {
        try {
            $sql = "UPDATE datos_medicos 
                    SET talla = :talla, 
                        peso = :peso, 
                        ta = :ta, 
                        pulso = :pulso, 
                        fr = :fr, 
                        medicamentos = :medicamentos 
                    WHERE id_sesion = :id_sesion";
                    
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':id_sesion' => $id_sesion,
                ':talla' => $talla,
                ':peso' => $peso,
                ':ta' => $ta,
                ':pulso' => $pulso,
                ':fr' => $fr,
                ':medicamentos' => $medicamentos
            ];
    
            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al actualizar los datos médicos");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }
}
?>

<?php
require_once 'SesionModel.php';

class MedidasModel extends SesionModel {
  
    public function __construct($conn) {
        parent::__construct($conn);
    }

    // MEDIDAS *************************
    
    // Método para leer las medidas
    public function leerMedidas($id_sesion) {
        try {
            $sql = "SELECT * FROM medidas WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id_sesion' => $id_sesion]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Método para ingresar las medidas
    public function crearMedidas($id_sesion, $torax, $axilas, $busto, $brazo_der, $brazo_izq, $abd_alto, $abd_bajo, $cintura, $cadera, $gluteos, $muslo_der, $muslo_izq, $rodilla_der, $rodilla_izq) {
        try {
            $sql = "INSERT INTO medidas (id_sesion, torax, axilas, busto, brazo_der, brazo_izq, abd_alto, abd_bajo, cintura, cadera, gluteos, muslo_der, muslo_izq, rodilla_der, rodilla_izq) 
                    VALUES (:id_sesion, :torax, :axilas, :busto, :brazo_der, :brazo_izq, :abd_alto, :abd_bajo, :cintura, :cadera, :gluteos, :muslo_der, :muslo_izq, :rodilla_der, :rodilla_izq)";
            
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':id_sesion' => $id_sesion,
                ':torax' => $torax,
                ':axilas' => $axilas,
                ':busto' => $busto,
                ':brazo_der' => $brazo_der,
                ':brazo_izq' => $brazo_izq,
                ':abd_alto' => $abd_alto,
                ':abd_bajo' => $abd_bajo,
                ':cintura' => $cintura,
                ':cadera' => $cadera,
                ':gluteos' => $gluteos,
                ':muslo_der' => $muslo_der,
                ':muslo_izq' => $muslo_izq,
                ':rodilla_der' => $rodilla_der,
                ':rodilla_izq' => $rodilla_izq
            ];

            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al insertar las medidas");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Método para actualizar las medidas
    public function updateMedidas($id_sesion, $torax, $axilas, $busto, $brazo_der, $brazo_izq, $abd_alto, $abd_bajo, $cintura, $cadera, $gluteos, $muslo_der, $muslo_izq, $rodilla_der, $rodilla_izq) {
        try {
            $sql = "UPDATE medidas 
                    SET torax = :torax,
                        axilas = :axilas,
                        busto = :busto,
                        brazo_der = :brazo_der,
                        brazo_izq = :brazo_izq,
                        abd_alto = :abd_alto,
                        abd_bajo = :abd_bajo,
                        cintura = :cintura,
                        cadera = :cadera,
                        gluteos = :gluteos,
                        muslo_der = :muslo_der,
                        muslo_izq = :muslo_izq,
                        rodilla_der = :rodilla_der,
                        rodilla_izq = :rodilla_izq
                    WHERE id_sesion = :id_sesion";
                    
            $stmt = $this->conn->prepare($sql);
            
            $params = [
                ':id_sesion' => $id_sesion,
                ':torax' => $torax,
                ':axilas' => $axilas,
                ':busto' => $busto,
                ':brazo_der' => $brazo_der,
                ':brazo_izq' => $brazo_izq,
                ':abd_alto' => $abd_alto,
                ':abd_bajo' => $abd_bajo,
                ':cintura' => $cintura,
                ':cadera' => $cadera,
                ':gluteos' => $gluteos,
                ':muslo_der' => $muslo_der,
                ':muslo_izq' => $muslo_izq,
                ':rodilla_der' => $rodilla_der,
                ':rodilla_izq' => $rodilla_izq
            ];
            
            if($stmt->execute($params)) {
                return true;
            } else {
                throw new Exception("Error al actualizar las medidas");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // Otros métodos relacionados a 'MedidasModel' pueden ir aquí...
}

?>

<?php

require_once 'PersonModel.php';

class LoginModel extends PersonModel {

    public function verificarUsuario($email, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM personas WHERE email = :email");
            $stmt->execute([':email' => $email]);
    
            if ($stmt->rowCount() == 1) {
                $usuario = $stmt->fetch(PDO::FETCH_OBJ);
                
                if (password_verify($password, $usuario->password)) {
                    return $usuario->rol;
                }
            }
            return false;
    
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function esPrimerLogin($email) {
        $stmt = $this->conn->prepare("SELECT estado_login FROM personas WHERE email = :email");
        $stmt->execute([':email' => $email]);

        if ($stmt->rowCount() == 1) {
            $usuario = $stmt->fetch(PDO::FETCH_OBJ);
            return $usuario->estado_login == 0;
        }
        return false;
    }

 

    public function getPersonIdByEmail($email) {
        $role = $this->getRoleByEmail($email);
        $query = "";
    
        switch ($role) {
            case 'administrador':
                $query = "SELECT personas.id_persona FROM administrador JOIN personas ON administrador.id_persona = personas.id_persona WHERE email = :email";
                break;
            case 'doctor':
                $query = "SELECT personas.id_persona FROM doctor JOIN personas ON doctor.id_persona = personas.id_persona WHERE email = :email";
                break;
            case 'paciente':
                $query = "SELECT personas.id_persona FROM paciente JOIN personas ON paciente.id_persona = personas.id_persona WHERE email = :email";
                break;
        }
    
        if ($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['id_persona'] ?? null;
        }
        return null;
    }
}
?>
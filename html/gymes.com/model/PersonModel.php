<?php

require_once 'BaseModel.php';

class PersonModel extends BaseModel {    

    public function createPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol) {
        $stmt = $this->conn->prepare("INSERT INTO personas (nombre, apellido, email, direccion, telefono, cedula, password, rol) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $this->executeStatement($stmt, [$nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol]);
        return $this->conn->lastInsertId();
    }

    public function getItems($query = '', $page = 1, $records_per_page = 5) {
        $offset = ($page - 1) * $records_per_page;
        $sql = $this->getBaseSelectSQL();

        if (!empty($query)) {
            $sql .= $this->getBaseWhereSQL();
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        if (!empty($query)) {
            $stmt->bindValue(':query', '%'.$query.'%', PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function getBaseSelectSQL() {
        return "SELECT * FROM personas";
    }

    protected function getBaseWhereSQL() {
        return " WHERE nombre LIKE :query OR apellido LIKE :query OR cedula LIKE :query";
    }

    public function getTotalItems() {
        $sql = "SELECT COUNT(*) FROM personas";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPersonDetails($id_persona) {
        $stmt = $this->conn->prepare("SELECT * FROM personas WHERE id_persona = ?");
        if (!$stmt->execute([$id_persona])) {
            return false; // Indicar un error en la ejecución
        }
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePerson($id_persona, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol) {
        $stmt = $this->conn->prepare("UPDATE personas SET nombre = ?, apellido = ?, email = ?, direccion = ?, telefono = ?, cedula = ?, password = ?, rol = ? WHERE id_persona = ?");
        return $this->executeStatement($stmt, [$nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol, $id_persona]);
    }

    public function deletePerson($id_persona) {
        $stmt = $this->conn->prepare("DELETE FROM personas WHERE id_persona = ?");
        return $stmt->execute([$id_persona]);
    }

    public function updatePassword($id_persona, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("UPDATE personas SET password = :password WHERE id_persona = :id");
        return $stmt->execute([':password' => $hashedPassword, ':id' => $id_persona]);
    }

    public function updateLoginStatus($id_persona, $status) {
        $stmt = $this->conn->prepare("UPDATE personas SET estado_login = :status WHERE id_persona = :id");
        return $stmt->execute([':status' => $status, ':id' => $id_persona]);
    }

    public function isEmailTaken($email) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM personas WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetchColumn() > 0; // Si la cuenta es mayor que 0, el correo ya está registrado
    }

    public function getRoleByEmail($email) {
        $stmt = $this->conn->prepare("SELECT rol FROM personas WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $result['rol'] ?? null;
    }

    public function getIdByEmail($email) {
        $role = $this->getRoleByEmail($email);
        $query = "";

        switch ($role) {
            case 'administrador':
                $query = "SELECT id_administrador FROM administrador JOIN personas ON administrador.id_persona = personas.id_persona WHERE email = :email";
                break;
            case 'doctor':
                $query = "SELECT id_doctor FROM doctor JOIN personas ON doctor.id_persona = personas.id_persona WHERE email = :email";
                break;
            case 'paciente':
                $query = "SELECT id_paciente FROM paciente JOIN personas ON paciente.id_persona = personas.id_persona WHERE email = :email";
                break;
        }

        if ($query) {
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
        
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result[array_keys($result)[0]];
        }
        return null;
    }
    
    public function getPersonById($id_persona) {
        
        return $this->getPersonDetails($id_persona);
    }

    public function setEstadoLoginToTrue($userId) {
        $stmt = $this->conn->prepare("UPDATE personas SET estado_login = 1 WHERE id_persona = :id");
        $stmt->execute([':id' => $userId]);
    }    
    

}


<?php

require_once 'PersonModel.php';

class PatientModel extends PersonModel {

    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function getPersonaIdFromPaciente($id_paciente) {
        $stmt = $this->conn->prepare("SELECT id_persona FROM paciente WHERE id_paciente = ?");
        $stmt->execute([$id_paciente]);
        return $stmt->fetchColumn();
    }

    // este es para las citas que agenda el paciente
    public function getPacienteIdFromPersona($id_persona) {
        $stmt = $this->conn->prepare("SELECT id_paciente FROM paciente WHERE id_persona = ?");
        $stmt->execute([$id_persona]);
        return $stmt->fetchColumn();
    }

    public function createPacienteAndPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $fecha_nacimiento, $ocupacion, $rol) {
        try {
            $this->conn->beginTransaction();
    
            $tempPassword = bin2hex(random_bytes(4)); // Genera una contraseña temporal
            $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);
    
            $id_persona = parent::createPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $hashedPassword, $rol);
    
            if (!$id_persona) {
                throw new Exception("Error al crear la persona.");
            }
    
            $stmt = $this->conn->prepare("INSERT INTO paciente (id_persona, fecha_nacimiento, ocupacion) VALUES (?, ?, ?)");
            if (!$this->executeStatement($stmt, [$id_persona, $fecha_nacimiento, $ocupacion])) {
                throw new Exception("Error al crear el paciente.");
            }
    
            $this->conn->commit();
            return $tempPassword;
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function updatePatientPerson($post, $id_persona) {

        // Comprobar si se ha introducido una nueva contraseña
        if (!empty($post['password'])) {
            // Cifrar la nueva contraseña antes de almacenarla en la base de datos
            $hashed_password = password_hash($post['password'], PASSWORD_DEFAULT);
            $password_param = [':password' => $hashed_password];
        } else {
            // Si no hay nueva contraseña, omitir la actualización de este campo
            $password_param = [];
        }
    
        // Actualizar la tabla personas
        $sql = "UPDATE personas 
                SET nombre = :nombre, 
                    apellido = :apellido, 
                    direccion = :direccion, 
                    telefono = :telefono, 
                    cedula = :cedula, 
                    email = :email" . 
                    (!empty($password_param) ? ", password = :password" : "") . 
                " WHERE id_persona = :id_persona";
    
        $stmt = $this->conn->prepare($sql);
    
        $params = [
            ':nombre' => $post['nombre'],
            ':apellido' => $post['apellido'],
            ':direccion' => $post['direccion'],
            ':telefono' => $post['telefono'],
            ':cedula' => $post['cedula'],
            ':email' => $post['email'],
            ':id_persona' => $id_persona
        ];
    
        // Unir los parámetros de la contraseña si es necesario
        if (!empty($password_param)) {
            $params = array_merge($params, $password_param);
        }
    
        if (!$stmt->execute($params)) {
            return false;
        }
    
        // Actualizar la tabla paciente con los campos adicionales
        $stmt2 = $this->conn->prepare("UPDATE paciente 
                                       SET fecha_nacimiento = :fecha_nacimiento, 
                                           ocupacion = :ocupacion 
                                       WHERE id_persona = :id_persona");
    
        $params2 = [
            ':fecha_nacimiento' => $post['fecha_nacimiento'],
            ':ocupacion' => $post['ocupacion'],
            ':id_persona' => $id_persona
        ];
    
        return $stmt2->execute($params2);
    }

    public function registerPaciente($nombre, $apellido, $email, $direccion, $telefono, $cedula, $fecha_nacimiento, $ocupacion, $rol, $password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        parent::createPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $hashed_password, $rol);
        $id_persona = $this->conn->lastInsertId();
        $estado_login = 1;
        $stmt = $this->conn->prepare("INSERT INTO paciente (id_persona, fecha_nacimiento, ocupacion) VALUES (?, ?, ?)");
        $this->executeStatement($stmt, [$id_persona, $fecha_nacimiento, $ocupacion]);
        
        return $id_persona;
    }

    public function getItems($query = '', $page = 1, $records_per_page = 10) {
        $offset = ($page - 1) * $records_per_page;
        $sql = "SELECT * FROM personas INNER JOIN paciente ON personas.id_persona = paciente.id_persona WHERE personas.rol = 'paciente'";

        if (!empty($query)) {
            $sql .= " AND (personas.nombre LIKE :query OR personas.apellido LIKE :query OR personas.cedula LIKE :query)";
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

    public function getTotalItems() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM personas INNER JOIN paciente ON personas.id_persona = paciente.id_persona WHERE personas.rol = 'paciente'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPacienteDetails($id_paciente) {
        $stmt = $this->conn->prepare("SELECT personas.*, paciente.* FROM personas INNER JOIN paciente ON personas.id_persona = paciente.id_persona WHERE paciente.id_paciente = ?;");
        $stmt->execute([$id_paciente]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            throw new Exception("Paciente no encontrado.");
        }
    
        return $result;
    }

    public function getBirthDateAndOccupation($id_persona) {
        // seguro que hay una mejor forma pero estoy BURNED OUT...
        $stmt = $this->conn->prepare("SELECT fecha_nacimiento, ocupacion FROM paciente WHERE id_persona = ?");
        $stmt->execute([$id_persona]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $result ? $result : [];
    }

    public function updatePacienteAndPerson($id_paciente, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol, $fecha_nacimiento, $ocupacion) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $id_persona = $this->getPersonaIdFromPaciente($id_paciente);
        parent::updatePerson($id_persona, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $hashed_password, $rol);
        
        $stmt = $this->conn->prepare("UPDATE paciente SET fecha_nacimiento = ?, ocupacion = ? WHERE id_paciente = ?");
        $this->executeStatement($stmt, [$fecha_nacimiento, $ocupacion, $id_paciente]);
    }

    public function deletePacienteAndPerson($id_paciente) {
        try {
            $this->conn->beginTransaction();
            $id_persona = $this->getPersonaIdFromPaciente($id_paciente);
    
            if (!$id_persona) {
                throw new Exception("Paciente no encontrado");
            }
    
            $stmt = $this->conn->prepare("DELETE FROM paciente WHERE id_paciente = ?");
            if (!$stmt->execute([$id_paciente])) {
                throw new Exception("Error al eliminar el registro del paciente.");
            }
    
            $stmt = $this->conn->prepare("DELETE FROM personas WHERE id_persona = ?");
            if (!$stmt->execute([$id_persona])) {
                throw new Exception("Error al eliminar la persona asociada al paciente.");
            }
    
            $this->conn->commit();
            return true; // Añadir esta línea
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e;
        }
    }

    public function asignarPacienteADoctor($id_paciente, $id_doctor) {
        $stmt = $this->conn->prepare("UPDATE personas SET id_doctor = ? WHERE id_persona = ?");
        return $stmt->execute([$id_doctor, $id_paciente]);
    }
}

?>

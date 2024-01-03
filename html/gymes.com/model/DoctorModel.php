<?php

require_once 'PersonModel.php';

class DoctorModel extends PersonModel {

    private function getPersonaIdFromDoctor($id_doctor) {
        $stmt = $this->conn->prepare("SELECT id_persona FROM doctor WHERE id_doctor = ?");
        $stmt->execute([$id_doctor]);
        return $stmt->fetchColumn();
    }

    public function __construct($conn) {
        parent::__construct($conn);
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id_persona FROM personas WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn();
    }
    
    public function cedulaExists($cedula) {
        $stmt = $this->conn->prepare("SELECT id_persona FROM personas WHERE cedula = ?");
        $stmt->execute([$cedula]);
        return $stmt->fetchColumn();
    }

    public function createDoctorAndPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $rol) {
        try {
            $this->conn->beginTransaction();
    
            $tempPassword = bin2hex(random_bytes(4));  // Genera una contraseña temporal de 8 caracteres
            $hashedPassword = password_hash($tempPassword, PASSWORD_DEFAULT);  // Cifrar la contraseña temporal
    
            // Insertar datos en la tabla de personas
            $stmt = $this->conn->prepare("INSERT INTO personas (nombre, apellido, email, direccion, telefono, cedula, password, rol, estado_login) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
            if (!$this->executeStatement($stmt, [$nombre, $apellido, $email, $direccion, $telefono, $cedula, $hashedPassword, $rol])) {
                throw new Exception("Error al crear la persona.");
            }
            $id_persona = $this->conn->lastInsertId();
    
            // Insertar datos en la tabla de doctor
            $stmt = $this->conn->prepare("INSERT INTO doctor (id_persona) VALUES (?)");
            if (!$this->executeStatement($stmt, [$id_persona])) {
                throw new Exception("Error al crear el doctor.");
            }
    
            $this->conn->commit();
            return $tempPassword;  // Devolver la contraseña temporal para poder enviarla por correo
        } catch (Exception $e) {
            $this->conn->rollBack();
            throw $e; // Relanzar la excepción capturada
        }
    }

    public function getItems($query = '', $page = 1, $records_per_page = 5) {
        return $this->getDoctors($query, $page, $records_per_page);
    }

    public function getTotalItems($query = '') {
        return $this->getTotalDoctors();
    }

    public function getDoctors($query = '', $page = 1, $records_per_page = 5) {
        $offset = ($page - 1) * $records_per_page;
        $sql = "SELECT * FROM personas INNER JOIN doctor ON personas.id_persona = doctor.id_persona";

        if (!empty($query)) {
            $sql .= " WHERE personas.nombre LIKE :query OR personas.apellido LIKE :query OR personas.cedula LIKE :query";
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

    public function getTotalDoctors() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM personas INNER JOIN doctor ON personas.id_persona = doctor.id_persona");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getDoctorDetails($id_doctor) {
        $stmt = $this->conn->prepare("SELECT personas.*, doctor.id_doctor FROM personas INNER JOIN doctor ON personas.id_persona = doctor.id_persona WHERE doctor.id_doctor = ?");
        $stmt->execute([$id_doctor]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //esta funcion es para el boton del lapiz, de editar el perfil del doctor.
    public function updateDoctorAndPerson($id_doctor, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $id_persona = $this->getPersonaIdFromDoctor($id_doctor);
        
        return parent::updatePerson($id_persona, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $hashed_password, $rol);
 
    }
    
    //Esta funcion sirve para que el propio medico sea el que edite su perfil
    public function updateDoctorPerson($post, $id_persona) {

        // Cifrar la contraseña antes de almacenarla en la base de datos
        $hashed_password = password_hash($post['password'], PASSWORD_DEFAULT);

        $stmt = $this->conn->prepare("UPDATE personas SET nombre = :nombre, apellido = :apellido, direccion = :direccion, telefono = :telefono, cedula = :cedula, email = :email, password = :password WHERE id_persona = :id_persona");
    
        // Bind parameters
        $stmt->bindParam(':nombre', $post['nombre']);
        $stmt->bindParam(':apellido', $post['apellido']);
        $stmt->bindParam(':direccion', $post['direccion']);
        $stmt->bindParam(':telefono', $post['telefono']);
        $stmt->bindParam(':cedula', $post['cedula']);
        $stmt->bindParam(':email', $post['email']);
        $stmt->bindParam(':password', $hashed_password); 
        $stmt->bindParam(':id_persona', $id_persona);
    
        return $stmt->execute();
    }


    public function deleteDoctorAndPerson($id_doctor) {
        try {
            $this->conn->beginTransaction();
            $id_persona = $this->getPersonaIdFromDoctor($id_doctor);
    
            if (!$id_persona) {
                $this->conn->rollBack();
                return false; // En lugar de lanzar una excepción
            }
    
            $stmt = $this->conn->prepare("DELETE FROM doctor WHERE id_doctor = ?");
            if (!$stmt->execute([$id_doctor])) {
                $this->conn->rollBack();
                return false; // En lugar de lanzar una excepción
            }
    
            $stmt = $this->conn->prepare("DELETE FROM personas WHERE id_persona = ?");
            if (!$stmt->execute([$id_persona])) {
                $this->conn->rollBack();
                return false; // En lugar de lanzar una excepción
            }
    
            $this->conn->commit();
            return true; // Devolver true en caso de éxito
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false; // Devolver false en caso de error inesperado
        }
    }

}
?>

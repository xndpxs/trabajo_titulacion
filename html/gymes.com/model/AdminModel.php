<?php
require_once 'PersonModel.php';

class AdminModel extends PersonModel {

    public function __construct($conn) {
        parent::__construct($conn);  // Llama al constructor de la clase padre (PersonModel)
    }

    public function updateAdminPerson($post, $id_persona) {

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
}


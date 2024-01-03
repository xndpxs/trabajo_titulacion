<?php
//require '../model/PersonModel.php';
require_once '../model/PatientModel.php';
require_once 'mailController.php';
require_once '../utils/Session.php';

class PasswordResetController {

    
    private $patientModel;

    public function __construct($conn) {
        $this->patientModel = new PatientModel($conn);
    }

    public function resetPassword($email) {
        $session = new Session();
        $session->start();        

        // Generar una nueva contraseña aleatoria
        $newPassword = bin2hex(random_bytes(5)); // Cambia 5 a cualquier otro número para una contraseña de diferente longitud

        // Buscar la ID de la persona por correo electrónico
        $id_paciente = $this->patientModel->getIdByEmail($email);
        $id_persona = $this->patientModel->getPersonaIdFromPaciente($id_paciente);

        //var_dump($id_persona);
        //var_dump($newPassword);
        if ($id_persona) {
            // Actualizar la contraseña
            if ($this->patientModel->updatePassword($id_persona, $newPassword)) {
                // Cambiar el estado_login a 0
                $this->patientModel->updateLoginStatus($id_persona, 0);

                // Enviar la nueva contraseña por correo electrónico
                if (sendMail($email, 'Nueva contraseña', 'Su nueva contraseña es: ' . $newPassword)) {
                    return true;
                } else {
                    // Manejar si el correo no se envía
                    return false;
                }
            }
        } else {
            // El correo no se encuentra en la base de datos
            return false;
        }
    }
}
?>
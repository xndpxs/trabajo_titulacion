<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || $session->get('rol') !== 'paciente') {
    header('Location: ../LoginView.php');
    exit;
}

require '../../model/PatientModel.php';
$patientModel = new PatientModel($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener ID de la persona asociada al paciente
    $id_persona = $session->get('id_persona');

    // Verificacion de contraseñas si se ha proporcionado alguna
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];
    
    // Si se ha introducido alguna contraseña, verificar que coincidan
    if (!empty($password) && $password !== $passwordConfirm) {
        $session->set('error', 'Las contraseñas no coinciden.');
        header('Location: /gymes.com/view/paciente/configPaciente.php');
        exit();
    }

    // Preparar el array de datos sin la contraseña
    $dataToUpdate = $_POST;
    unset($dataToUpdate['password']);
    unset($dataToUpdate['password_confirm']);

    // Si se ha proporcionado una contraseña y coincide con la confirmación, agregarla al array
    if (!empty($password)) {
        $dataToUpdate['password'] = $password; // Aquí se añadirá la contraseña para que se actualice
    }

    // Actualizar información en la base de datos
    $result = $patientModel->updatePatientPerson($dataToUpdate, $id_persona);

    if ($result) {
        $session->set('message', "Información actualizada con éxito!");
    } else {
        $session->set('error', "Hubo un error al actualizar la información.");
    }

    // Redireccionar de vuelta a configPaciente.php
    header('Location: /gymes.com/view/paciente/configPaciente.php');
    exit();
}
?>




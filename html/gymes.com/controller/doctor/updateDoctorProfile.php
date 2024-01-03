<?php
require '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/DoctorModel.php';

// Instanciar el modelo
$doctorModel = new DoctorModel($conn);

// Si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener ID de la persona asociada al doctor
    $id_persona = $_SESSION['id_persona'];

    // Verificacion de contrasenas 
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if ($password !== $passwordConfirm) {
        $session->set('error', 'Las contraseñas no coinciden.');
        header('Location: /gymes.com/view/doctor/configDoctor.php');
        exit();
    }

    // Actualizar información en la base de datos
    $result = $doctorModel->updateDoctorPerson($_POST, $id_persona);
  

    if ($result) {
        $_SESSION['message'] = "Información actualizada con éxito!";
    } else {
        $_SESSION['error'] = "Hubo un error al actualizar la información.";
    }

    // Redireccionar de vuelta a configDoctor.php
    header('Location: /gymes.com/view/doctor/configDoctor.php');
    exit();

} else {
    // Obtener datos actuales del doctor
    $id_persona = $_SESSION['id_persona'];
    $currentDetails = $doctorModel->getPersonById($id_persona);
}

?>







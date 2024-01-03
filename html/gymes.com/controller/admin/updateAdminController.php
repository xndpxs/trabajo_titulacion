<?php
require '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || $session->get('rol') !== 'administrador') {
    header('Location: ../LoginView.php');
    exit;
}

require_once '../../model/AdminModel.php';

// Instanciar el modelo
$adminModel = new AdminModel($conn);

// Si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtener ID de la persona asociada al admin
    $id_persona = $_SESSION['id_persona'];

    // Verificacion de contrasenas 
    $password = $_POST['password'];
    $passwordConfirm = $_POST['password_confirm'];

    if ($password !== $passwordConfirm) {
        $session->set('error', 'Las contraseñas no coinciden.');
        header('Location: /gymes.com/view/admin/configAdmin.php');
        exit();
    }

    // Actualizar información en la base de datos
    $result = $adminModel->updateAdminPerson($_POST, $id_persona);


    if ($result) {
        $_SESSION['message'] = "Información actualizada con éxito!";
    } else {
        $_SESSION['error'] = "Hubo un error al actualizar la información.";
    }

    // Redireccionar de vuelta a configAdmin.php
    header('Location: /gymes.com/view/admin/configAdmin.php');
    exit();
} else {
    // Obtener datos actuales del admin
    $id_persona = $_SESSION['id_persona'];
    $currentDetails = $adminModel->getPersonById($id_persona);
}

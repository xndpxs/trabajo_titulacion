<?php
require '../utils/Session.php';
$session = new Session();
$session->start();

if (!in_array($session->get('rol'), ['paciente', 'administrador', 'doctor'])) {
    header('Location: LoginView.php');
    exit;
}

if ($session->has('errors')) {
    $errorMessage = $session->get('errors');
    $session->remove('errors');
}

//require '../model/PersonModel.php';
require '../model/LoginModel.php';

// Verificamos si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    $loginModel = new LoginModel($conn);
    $personModel = new PersonModel($conn);
    $userId = $session->get('id_persona');

    // Asegurarse de que las contraseñas ingresadas coincidan
    if ($newPassword === $confirmPassword) {
        $updated = $personModel->updatePassword($userId, $newPassword); // Ya no necesitas hashearla aquí

        if ($updated) {
            $personModel->updateLoginStatus($userId, 1);


            $session->set('success-message', 'Contraseña actualizada exitosamente. Por favor, inicie sesión con su nueva contraseña.');
            header("Location: ../view/LoginView.php");
            exit;
        } else {
            $session->set('error-message', 'Error al actualizar la contraseña.');
            header("Location: ../view/firstLoginView.php");
            exit;
        }
    } else {
        $session->set('error-message', 'Las contraseñas no coinciden.');
        header("Location: ../view/firstLoginView.php");
        exit;
    }
}

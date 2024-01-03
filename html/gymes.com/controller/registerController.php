<?php
require '../utils/Session.php';
$session = new Session();
$session->start();

//require '../config/config.php';

require '../model/PatientModel.php';
require '../utils/Request.php';
$request = new Request();

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método de petición inválido.");
    }

        // Añadir verificación CSRF
        $csrf_token = $_POST['csrf_token'] ?? '';
        if (!$session->has('csrf_token') || $csrf_token !== $session->getCsrfToken()) {
            throw new Exception("Error de validación CSRF.");
        }

    if (!verifyRecaptcha($recaptcha_secret, $request)) {
        throw new Exception("El reCAPTCHA es incorrecto.");
    }

    if (!isset($_POST['nombre']) || !isset($_POST['apellido']) || !isset($_POST['email']) || !isset($_POST['direccion']) || !isset($_POST['telefono']) || !isset($_POST['cedula']) || !isset($_POST['fecha_nacimiento']) || !isset($_POST['ocupacion']) || !isset($_POST['password']) || !isset($_POST['repeat_password'])) {
        throw new Exception("No se proporcionaron todos los campos necesarios.");
    }

    $patientModel = new PatientModel($conn);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    // Verificar que las contraseñas coincidan
    if ($_POST['password'] !== $_POST['repeat_password']) {
        throw new Exception("Las contraseñas no coinciden.");
    }

    $password = $_POST['password'];

    if ($patientModel->isEmailTaken($email)) {
        throw new Exception("El correo electrónico ya está registrado.");
    }

    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ocupacion = $_POST['ocupacion'];
    $rol = 'paciente';
    
    // Crear el paciente
    $id_persona = $patientModel->registerPaciente($nombre, $apellido, $email, $direccion, $telefono, $cedula, $fecha_nacimiento, $ocupacion, $rol, $password);
    
    //cambiar estado del login a 1  
    $patientModel->setEstadoLoginToTrue($id_persona);


    $session->set('success_message', 'Paciente agregado con éxito.');
    header('Location: ../view/LoginView.php');  
    exit;

} catch (Exception $e) {
    $session->set('error_message', $e->getMessage());
    header('Location: ../view/registerView.php');  
    exit;
}

// Función de verificación de reCAPTCHA
function verifyRecaptcha($recaptcha_secret, $request) {
    $captchaResponse = $request->post('g-recaptcha-response');
    $response = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$captchaResponse}");

    if (!$response) {
        return false;
    }

    $responseKeys = json_decode($response, true);
    return isset($responseKeys["success"]) && $responseKeys["success"];
}
?>
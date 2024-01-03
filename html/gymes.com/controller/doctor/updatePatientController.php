<?php
require '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}


//require_once("../../config/config.php");
require_once("../../model/PatientModel.php");  // Cambia a tu modelo de Paciente

try {
    // Verifica que todos los datos hayan sido enviados
    if (!isset($_POST['id_paciente'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['direccion'], $_POST['telefono'], $_POST['cedula'], $_POST['password'], $_POST['repeatPassword'], $_POST['fecha_nacimiento'], $_POST['ocupacion'])) {
        throw new Exception("Se necesita más información.");
    }

    $id_paciente = $_POST['id_paciente'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ocupacion = $_POST['ocupacion'];
    $rol = 'paciente';
    // Verifica que las contraseñas coincidan
    if ($password !== $repeatPassword) {
        throw new Exception("Las contraseñas no coinciden.");
    }

    // Encripta la contraseña
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Crea una nueva instancia de la clase PacienteModel
    $pacienteModel = new PatientModel($conn);

    // Actualiza el paciente y la persona correspondiente
    $pacienteModel->updatePacienteAndPerson($id_paciente, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $hashedPassword, $rol, $fecha_nacimiento, $ocupacion);
       
    $response["success"] = true;
    $response["message"] = "Paciente actualizado con éxito.";

} catch (Exception $e) {
    // Establece un código de respuesta HTTP 400 porque la solicitud del cliente no se pudo completar
    http_response_code(400);
    $response["success"] = false;
    $response["message"] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>

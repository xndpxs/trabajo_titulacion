<?php
require '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || $session->get('rol') !== 'administrador') {
    header('Location: ../LoginView.php');
    exit;
}

//require_once("../../config/config.php");
require_once("../../model/DoctorModel.php");

try {
    // Verificamos que todos los datos hayan sido enviados
    if (!isset($_POST['id_doctor'], $_POST['nombre'], $_POST['apellido'], $_POST['email'], $_POST['direccion'], $_POST['telefono'], $_POST['cedula'], $_POST['password'], $_POST['repeatPassword'])) {
        throw new Exception("Se necesita más información.");
    }

    $id_doctor = $_POST['id_doctor'];   
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $rol = 'doctor';

    // Verificamos que las contraseñas coincidan
    if ($password !== $repeatPassword) {
        throw new Exception("Las contraseñas no coinciden.");
    }

    // No necesitamos encriptar la contraseña nuevamente ya que estamos usando el hash existente
    //$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Creamos una nueva instancia de la clase DoctorModel
    $doctorModel = new DoctorModel($conn);

    // Actualizamos el doctor y la persona correspondiente
    $doctorModel->updateDoctorAndPerson($id_doctor, $nombre, $apellido, $email, $direccion, $telefono, $cedula, $password, $rol);  // Usamos $password aquí en lugar de $hashedPassword

    $response["success"] = true;
    $response["message"] = "Doctor actualizado con éxito.";

} catch (Exception $e) {
    // Establecemos un código de respuesta HTTP 400 porque la solicitud del cliente no se pudo completar
    http_response_code(400);
    $response["success"] = false;
    $response["message"] = $e->getMessage();
}

header('Content-Type: application/json');
echo json_encode($response);
?>

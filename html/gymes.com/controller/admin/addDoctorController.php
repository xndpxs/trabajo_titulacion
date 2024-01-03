<?php
require '../../utils/Session.php';
require '../mailController.php';

$session = new Session();
$session->start();

// Comprobamos la sesión y el rol del usuario
if (!$session->has('login_active') || $session->get('rol') !== 'administrador') {
    header('Location: ../../view/LoginView.php');
    exit;
}

//require '../../config/config.php';
require '../../model/DoctorModel.php';

try {
    if (!isset($_POST['nombre']) || !isset($_POST['apellido']) || !isset($_POST['email']) || !isset($_POST['direccion']) || !isset($_POST['telefono']) || !isset($_POST['cedula'])) {
        throw new Exception("No se proporcionaron todos los campos necesarios.");
    }

    $doctorModel = new DoctorModel($conn);

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    // Comprobamos si el correo electrónico ya está en uso
    if($doctorModel->isEmailTaken($email)) {
        throw new Exception("El correo electrónico ya está registrado.");
    }
    
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $rol = 'doctor';

    // Crear el doctor y obtener la contraseña temporal
    $tempPassword = $doctorModel->createDoctorAndPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $rol);
    
    // Enviar un correo con la contraseña temporal
    $to = $email;
    $subject = "Bienvenido/a a nuestro sistema";
    $message = "
    Hola Dr. $nombre $apellido,

    Se te ha registrado en nuestro sistema. Tu contraseña temporal es: $tempPassword
    Por favor, cambia esta contraseña una vez que hayas ingresado al sistema.

    Gracias,
    El equipo de Gymes
    ";

    $sendResult = sendMail($to, $subject, $message);

    if ($sendResult !== true) {
        throw new Exception($sendResult); 
    }

    echo "Doctor agregado con éxito y se ha enviado un correo con la contraseña temporal.";
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
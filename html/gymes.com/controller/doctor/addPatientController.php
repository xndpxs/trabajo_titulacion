<?php
require '../../utils/Session.php';
require '../mailController.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

//require '../../config/config.php';
require '../../model/PatientModel.php';

try {
    if (!isset($_POST['nombre']) || !isset($_POST['apellido']) || !isset($_POST['email']) || !isset($_POST['direccion']) || !isset($_POST['telefono']) || !isset($_POST['cedula']) || !isset($_POST['fecha_nacimiento']) || !isset($_POST['ocupacion'])) {
        throw new Exception("No se proporcionaron todos los campos necesarios.");
    }

    $patientModel = new PatientModel($conn);

 
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $email = $_POST['email'];

    if($patientModel->isEmailTaken($email)) {
        throw new Exception("El correo electrónico ya está registrado.");
    }
    


    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $cedula = $_POST['cedula'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $ocupacion = $_POST['ocupacion'];
    $rol = 'paciente';
    // Crear el paciente y obtener la contraseña temporal
    $tempPassword = $patientModel->createPacienteAndPerson($nombre, $apellido, $email, $direccion, $telefono, $cedula, $fecha_nacimiento, $ocupacion, $rol);
    
    // Enviar un correo con la contraseña temporal
    $to = $email;
    $subject = "Bienvenido/a a nuestro sistema";
    $message = "
    Hola $nombre $apellido,
  
    Se te ha registrado en nuestro sistema. Tu contraseña temporal es: $tempPassword
    Por favor, cambia esta contraseña una vez que hayas ingresado al sistema.
    
    Gracias,
    El equipo de Gymes
    ";

    $sendResult = sendMail($to, $subject, $message); // Usamos sendMail en lugar de mail()

    if ($sendResult !== true) {
        throw new Exception($sendResult); // Si hay un error al enviar el correo, lanzará una excepción.
    }

    echo "Paciente agregado con éxito y se ha enviado un correo con la contraseña temporal.";
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
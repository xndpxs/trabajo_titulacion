<?php
require '../../utils/Session.php';
require '../mailController.php';  // Asegúrate de que esta ruta sea correcta

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['paciente'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require_once '../../model/SesionModel.php';
require_once '../../model/PatientModel.php';
require_once '../../model/DoctorModel.php';  // Incluye el modelo del doctor

$patientModel = new PatientModel($conn);
$id_persona = $_SESSION['id_persona'];
$id_paciente = $patientModel->getPacienteIdFromPersona($id_persona);

// Obtener los detalles del paciente
$pacienteDetails = $patientModel->getPacienteDetails($id_paciente);
$nombre_paciente = $pacienteDetails['nombre'];
$apellido_paciente = $pacienteDetails['apellido'];

$sesionModel = new SesionModel($conn);
$proximaSesion = $sesionModel->obtenerProximaSesion($id_paciente);

$id_doctor = $proximaSesion['id_doctor'];

// Obtener datos del doctor
$doctorModel = new DoctorModel($conn);
$doctorDetails = $doctorModel->getDoctorDetails($id_doctor);
$nombre_doctor = $doctorDetails['nombre'];
$apellido_doctor = $doctorDetails['apellido'];

$fecha = $proximaSesion['fecha'];
$hora = $proximaSesion['tiempo'];  // Cambiado de hora a tiempo según la estructura de la tabla

// Datos del correo
$to = 'gymestest@gmail.com';
$subject = 'Solicitud de Cancelación de Cita';
$message = "El paciente $nombre_paciente $apellido_paciente ha solicitado la cancelación de su cita con el Dr. $nombre_doctor $apellido_doctor el $fecha a las $hora.";

// Envío del correo
$sendResult = sendMail($to, $subject, $message);

if ($sendResult !== true) {
    echo "Error al enviar el correo: $sendResult";
} else {
    echo "Solicitud de cancelación enviada con éxito.";
}
?>

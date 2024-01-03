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

// Comprobar si se proporcionó un id_doctor
if (!isset($_POST['id_doctor'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Se necesita un ID de doctor.']);
    exit;
}

// Obtener el id_doctor
$id_doctor = $_POST['id_doctor'];

// Crear una nueva instancia de DoctorModel
$doctorModel = new DoctorModel($conn);

// Obtener los detalles del doctor
$doctor = $doctorModel->getDoctorDetails($id_doctor);

if (!$doctor) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No se encontró el doctor.']);
    exit;
}

// Enviar los detalles del doctor en formato JSON
header('Content-Type: application/json');
echo json_encode($doctor);
?>

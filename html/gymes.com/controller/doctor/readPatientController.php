<?php
require '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}


//require_once("../../config/config.php"); 
require_once("../../model/PatientModel.php"); // Importamos el modelo correcto

// Comprobar si se proporcionó un id_paciente
if (!isset($_GET['id_paciente'])) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Se necesita un ID de paciente.']);
    exit;
}

// Obtener el id_paciente
$id_paciente = $_GET['id_paciente'];

// Crear una nueva instancia de PatientModel
$patientModel = new PatientModel($conn);

// Obtener los detalles del paciente
$paciente = $patientModel->getPacienteDetails($id_paciente);

if (!$paciente) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No se encontró el paciente.']);
    exit;
}

// Enviar los detalles del paciente en formato JSON
header('Content-Type: application/json');
echo json_encode($paciente);
?>

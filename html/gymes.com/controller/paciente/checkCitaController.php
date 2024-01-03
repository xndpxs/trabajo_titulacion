<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['paciente'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require_once '../../model/PatientModel.php';
require_once '../../model/SesionModel.php';

$patientModel = new PatientModel($conn);
$id_persona = $_SESSION['id_persona'];
$id_paciente = $patientModel->getPacienteIdFromPersona($id_persona);
$sesionModel = new SesionModel($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if ($sesionModel->tieneCitaProgramada($id_paciente)) {
            echo json_encode(['error' => true, 'message' => 'Ya tiene una cita programada', 'type' => 'cita_existente']);
        } else {
            echo json_encode(['error' => false]);
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    exit();
}
?>

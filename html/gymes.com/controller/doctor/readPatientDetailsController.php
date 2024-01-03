<?php
//require_once '../model/PersonasModel.php';
require_once '../../model/PatientModel.php';

$pacienteModel = new PatientModel($conn);

function obtenerDetallesDelPaciente($id_paciente) {
    global $pacienteModel;

    return $pacienteModel->getPacienteDetails($id_paciente);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_paciente'])) {
    header('Content-Type: application/json');
    echo json_encode(obtenerDetallesDelPaciente($_POST['id_paciente']));

}
?>

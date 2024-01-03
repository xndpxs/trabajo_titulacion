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
        $fecha = $_POST['fecha'];
        $hora = $_POST['tiempo'];
        $lugar = $_POST['lugar'];
        $id_doctor = $_POST['id_doctor'];
        $notas = isset($_POST['notas']) ? $_POST['notas'] : "";  // Notas son opcionales

        if (empty($fecha) || empty($hora) || empty($lugar) || empty($id_doctor)) {
            throw new Exception('Por favor complete todos los campos requeridos.');
        }

        if ($sesionModel->existeSesion($fecha, $hora, $id_doctor)) {
            echo "Ya existe una cita a esa hora con ese doctor.";
        } else {
            if ($sesionModel->crearSesion($fecha, $hora, $lugar, $id_paciente, $id_doctor, $notas)) {
                echo "Cita programada con éxito";
            } else {
                echo "Error al programar la cita";
            }
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    exit();
}
?>

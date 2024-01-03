<?php
require '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

//require_once("../../config/config.php");
require_once("../../model/PatientModel.php");

try {
    // Crear una nueva instancia de PatientModel
    $patientModel = new PatientModel($conn);

    // Verificar el método de la solicitud y si se proporcionan IDs
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
        $ids = explode(',', $_POST['ids']);
        foreach ($ids as $id) {
            // Llamamos al método adecuado para eliminar pacientes (a asumir que se llama deletePatientAndPerson, si no, reemplaza el nombre)
            $patientModel->deletePacienteAndPerson(trim($id));
        }
        echo "Paciente(s) eliminado(s) con éxito.";
    } else {
        throw new Exception("Método de solicitud no válido o ID(s) no proporcionado(s).");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
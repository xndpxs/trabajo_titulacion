<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/SesionModel.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $fecha = $_POST['fecha'];
        $hora = $_POST['tiempo']; 
        $lugar = $_POST['lugar'];
        $id_paciente = $_POST['id_paciente'];
        $id_doctor = $_POST['id_doctor'];
        $notas = $_POST['notas'];

        if (empty($fecha) || empty($hora) || empty($lugar) || empty($id_paciente) || empty($id_doctor)) {
            throw new Exception('Por favor complete todos los campos requeridos.');
        }

        $sesionModel = new SesionModel($conn);

        // Verificando la disponibilidad antes de agregar la sesión
        if ($sesionModel->existeSesion($fecha, $hora, $id_doctor)) {
            echo "Ya existe una cita a esa hora con ese doctor.";
        } else {
            if ($sesionModel->crearSesion($fecha, $hora, $lugar, $id_paciente, $id_doctor, $notas)) {
                echo "Sesión agregada con éxito";
            } else {
                echo "Error al agregar la sesión";
            }
        }
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
} else {
    header('Location: index.php');
    exit();
}
?>

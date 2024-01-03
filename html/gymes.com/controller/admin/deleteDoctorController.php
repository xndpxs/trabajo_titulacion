<?php
require_once '../../utils/Session.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || $session->get('rol') !== 'administrador') {
    header('Location: ../LoginView.php');
    exit;
}

require_once("../../model/DoctorModel.php");
require_once("../../model/SesionModel.php");

$session = new Session();
$session->start();

if (!$session->has('login_active') || $session->get('rol') !== 'administrador') {
    header('Location: ../LoginView.php');
    exit;
}

try {
    $doctorModel = new DoctorModel($conn);
    $sesionModel = new SesionModel($conn);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids']) && isset($_POST['nuevo_id_doctor'])) {
        $idDoctors = explode(',', $_POST['ids']);
        $nuevoIdDoctor = trim($_POST['nuevo_id_doctor']);

        foreach ($idDoctors as $idDoctor) {
            // Reasignar las citas del doctor a eliminar al nuevo doctor
            $asignaciones = $sesionModel->getAsignacionesPorDoctor($idDoctor);
            foreach ($asignaciones as $asignacion) {
                $sesionModel->reasignarDoctor($asignacion['id_asignacion'], $nuevoIdDoctor);
            }

            // Eliminar el doctor
            $doctorModel->deleteDoctorAndPerson($idDoctor);
        }

        echo "Doctor eliminado y citas reasignadas con éxito.";
    } else {
        echo "Método de solicitud no válido o parámetros no proporcionados.";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

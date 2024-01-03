<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/DiagnosticoModel.php';

$diagnostico = new DiagnosticoModel($conn);

function agregarDiagnostico($diagnostico) {
    $id_sesion = $_POST['id_sesion'];
    
    // Datos para tratamiento
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
    $area = !empty($_POST['area']) ? $_POST['area'] : null;
    $resultTratamiento = $diagnostico->crearTratamiento($id_sesion, $nombre, $area);

    // Datos para enfermedad
    $tipo = !empty($_POST['tipo']) ? $_POST['tipo'] : null;
    $detalle = !empty($_POST['detalle']) ? $_POST['detalle'] : null;
    $resultEnfermedad = $diagnostico->crearEnfermedad($id_sesion, $tipo, $detalle);

    if ($resultTratamiento === true && $resultEnfermedad === true) {
        echo json_encode(["status" => "success", "message" => "Diagnóstico agregado exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo agregar el diagnóstico."]);
    }
}

agregarDiagnostico($diagnostico);
?>

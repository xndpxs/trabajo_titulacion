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

function actualizarTratamiento($diagnostico) {
    $id_sesion = $_POST['id_sesion'];
    
    $nombre = !empty($_POST['nombre']) ? $_POST['nombre'] : null;
    $area = !empty($_POST['area']) ? $_POST['area'] : null;

    $tipo = !empty($_POST['tipo']) ? $_POST['tipo'] : null;
    $detalle = !empty($_POST['detalle']) ? $_POST['detalle'] : null;

    $resultTratamiento = $diagnostico->updateTratamiento($id_sesion, $nombre, $area);
    $resultEnfermedad = $diagnostico->updateEnfermedad($id_sesion, $tipo, $detalle);

    if ($resultTratamiento && $resultEnfermedad) {
        echo json_encode(["status" => "success", "message" => "Tratamiento y enfermedad actualizados exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar el diagnóstico."]);
    }
}

actualizarTratamiento($diagnostico);
?>

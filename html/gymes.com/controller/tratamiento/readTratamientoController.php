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
$id_sesion = $_GET['id_sesion'];

$resultTratamiento = $diagnostico->leerTratamiento($id_sesion);
$resultEnfermedad = $diagnostico->leerEnfermedad($id_sesion);

if ($resultTratamiento && $resultEnfermedad) {
    echo json_encode(["tratamiento" => $resultTratamiento, "enfermedad" => $resultEnfermedad]);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo obtener el diagnóstico."]);
}
?>

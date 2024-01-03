<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/DatosMedicosModel.php';

$datosMedicos = new DatosMedicosModel($conn);
$id_sesion = $_GET['id_sesion'];

$result = $datosMedicos->leerDatosMedicos($id_sesion);

if ($result) {
    echo json_encode($result);
} else {
    echo json_encode(["status" => "error", "message" => "No se pudo obtener datos médicos."]);
}
?>

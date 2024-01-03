<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/AlimentacionModel.php';

$alimentacionModel = new AlimentacionModel($conn);

function actualizarAlimentacion($alimentacionModel) {
    $id_sesion = $_POST['id_sesion'];
    
    $desayuno = !empty($_POST['desayuno']) ? $_POST['desayuno'] : null;
    $almuerzo = !empty($_POST['almuerzo']) ? $_POST['almuerzo'] : null;
    $merienda = !empty($_POST['merienda']) ? $_POST['merienda'] : null;
    $extra = !empty($_POST['extra']) ? $_POST['extra'] : null;
    $observaciones = !empty($_POST['observaciones']) ? $_POST['observaciones'] : null;
    $recomendada = !empty($_POST['recomendada']) ? $_POST['recomendada'] : null;
    
    $result = $alimentacionModel->updateAlimentacion($id_sesion, $desayuno, $almuerzo, $merienda, $extra, $observaciones, $recomendada);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Datos de alimentación actualizados exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar datos de alimentación."]);
    }
}

actualizarAlimentacion($alimentacionModel);
?>

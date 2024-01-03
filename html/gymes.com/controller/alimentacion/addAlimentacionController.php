<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/AlimentacionModel.php';

$alimentacion = new AlimentacionModel($conn);

function agregarAlimentacion($alimentacion) {
    $id_sesion = $_POST['id_sesion'];
    
    $desayuno = !empty($_POST['desayuno']) ? $_POST['desayuno'] : null;
    $almuerzo = !empty($_POST['almuerzo']) ? $_POST['almuerzo'] : null;
    $merienda = !empty($_POST['merienda']) ? $_POST['merienda'] : null;
    $extra = !empty($_POST['extra']) ? $_POST['extra'] : null;
    $observaciones = !empty($_POST['observaciones']) ? $_POST['observaciones'] : null;
    $recomendada = !empty($_POST['recomendada']) ? $_POST['recomendada'] : null;
    
    $result = $alimentacion->crearAlimentacion($id_sesion, $desayuno, $almuerzo, $merienda, $extra, $observaciones, $recomendada);

    if ($result === true) {
        echo json_encode(["status" => "success", "message" => "Datos de alimentación agregados exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => $result]);
    }
}

agregarAlimentacion($alimentacion);
?>

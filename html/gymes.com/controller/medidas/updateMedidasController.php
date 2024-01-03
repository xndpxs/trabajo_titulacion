<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/MedidasModel.php';

$medidas = new MedidasModel($conn);

function actualizarMedidas($medidas) {
    $id_sesion = $_POST['id_sesion'];

    $torax = (!empty($_POST['torax'])) ? $_POST['torax'] : null;
    $axilas = (!empty($_POST['axilas'])) ? $_POST['axilas'] : null;
    $busto = (!empty($_POST['busto'])) ? $_POST['busto'] : null;
    $brazo_der = (!empty($_POST['brazo_der'])) ? $_POST['brazo_der'] : null;
    $brazo_izq = (!empty($_POST['brazo_izq'])) ? $_POST['brazo_izq'] : null;
    $abd_alto = (!empty($_POST['abd_alto'])) ? $_POST['abd_alto'] : null;
    $abd_bajo = (!empty($_POST['abd_bajo'])) ? $_POST['abd_bajo'] : null;
    $cintura = (!empty($_POST['cintura'])) ? $_POST['cintura'] : null;
    $cadera = (!empty($_POST['cadera'])) ? $_POST['cadera'] : null;
    $gluteos = (!empty($_POST['gluteos'])) ? $_POST['gluteos'] : null;
    $muslo_der = (!empty($_POST['muslo_der'])) ? $_POST['muslo_der'] : null;
    $muslo_izq = (!empty($_POST['muslo_izq'])) ? $_POST['muslo_izq'] : null;
    $rodilla_der = (!empty($_POST['rodilla_der'])) ? $_POST['rodilla_der'] : null;
    $rodilla_izq = (!empty($_POST['rodilla_izq'])) ? $_POST['rodilla_izq'] : null;

    $result = $medidas->updateMedidas($id_sesion, $torax, $axilas, $busto, $brazo_der, $brazo_izq, $abd_alto, $abd_bajo, $cintura, $cadera, $gluteos, $muslo_der, $muslo_izq, $rodilla_der, $rodilla_izq);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Medidas actualizadas exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar las medidas."]);
    }
}

actualizarMedidas($medidas);
?>

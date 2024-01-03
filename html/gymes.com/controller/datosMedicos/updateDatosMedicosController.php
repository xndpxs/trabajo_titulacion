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

function actualizarDatosMedicos($datosMedicos) {
    $id_sesion = $_POST['id_sesion'];
    
    $talla = !empty($_POST['talla']) ? $_POST['talla'] : null;
    $peso = !empty($_POST['peso']) ? $_POST['peso'] : null;
    $ta = !empty($_POST['ta']) ? $_POST['ta'] : null;
    $pulso = !empty($_POST['pulso']) ? $_POST['pulso'] : null;
    $fr = !empty($_POST['fr']) ? $_POST['fr'] : null;
    $medicamentos = !empty($_POST['medicamentos']) ? $_POST['medicamentos'] : null;
    

    $result = $datosMedicos->updateDatosMedicos($id_sesion, $talla, $peso, $ta, $pulso, $fr, $medicamentos);

    if ($result) {
        echo json_encode(["status" => "success", "message" => "Datos médicos actualizados exitosamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "No se pudo actualizar datos médicos."]);
    }
}

actualizarDatosMedicos($datosMedicos);

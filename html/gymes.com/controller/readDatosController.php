<?php
require_once '../model/SesionModel.php';  
require_once '../model/AlimentacionModel.php';
require_once '../model/DatosMedicosModel.php';
require_once '../model/MedidasModel.php';
require_once '../model/DiagnosticoModel.php';

$alimentacionModel = new AlimentacionModel($conn);
$datosMedicosModel = new DatosMedicosModel($conn);
$medidasModel = new MedidasModel($conn);
$diagnosticoModel = new DiagnosticoModel($conn);
$sesionModel = new SesionModel($conn);

function obtenerTodosLosDatos($id_sesion) {
    global $alimentacionModel, $datosMedicosModel, $medidasModel, $diagnosticoModel, $sesionModel;

    $resultados = [];

    $resultados['sesion'] = $sesionModel->leerSesion($id_sesion);
    $resultados['alimentacion'] = $alimentacionModel->leerAlimentacion($id_sesion);
    $resultados['datosMedicos'] = $datosMedicosModel->leerDatosMedicos($id_sesion);
    $resultados['medidas'] = $medidasModel->leerMedidas($id_sesion);
    $resultados['tratamiento'] = $diagnosticoModel->leerTratamiento($id_sesion);
    $resultados['enfermedad'] = $diagnosticoModel->leerEnfermedad($id_sesion);

    return $resultados;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_sesion'])) {
    header('Content-Type: application/json');
    echo json_encode(obtenerTodosLosDatos($_POST['id_sesion']));
}
?>
<?php
require '../../utils/Session.php';
require_once '../../model/SesionModel.php';

$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('HTTP/1.1 403 Forbidden');
    echo json_encode(['error' => 'Acceso no autorizado']);
    exit;
}

// Verifica si la solicitud es de tipo GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    //echo '<pre>';
    //print_r($_GET);
    //echo '</pre>';

    $sesionModel = new SesionModel($conn); // Asegúrate de que $conn sea una instancia válida de PDO

    $filtros = [
        'cedulaPaciente' => $_GET['cedulaPaciente'] ?? '',
        'cedulaDoctor' => $_GET['cedulaDoctor'] ?? '',
        'estado' => isset($_GET['estado']) && is_array($_GET['estado']) ? $_GET['estado'] : (isset($_GET['estado']) ? [$_GET['estado']] : []),
        'fecha' => $_GET['fecha'] ?? '',
        'hora' => $_GET['hora'] ?? '',
        'nombrePaciente' => $_GET['nombrePaciente'] ?? '',
        'apellidoPaciente' => $_GET['apellidoPaciente'] ?? '',
        'nombreDoctor' => $_GET['nombreDoctor'] ?? '',
        'apellidoDoctor' => $_GET['apellidoDoctor'] ?? ''
    ];

    $start = isset($_GET['start']) ? (int)$_GET['start'] : 0;
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 20;

    try {
        //echo 'Filtros aplicados: ';
        //print_r($filtros);
              
        $resultados = $sesionModel->getSesiones($filtros, $start, $limit);
        echo json_encode($resultados);
    } catch (Exception $e) {
        header('HTTP/1.1 500 Internal Server Error');
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    header('HTTP/1.1 405 Method Not Allowed');
    echo json_encode(['error' => 'Método no permitido']);
    exit;
}
?>

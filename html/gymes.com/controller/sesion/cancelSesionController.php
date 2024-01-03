<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

require '../../model/SesionModel.php';

$sesionModel = new SesionModel($conn);

try {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ids'])) {
        $ids = explode(',', $_POST['ids']);
        foreach ($ids as $id) {
            
            $sesionModel->cancelarSesion(trim($id));

        }
        echo "Sesión(es) cancelada(s) con éxito.";
    } else {
        throw new Exception("Método de solicitud no válido o ID(s) no proporcionado(s).");
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>

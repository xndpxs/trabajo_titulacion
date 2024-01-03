<?php
require '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

class SesionController {
    private $sesionModel;

    public function __construct($sesionModel) {
        $this->sesionModel = $sesionModel;
    }

    public function getSesiones($searchQuery, $start, $limit) {
        return $this->sesionModel->getSesiones($searchQuery, $start, $limit);
    }
}
?>

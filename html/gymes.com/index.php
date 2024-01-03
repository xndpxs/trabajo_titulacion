<?php
ob_start();
include_once 'view/includes/header.php';
ob_end_flush();
?>

  <main>
    <div class="container py-5 text-center">
      <img class="mb-4" src="<?$_SERVER['DOCUMENT_ROOT']?>assets/images/gymes_logo.png" alt="Logotipo de la Clínica de Fisioterapia" width="150" height="150">
      <h1 class="display-4 fw-bold">GYMES</h1>
      <p class="lead">Somos un centro con fines terapéuticos, mantenemos la salud, favoreciendo la restauración del individuo.</p>
      <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
        <a href="view/LoginView.php"><button type="button" class="btn btn-primary btn-lg px-4 gap-3">Iniciar Sesión</button></a>
        <a href="view/registerView.php"><button type="button" class="btn btn-outline-secondary btn-lg px-4">Registrarse</button></a>
      </div>
    </div>
  </main>

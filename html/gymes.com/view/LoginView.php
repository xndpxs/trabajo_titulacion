<?php
ob_start();
include_once '../utils/Session.php';
$session = new Session();
$session->start();

include_once 'includes/header.php';

ob_end_flush();
?>

<main class="container py-5 text-center">
    <form action="../controller/SessionController.php?action=login" method="post">
      <img class="mb-4 mx-auto" src="../assets/images/gymes_logo.png" alt="" width="150" height="150">
      <h1 class="h3 mb-3 fw-bold">Iniciar Sesión</h1>

      <div class="form-floating col-12 col-lg-4 mx-auto">
        <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
        <label for="floatingInput">Dirección de E-mail</label>
      </div>
      <div class="form-floating col-12 col-lg-4 mx-auto">
        <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Contraseña</label>
      </div>


      <!-- recaptcha -->
      <div class="d-flex justify-content-center my-4">
        <div class="g-recaptcha mb-1" data-sitekey="6Lcx0DUnAAAAAFZIisDLdCVpWcs3NQlqP-S-nx4a"></div>
      </div>

      <button name="login" class="btn btn-primary btn-lg px-4 gap-3" type="submit">Ingresar</button>
      <a href="registerView.php"><button type="button" class="btn btn-secondary btn-lg  gap-3">Registrarse</button></a>

      <div class="text-right my-3">    
          <a href="passwordResetView.php"  class="text-left my-3">Olvidé mi contraseña</a>          
      </div>

      <!-- Bloque de código PHP para mostrar el mensaje de error -->
      <?php if (isset($errorMessage)) : ?>
        <div id="error-message" class="text-danger mt-2">
          <?php echo $errorMessage; ?>
        </div>
      <?php endif; ?>
      
      <!-- Bloque de código PHP para mostrar el mensaje de exito -->
      <?php if ($session->has('success_message')) : ?>
        <div id="success-message" class="text-success mt-2">
          <?php echo $session->get('success_message'); ?>
          <?php $session->remove('success_message'); ?>
        </div>
      <?php endif; ?>

    <!--CSRF TOKEN-->
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($session->getCsrfToken()); ?>">

    </form>
  </main>


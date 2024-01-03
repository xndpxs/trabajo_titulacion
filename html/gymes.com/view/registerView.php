<?php
ob_start();
include_once '../utils/Session.php';
$session = new Session();
$session->start();

if ($session->has('error_message')) {
    $errorMessage = $session->get('error_message');
    $session->remove('error_message');
}
include_once './includes/header.php';
ob_end_flush();
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2 form-container">
            <h3 class="mb-3">Registrar Paciente</h3>
            <form action="../controller/registerController.php" method="POST">
                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Apellido</label>
                    <input type="text" id="apellido" name="apellido" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>                
                <div class="form-group">
                    <label>Direccion</label>
                    <input type="text" id="direccion" name="direccion" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Telefono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Cédula</label>
                    <input type="text" id="cedula" name="cedula" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Ocupación</label>
                    <input type="text" id="ocupacion" name="ocupacion" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Repita Contraseña</label>
                    <input type="password" id="repeat_password" name="repeat_password" class="form-control" required>
                </div>
                      <!-- recaptcha -->
                <div class="d-flex justify-content-center my-4">
                    <div class="g-recaptcha mb-1" data-sitekey="6Lcx0DUnAAAAAFZIisDLdCVpWcs3NQlqP-S-nx4a"></div>
                </div>

                <!-- Bloque de código PHP para mostrar el mensaje de error -->
                <?php if (isset($errorMessage)) : ?>
                    <div id="error-message" class="text-danger mt-2">
                    <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>   

                <div class="d-flex justify-content-center my-4">
                    <input type="submit" class="btn btn-success" value="Registrar">
                    <a href="../index.php" class="btn btn-default">Cancelar</a>
                </div>

                <!--CSRF TOKEN-->
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($session->getCsrfToken()); ?>">    
            </form>
        </div>
    </div>
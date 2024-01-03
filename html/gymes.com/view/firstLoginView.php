<?php
ob_start();
include_once '../utils/Session.php';
$session = new Session();
$session->start();

if (!in_array($session->get('rol'), ['paciente','administrador','doctor'])) {
    header('Location: LoginView.php');
    exit;
}
include_once 'includes/header.php';
ob_end_flush();
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center">
                    <h4>Primer inicio de sesión</h4>
                </div>
                <div class="card-body">
                    <p class="lead">
                        ¡Bienvenido/a! Parece que es tu primera vez iniciando sesión en nuestra plataforma. Ingresa la contraseña que te enviamos por correo y luego actualiza a una nueva contraseña.
                    </p>
                    <form action="../controller/firstLoginController.php" method="post">
                        <div class="form-group">
                            <label for="password">Nueva contraseña:</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar contraseña:</label>
                            <input type="password" class="form-control" name="confirm_password" required>
                        </div>
                        <!-- Aquí puedes agregar más campos si los necesitas -->

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                            <div class="form-group text-center mt-2">
                                <a href="/gymes.com/controller/SessionController.php?action=logout" class="btn btn-danger">Cerrar Sesión</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
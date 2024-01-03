<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();

// Asegúrate de que solo los doctores puedan acceder
if (!$session->has('login_active') || $session->get('rol') !== 'doctor') {
    header('Location: ../LoginView.php');
    exit;
}

include_once '../includes/header.php';
include_once '../../model/DoctorModel.php';

$doctorModel = new DoctorModel($conn);
$id_persona = $session->get('id_persona');
$currentDetails = $doctorModel->getPersonDetails($id_persona);

if (!$currentDetails) {
    die('Error al obtener los detalles del doctor.');
}


ob_end_flush();
?>

<div class="container mt-5">
    <h2 class="text-center">Configuración de perfil del doctor</h2>

    <!-- Mostrar los mensajes de alerta aquí -->
        <?php 
            if ($session->has('message')) {
                echo '<div class="alert alert-success text-center">' . $session->get('message') . '</div>';
                $session->remove('message');
            }

            if ($session->has('error')) {
                echo '<div class="alert alert-danger text-center">' . $session->get('error') . '</div>';
                $session->remove('error');
            }
        ?>

    <div class="row mt-4">
        <div class="col form-container">
            <form action="/gymes.com/controller/doctor/updateDoctorProfile.php" method="post">
                <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $currentDetails['nombre']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="apellido" class="form-label">Apellido</label>
                        <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $currentDetails['apellido']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $currentDetails['email']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $currentDetails['direccion']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $currentDetails['telefono']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="tel" class="form-control" id="cedula" name="cedula" value="<?php echo $currentDetails['cedula']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                        <input type="password" class="form-control" id="passwordConfirm" name="password_confirm">
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


                            <div class="d-flex justify-content-around">
                                <a href="/gymes.com/controller/SessionController.php?action=logout" class="btn btn-danger">Cerrar Sesión</a>
                                <a href="/gymes.com/view/doctor/dashboard.php" class="btn btn-outline-secondary">Regresar</a>                                
                                <button type="submit" class="btn btn-primary">Actualizar</button> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                            
 </div>

<script src="../../assets/js/doctor/checkPasswordDoctor.js"></script>

</body>
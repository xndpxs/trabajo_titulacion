<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();
if (!$session->has('login_active') || !in_array($session->get('rol'), ['paciente'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}

include_once '../../view/includes/header.php';
include_once 'modalCitaExistente.php';
ob_end_flush();

?>
<title>Panel de Control</title>

<div class="container mt-5">
    <h1 class="text-center mb-4">Panel de Control</h1>

    <div class="row"> <!-- Contenedor Flexbox -->
        <div class="col-sm-6">
            <!-- Tarjeta de Gestión de citas -->
            <div class="card text-center">
                <div class="d-flex justify-content-left">
                    <i class="fas fa fa-user-md" style=" color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
                </div>                
                <div class="card-body">
                    <h5 class="card-title">Gestión de citas</h5>
                    <p class="card-text">Agregar o eliminar citas.</p>
                    <a href="javascript:void(0);" class="btn btn-primary" id="btnGestion">Ir a Gestión</a>
                </div>
            </div>
        </div>    

            <!-- Tarjeta de Configuración de Perfil -->
        <div class="col-sm-6">    
            <div class="card text-center">
                <div class="d-flex justify-content-left">
                    <i class="fas fa fa fa-cog" style=" color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
                </div>                
                
                <div class="card-body">
                    <h5 class="card-title">Configuración de Perfil</h5>
                    <p class="card-text">Cambiar los datos de la cuenta.</p>
                    <a href="configPaciente.php" class="btn btn-primary">Configurar Perfil</a>
                </div>
            </div>
        </div>
    </div> 

        <div class="text-center mt-4"> <!-- Centrar el botón de cerrar sesión -->
            <form action="/gymes.com/controller/SessionController.php?action=logout" method="post">
                <button type="submit" name="logout" class="btn btn-danger">Cerrar Sesión</button>
            </form>
        </div>
</div>


<script src="../../assets/js/paciente/comprobarCitaExistente.js"></script>
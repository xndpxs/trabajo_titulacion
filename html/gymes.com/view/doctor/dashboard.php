<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();
$session->set('return_url', '/gymes.com/view/doctor/dashboard.php');
if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}
include_once '../includes/header.php';

ob_end_flush();
?>
<title>Panel de Control</title>

<div class="container mt-5">
    <h1 class="text-center mb-4">Panel de Control</h1>

    <div class="row"> <!-- Contenedor Flexbox -->
        <!-- Tarjeta de Gestión de pacientes -->
        <div class="col-sm-6">            
            <div class="card text-center">
                <div class="d-flex justify-content-left">
                    <i class="fas fa fa-user-md" style=" color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
                </div>                
                <div class="card-body">
                    <h5 class="card-title">Gestión de pacientes</h5>
                    <p class="card-text">Agregar, editar o eliminar pacientes.</p>
                    <a href="gestionPacientesView.php" class="btn btn-primary">Ir a Gestión</a>
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
                    <a href="configDoctor.php" class="btn btn-primary">Configurar Perfil</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Tarjeta de Configuración de Citas -->
        <div class="col-sm-6">    
            <div class="card text-center">
                <div class="d-flex justify-content-left">
                    <i class="fas fa fa fa-calendar" style=" color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
                </div>                
                
                <div class="card-body">
                    <h5 class="card-title">Administración de Citas</h5>
                    <p class="card-text">Agendar, modificar y cancelar citas para tus pacientes.</p>
                    <a href="../sesion/gestionSesionesView.php" class="btn btn-primary">Administrador de Citas</a>
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


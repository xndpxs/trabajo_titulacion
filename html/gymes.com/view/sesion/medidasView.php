<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
  header('Location: ../../view/LoginView.php');
  exit;
}

$sesionId = $_GET['sesionId'];

include_once '../includes/header.php';

//modals

include_once '../medidas/modals/datosMedicosModal.php';
include_once '../medidas/modals/medidasModal.php';
include_once '../medidas/modals/tratamientoModal.php';
include_once '../medidas/modals/alimentacionModal.php';
ob_end_flush();
?>

<div class="container">
  <h1 class="text-center mb-4">Seguimiento de Medidas</h1>
  <div class="row">
    <!-- Primera fila -->
    <!-- Card 1 -->
    <div class="col-md-6">
      <div class="card text-center">
        <div class="d-flex justify-content-left">
          <i class="fas fa-notes-medical" style="color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title">Datos Médicos</h5>
          <p class="card-text">Administrar y visualizar datos médicos de los pacientes.</p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#datosMedicosModal" data-sesion-id="<?php echo $sesionId; ?>">
            Tomar Datos Medicos
          </button>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-6">
      <div class="card text-center">
        <div class="d-flex justify-content-left">
          <i class="fas fa-ruler" style="color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title">Medidas</h5>
          <p class="card-text">Registrar y monitorear las medidas de los pacientes.</p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#medidasModal" data-sesion-id="<?php echo $sesionId; ?>">
            Tomar Medidas
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <!-- Segunda fila -->
    <!-- Card 3 -->
    <div class="col-md-6">
      <div class="card text-center">
        <div class="d-flex justify-content-left">
          <i class="fas fa-diagnoses" style="color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title">Diagnóstico y Tratamiento</h5>
          <p class="card-text">Gestionar diagnósticos y tratamientos de los pacientes.</p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tratamientoModal" data-sesion-id="<?php echo $sesionId; ?>">
            Diagnóstico y Tratamiento
          </button>
        </div>
      </div>
    </div>

    <!-- Card 4 -->
    <div class="col-md-6">
      <div class="card text-center">
        <div class="d-flex justify-content-left">
          <i class="fas fa-utensils" style="color: #0066cc; font-size: 30px; margin-top: 1%; margin-left: 1%;"></i>
        </div>
        <div class="card-body">
          <h5 class="card-title">Alimentación</h5>
          <p class="card-text">Administrar planes de alimentación para los pacientes.</p>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#alimentacionModal" data-sesion-id="<?php echo $sesionId; ?>">
            Ir a Alimentación
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="logout-buttons float-end">
    <a href="/gymes.com/view/sesion/gestionSesionesView.php" class="btn btn-outline-secondary mr-2">Regresar</a>
    <a href="/gymes.com/controller/SessionController.php?action=logout" class="btn btn-danger">Cerrar sesión</a>
  </div>
</div>


<script src="../../assets/js/medidas/addDatosMedicos.js"></script>
<script src="../../assets/js/medidas/addMedidas.js"></script>
<script src="../../assets/js/medidas/addTratamiento.js"></script>
<script src="../../assets/js/medidas/addAlimentacion.js"></script>
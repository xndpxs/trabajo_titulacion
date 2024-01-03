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
include_once '../../model/SesionModel.php';
//include_once '../../model/PatientModel.php';


$sesionModel = new SesionModel($conn);
$pacientes = $sesionModel->getPacientes();
$doctores = $sesionModel->getDoctores();

echo "
    <script>
        var pacientes = " . json_encode($pacientes) . ";
        var doctores = " . json_encode($doctores) . ";
    </script>
";


?>

<body>

<div class="container mt-5 form-container">

<h2>Programar Cita</h2>


<form id="agendarCitaForm" method="POST">
    <div class="mb-3">
              <label for="fecha" class="form-label">Fecha</label>
              <input type="date" class="form-control" id="fecha" required min="<?php echo date('Y-m-d'); ?>">
    </div>



          <div class="form-group">
              <label for="tiempo">Hora</label>
              <select class="form-select" id="tiempo">
                  <option value="08:00">08:00</option>
                  <option value="09:00">09:00</option>
                  <option value="10:00">10:00</option>
                  <option value="11:00">11:00</option>
                  <option value="12:00">12:00</option>
                  <option value="13:00">13:00</option>
                  <option value="14:00">14:00</option>
                  <option value="15:00">15:00</option>
                  <option value="16:00">16:00</option>
              </select>
          </div>




          <div class="mb-3">
            <label for="lugar" class="form-label">Lugar</label>
            <input type="text" class="form-control" id="lugar" name="lugar" value="Conocoto" required>
          </div>


          <div class="mb-3">
            <label for="doctor" class="form-label">Doctor</label>
            <select class="form-control" id="doctor" name="id_doctor" required>
                <!-- Los options se llenarán dinámicamente con JavaScript -->
            </select>
          </div>

    <!-- Botón para enviar el formulario -->
    <div class="d-flex justify-content-around">
        <button type="submit" class="btn btn-primary">Programar Cita</button>
        <a href="/gymes.com/view/paciente/dashboard.php" class="btn btn-outline-secondary">Regresar</a>
        <a href="/gymes.com/controller/SessionController.php?action=logout" class="btn btn-danger">Cerrar Sesión</a>
    </div>
</form>

</div>

<!-- Incluyendo jQuery y Bootstrap JS -->

</body>

<script src="../../assets/js/paciente/addSesionPaciente.js"></script>
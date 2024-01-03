<?php include '../includes/header.php'; ?>

<!-- Modal para mostrar los datos del paciente -->
<div class="modal fade" id="pacienteModal" tabindex="-1" aria-labelledby="pacienteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg para hacerlo más grande -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pacienteModalLabel">Datos del Paciente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row">
            <!-- Datos Personales -->
            <div class="col-md-6">
              <h6>Datos Personales</h6>
              <label>Nombre:</label> <span id="profile_nombre"></span><br>
              <label>Apellido:</label> <span id="profile_apellido"></span><br>
              <label>Cédula:</label> <span id="profile_cedula"></span><br>
              <label>Email:</label> <span id="profile_email"></span><br>
              <label>Fecha de Nacimiento:</label> <span id="profile_fecha_nacimiento"></span><br>
              <label>Fecha de Creación:</label> <span id="profile_fecha_creacion"></span>
              <label>Dirección:</label> <span id="profile_direccion"></span><br>
              <label>Teléfono:</label> <span id="profile_telefono"></span><br>
              <label>Ocupación:</label> <span id="profile_ocupacion"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
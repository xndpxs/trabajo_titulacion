<?php include '../includes/header.php'; ?>

<!-- Modal para mostrar los datos del doctor -->
<div class="modal fade" id="doctorModal" tabindex="-1" aria-labelledby="doctorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg para hacerlo más grande -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="doctorModalLabel">Datos del Doctor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="container">
          <div class="row gutters-sm"> <!-- Se añade la clase gutters-sm para los márgenes -->
            <!-- Icono del doctor -->
            <div class="col-md-4 mb-3">
              <div class="card card-datos shadow-none"> <!-- Se añaden las clases card y card-datos para el estilo -->
                <div class="card-body card-body-datos text-center"> <!-- Se añaden las clases card-body y card-body-datos para el estilo -->
                  <!-- Usar un icono representativo como el de un doctor -->
                  <i class="fas fa-user-md fa-10x"></i>
                </div>
              </div>
            </div>
            <!-- Tarjeta de los datos personales -->
            <div class="col-md-8">
              <div class="card card-datos shadow-none mb-3"> <!-- Se añaden las clases card y card-datos para el estilo -->
                <div class="card-body card-body-datos"> <!-- Se añaden las clases card-body y card-body-datos para el estilo -->
                  <h6 class="mb-0" style="font-size: 1.25em;">Datos Personales</h6> <!-- Se aumenta ligeramente el tamaño de la letra -->
                  <div class="row mb-3"> <!-- Se añade mb-3 para un margen inferior consistente -->
                    <div class="col-sm-12">
                      <label>Nombre:</label>
                      <span id="doctor_nombre" class="text-secondary"></span><br>
                    </div>
                    <div class="col-sm-12">
                      <label>Apellido:</label>
                      <span id="doctor_apellido" class="text-secondary"></span><br>
                    </div>
                    <div class="col-sm-12">
                      <label>Cédula:</label>
                      <span id="doctor_cedula" class="text-secondary"></span><br>
                    </div>
                    <div class="col-sm-12">
                      <label>Email:</label>
                      <span id="doctor_email" class="text-secondary"></span><br>
                    </div>
                    <div class="col-sm-12">
                      <label>Fecha de Creación:</label>
                      <span id="doctor_fecha_creacion" class="text-secondary"></span>
                    </div>
                  </div>
                </div>
              </div>
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
<!-- Modal -->
<div class="modal fade" id="tratamientoModal" tabindex="-1" aria-labelledby="tratamientoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tratamientoModalLabel">Ingreso de Diagnóstico y Tratamiento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="tratamientoForm">

          <!-- Sección de Diagnóstico -->
          <div class="mb-4">
            <h6>Diagnóstico</h6>
            <div class="mb-3 row">
              <label for="tipo" class="col-sm-2 col-form-label">Tipo</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="tipo" name="tipo">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="detalle" class="col-sm-2 col-form-label">Detalle</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="detalle" name="detalle">
              </div>
            </div>
          </div>

          <!-- Sección de Tratamiento -->
          <div class="mb-4">
            <h6>Tratamiento</h6>
            <div class="mb-3 row">
              <label for="nombre" class="col-sm-2 col-form-label">Nombre</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="nombre" name="nombre">
              </div>
            </div>
            <div class="mb-3 row">
              <label for="area" class="col-sm-2 col-form-label">Área</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="area" name="area">
              </div>
            </div>
          </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarTratamiento">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
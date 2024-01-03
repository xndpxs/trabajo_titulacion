<!-- Modal -->
<div class="modal fade" id="alimentacionModal" tabindex="-1" aria-labelledby="alimentacionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="alimentacionModalLabel">Ingreso de Datos de Alimentación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="alimentacionForm">
          <div class="mb-3 row">
            <label for="desayuno" class="col-sm-2 col-form-label">Desayuno</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="desayuno" name="desayuno">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="almuerzo" class="col-sm-2 col-form-label">Almuerzo</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="almuerzo" name="almuerzo">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="merienda" class="col-sm-2 col-form-label">Merienda</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="merienda" name="merienda">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="extra" class="col-sm-2 col-form-label">Extra</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="extra" name="extra">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="observaciones" class="col-sm-2 col-form-label">Observaciones</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="observaciones" name="observaciones">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="recomendada" class="col-sm-2 col-form-label">Recomendada</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="recomendada" name="recomendada">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarAlimentacion">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

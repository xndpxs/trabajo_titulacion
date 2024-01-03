<!-- Modal -->
<div class="modal fade" id="datosMedicosModal" tabindex="-1" aria-labelledby="datosMedicosModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="datosMedicosModalLabel">Ingreso de Datos Médicos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="datosMedicosForm">
          <div class="mb-3 row">
            <label for="talla" class="col-sm-2 col-form-label">Talla</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="talla" name="talla">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="peso" class="col-sm-2 col-form-label">Peso</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="peso" name="peso">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="ta" class="col-sm-2 col-form-label">TA</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="ta" name="ta">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="pulso" class="col-sm-2 col-form-label">Pulso</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="pulso" name="pulso">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="fr" class="col-sm-2 col-form-label">FR</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="fr" name="fr">
            </div>
          </div>
          <div class="mb-3 row">
            <label for="medicamentos" class="col-sm-2 col-form-label">Medicamentos</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="medicamentos" name="medicamentos">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarDatosMedicos">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>

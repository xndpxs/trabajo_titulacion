<!-- Modal para Medidas -->
<div class="modal fade" id="medidasModal" tabindex="-1" aria-labelledby="medidasModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="medidasModalLabel">Ingreso de Medidas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="medidasForm">
          <div class="row">
            <!-- Columna Izquierda -->
            <div class="col-sm-6">
              <div class="mb-3 row">
                <label for="torax" class="col-sm-4 col-form-label">Tórax</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="torax" name="torax">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="axilas" class="col-sm-4 col-form-label">Axilas</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="axilas" name="axilas">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="busto" class="col-sm-4 col-form-label">Busto</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="busto" name="busto">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="brazo_der" class="col-sm-4 col-form-label">Brazo Derecho</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="brazo_der" name="brazo_der">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="brazo_izq" class="col-sm-4 col-form-label">Brazo Izquierdo</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="brazo_izq" name="brazo_izq">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="abd_alto" class="col-sm-4 col-form-label">Abdomen Alto</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="abd_alto" name="abd_alto">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="abd_bajo" class="col-sm-4 col-form-label">Abdomen Bajo</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="abd_bajo" name="abd_bajo">
                </div>
              </div>
            </div>

            <!-- Columna Derecha -->
            <div class="col-sm-6">

              <div class="mb-3 row">
                <label for="cintura" class="col-sm-4 col-form-label">Cintura</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="cintura" name="cintura">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="cadera" class="col-sm-4 col-form-label">Cadera</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="cadera" name="cadera">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="gluteos" class="col-sm-4 col-form-label">Glúteos</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="gluteos" name="gluteos">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="muslo_der" class="col-sm-4 col-form-label">Muslo Derecho</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="muslo_der" name="muslo_der">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="muslo_izq" class="col-sm-4 col-form-label">Muslo Izquierdo</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="muslo_izq" name="muslo_izq">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="rodilla_der" class="col-sm-4 col-form-label">Rodilla Derecha</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="rodilla_der" name="rodilla_der">
                </div>
              </div>
              <div class="mb-3 row">
                <label for="rodilla_izq" class="col-sm-4 col-form-label">Rodilla Izquierda</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="rodilla_izq" name="rodilla_izq">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" id="guardarMedidas">Guardar Cambios</button>
      </div>
    </div>
  </div>
</div>
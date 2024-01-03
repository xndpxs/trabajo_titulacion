<!-- Modal -->
<div class="modal fade" id="createSesionModal" tabindex="-1" aria-labelledby="agregarSesionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarSesionModalLabel">Agregar Nueva Sesión</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="agregarSesionForm">


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


            
            <div class="mb-3">
                <label for="paciente" class="form-label">Paciente</label>
                <select class="form-control" id="paciente" name="id_paciente" required>
                    <!-- Los options se llenarán dinámicamente con JavaScript -->
                </select>
            </div>
            
          <div class="mb-3">
            <label for="notas" class="form-label">Notas</label>
            <textarea class="form-control" id="notas"></textarea>
          </div>
          <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary">Agregar Sesión</button>
          </div>
        </form>
      </div>
    

    </div>
  </div>
</div>



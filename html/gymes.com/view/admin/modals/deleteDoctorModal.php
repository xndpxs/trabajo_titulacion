<?php include '../includes/header.php'; ?>

<!-- El modal para eliminar un doctor -->
<div id="deleteDoctorModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eliminar Doctor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Antes del borrado, ingrese el nuevo doctor para la reasignación de citas previas:</p>
                <div class="mb-3">
                    <label for="doctor" class="form-label">Doctor</label>
                    <select class="form-control" id="doctor" name="id_doctor" required>
                        <!-- Los options se llenarán dinámicamente con JavaScript -->
                    </select>
                </div>
                <p>¿Estás seguro de que deseas eliminar este doctor?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <form id="deleteDoctorForm">
                    <input type="submit" class="btn btn-danger" value="Eliminar">
                </form>
            </div>
        </div>
    </div>
</div>
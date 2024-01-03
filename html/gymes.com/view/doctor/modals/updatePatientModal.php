<?php include '../includes/header.php'; ?>

<!-- Edit Patient Modal -->
<div id="updatePatientModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Actualizar Paciente</h4>
					<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
				</div>
				<div class="modal-body">						
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" id="update_nombre" name="update_nombre" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" id="update_apellido" name="update_apellido" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Email</label>
						<input type="email" id="update_email" name="update_email" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Direccion</label>
						<input type="text" id="update_direccion" name="update_direccion" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Telefono</label>
						<input type="text" id="update_telefono" name="update_telefono" class="form-control" required>
					</div>
					<div class="form-group">
						<label>Cédula</label>
						<input type="text" id="update_cedula" name="update_cedula" class="form-control" required>
					</div>
					<input type="hidden" id="update_password" name="update_password">
					<input type="hidden" id="update_password" name="update_repeatPassword">
                    <!-- Campo para fecha de nacimiento -->
					<div class="form-group">
						<label>Fecha de Nacimiento</label>
						<input type="date" id="update_fecha_nacimiento" name="update_fecha_nacimiento" class="form-control">
					</div>
                    <!-- Campo para ocupación -->
					<div class="form-group">
						<label>Ocupación</label>
						<input type="text" id="update_ocupacion" name="update_ocupacion" class="form-control">
					</div>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancelar">
					<input type="submit" class="btn btn-info" value="Guardar">
				</div>
			</form>
		</div>
	</div>
</div>
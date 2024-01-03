<?php include '../includes/header.php'; ?>

<!-- Agregar nuevo doctor modal -->
<div id="addDoctorModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Agregar Doctor</h4>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
					</div>
					<div class="modal-body">						
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" id="nombre" name="nombre" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Apellido</label>
							<input type="text" id="apellido" name="apellido" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" id="email" name="email" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Direccion</label>
							<input type="text" id="direccion" name="direccion" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Telefono</label>
							<input type="text" id="telefono" name="telefono" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Cédula</label>
							<input type="text" id="cedula" name="cedula" class="form-control" required>
						</div>						
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cancelar">
						<input type="submit" class="btn btn-success" value="Agregar">
					</div>
				</form>
			</div>
		</div>
	</div>


<?php include '../includes/header.php'; ?>

<!-- Read Doctor Modal -->
<div id="readDoctorModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<form>
					<div class="modal-header">						
						<h4 class="modal-title">Visualizar Doctor</h4>
						<button type="button" class="close" data-bs-dismiss="modal" aria-hidden="true">&times;</button>
					</div>
					<div class="modal-body">						
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" id="read_nombre" name="read_nombre" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Apellido</label>
							<input type="text" id="read_apellido" name="read_apellido" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" id="read_email" name="read_email" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Dirección</label>
							<input type="text" id="read_direccion" name="read_direccion"  class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Teléfono</label>
							<input type="text" id="read_telefono" name="read_telefono" class="form-control" readonly>
						</div>
						<div class="form-group">
							<label>Cédula</label>
							<input type="text" id="read_cedula" name="read_cedula" class="form-control" readonly>
						</div>
					</div>
					<div class="modal-footer">
						<input type="button" class="btn btn-default" data-bs-dismiss="modal" value="Cerrar">
					</div>
				</form>
			</div>
		</div>
	</div>
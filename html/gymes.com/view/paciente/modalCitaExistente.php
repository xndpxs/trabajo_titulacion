<?php
require '../../view/includes/header.php';
?>

<div class="modal fade" id="citaExistenteModal" tabindex="-1" aria-labelledby="citaExistenteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="citaExistenteModalLabel">Notificación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Ya tienes una cita programada.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Pedir cancelación de cita</button>
                <a href="/gymes.com/view/paciente/dashboard.php" class="btn btn-primary">Regresar</a>
                
            </div>
        </div>
    </div>
</div>

<script src="../../assets/js/paciente/solicitudCancelacionCita.js"></script>
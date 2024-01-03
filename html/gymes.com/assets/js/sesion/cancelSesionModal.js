$(document).ready(function(){
    // Cuando se abre el modal para cancelar una sesión
    $('#cancelSesionModal').on('show.bs.modal', function(e) {
        var selected = getSelectedSessions();

        if (selected.length === 0) {
            e.preventDefault();
            alert('No se ha seleccionado sesión para borrar');
        }
    });

    // Cuando se envía el formulario para cancelar una sesión
    $('#cancelSesionForm').on('submit', function(e){
        e.preventDefault();
    
        var puedeCancelar = true;
        $('input[name="sesiones[]"]:checked').each(function() {
            var estadoSesion = $(this).closest('tr').find('td').eq(7).text(); // Asumiendo que el estado está en la octava columna
            if (estadoSesion.trim() === 'pasado') {
                puedeCancelar = false;
            }
        });
    
        if (!puedeCancelar) {
            alert('No puedes cancelar sesiones que ya han pasado.');
            return;
        }

        var idsTocancel = getSelectedSessions();

        if (idsTocancel.length > 0) {
            $.ajax({
                type: "POST",
                url: "/gymes.com/controller/sesion/cancelSesionController.php",
                data: {
                    ids: idsTocancel.join(',')
                },
                success: function(data){
                    $('#cancelSesionModal').modal('hide');
                    location.reload();
                },
                error: function(){
                    alert('Hubo un error al cancelar la sesión');
                }
            });
        } else {
            alert('No se ha seleccionado sesión para cancelar');
        }
    });
});

function getSelectedSessions() {
    var selected = [];
    $('input[name="sesiones[]"]:checked').each(function() {
        selected.push($(this).val());
    });
    return selected;
}
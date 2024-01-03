$(document).ready(function(){
    // Cuando se abre el modal para eliminar un paciente
    $('#deletePatientModal').on('show.bs.modal', function(e) {
        // Verifica si hay pacientes seleccionados
        var selected = getSelectedPatients();

        // Si no hay ninguno seleccionado, evitamos que se abra el modal
        if (selected.length === 0) {
            e.preventDefault();
            alert('No se ha seleccionado paciente para borrar');
        }
    });

    // Cuando se envía el formulario para eliminar un paciente
    $('#deletePatientForm').on('submit', function(e){
        e.preventDefault();

        // Obtenemos los IDs de los pacientes a eliminar directamente
        var idsToDelete = getSelectedPatients();

        // Si hay algún paciente seleccionado, enviamos una petición AJAX para eliminarlo
        if (idsToDelete.length > 0) {
            $.ajax({
                type: "POST",
                url: "/gymes.com/controller/doctor/deletePatientController.php",
                data: {
                    ids: idsToDelete.join(',')
                },
                success: function(data){
                    // Si la petición es exitosa, cerramos el modal y recargamos la página
                    $('#deletePatientModal').modal('hide');
                    location.reload();
                },
                error: function(){
                    // Si hay un error, mostramos un mensaje de error
                    alert('Hubo un error al borrar al paciente');
                }
            });
        } else {
            alert('No se ha seleccionado paciente para borrar');
        }
    });
});

function getSelectedPatients() {
    var selected = [];
    $('input[name="options[]"]:checked').each(function() {
        selected.push($(this).val());
    });
    return selected;
}
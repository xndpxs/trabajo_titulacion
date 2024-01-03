$(document).ready(function(){
    $(document).on('click', '.delete', function(e) {
        e.preventDefault();

        var id = $(this).data('id');
        var confirmation = confirm("¿Estás seguro de que deseas eliminar este paciente?");

        if (confirmation) {
            $.ajax({
                url: "/gymes.com/controller/doctor/deletePatientController.php",
                method: 'POST',
                data: { ids: id },
                success: function(response) {
                    alert('Paciente eliminado con éxito');
                    location.reload();
                },
                error: function(error) {
                    alert('Ha ocurrido un error al eliminar el paciente');
                }
            });
        }
    });
});
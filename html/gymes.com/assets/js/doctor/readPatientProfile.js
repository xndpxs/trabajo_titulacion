$(document).ready(function() {

    $(".btnModalPaciente, .btnModalDatos").click(function() {
        var id_paciente = $(this).data('id');

        $.ajax({
            url: '/gymes.com/controller/doctor/readPatientDetailsController.php', 
            method: 'POST',
            data: {
                id_paciente: id_paciente
            },
            dataType: 'json',
            success: function(data) {
                console.log("Este es JSON de readpatientprofile: ", data);
                
                // Datos Personales
                $('#profile_nombre').html(data.nombre);
                $('#profile_apellido').html(data.apellido);
                $('#profile_cedula').html(data.cedula);
                $('#profile_email').html(data.email);
                $('#profile_fecha_nacimiento').html(data.fecha_nacimiento);
                $('#profile_fecha_creacion').html(data.fecha_creacion);                
                $('#profile_direccion').html(data.direccion);
                $('#profile_telefono').html(data.telefono);
                $('#profile_ocupacion').html(data.ocupacion);
                // Mostrar el modal
                $('#pacienteModal').modal('show');                
            },  
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error al obtener datos: ", textStatus, errorThrown);
            }
        });
    });
});

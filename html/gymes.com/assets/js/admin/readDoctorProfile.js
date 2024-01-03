$(document).ready(function() {

    $(".btnModalDoctor").click(function() {
        var id_doctor = $(this).data('id');

        $.ajax({
            url: '/gymes.com/controller/admin/readDoctorController.php', 
            method: 'POST',
            data: {
                id_doctor: id_doctor
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                
                // Datos Personales
                $('#doctor_nombre').html(data.nombre);
                $('#doctor_apellido').html(data.apellido);
                $('#doctor_cedula').html(data.cedula);
                $('#doctor_email').html(data.email);
                $('#doctor_fecha_nacimiento').html(data.fecha_nacimiento);
                $('#doctor_fecha_creacion').html(data.fecha_creacion);

                // Mostrar el modal
                $('#doctorModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error al obtener datos: ", textStatus, errorThrown);
            }
        });
    });
});

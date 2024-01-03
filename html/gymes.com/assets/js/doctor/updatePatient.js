$(document).ready(function () {
    let currentPacienteId = null;

    $(".update").click(function () {
        currentPacienteId = $(this).data('id'); 
        console.log("ID Paciente seleccionado: ", currentPacienteId);
        fetchPacienteDetails(currentPacienteId);
        $('#updatePatientModal').modal('show');
    });

    $("#updatePatientModal form").on('submit', function (e) {
        e.preventDefault();
        const formData = gatherFormData(currentPacienteId);
        
        if (isValid(formData)) {
            updatePaciente(formData);
        }
    });
});

function gatherFormData(id) {
    return {
        id_paciente: id,
        nombre: $('#update_nombre').val(),
        apellido: $('#update_apellido').val(),
        email: $('#update_email').val(),
        direccion: $('#update_direccion').val(),
        telefono: $('#update_telefono').val(),
        cedula: $('#update_cedula').val(),
        password: $('#update_password').val(),
        repeatPassword: $('#update_password').val(),
        fecha_nacimiento: $('#update_fecha_nacimiento').val(),
        ocupacion: $('#update_ocupacion').val()
    };
}

function fetchPacienteDetails(id_paciente) {
    $.get('/gymes.com/controller/doctor/readPatientController.php', { id_paciente }, function (data) {
        console.log("Datos recibidos para el paciente ID: ", id_paciente);
        console.log(data);
        fillPacienteForm(data);
    });
}

function fillPacienteForm(paciente) {
    $("#update_nombre").val(paciente.nombre);
    $("#update_apellido").val(paciente.apellido);
    $("#update_email").val(paciente.email);
    $("#update_direccion").val(paciente.direccion);
    $("#update_telefono").val(paciente.telefono);
    $("#update_cedula").val(paciente.cedula);
    $("#update_password").val(paciente.password);
    $("#update_repeatPassword").val(paciente.repeatPassword);
    $("#update_fecha_nacimiento").val(paciente.fecha_nacimiento);
    $("#update_ocupacion").val(paciente.ocupacion);
}

function isValid(data) {
    for (let key in data) {
        if (data[key] === "") {
            alert('Complete todos los campos');
            return false;
        }
    }
    if (data.password !== data.repeatPassword) {
        alert('Contraseñas no coinciden');
        return false;
    }
    return true;
}

function updatePaciente(data) {
    $.ajax({
        type: "POST",
        url: "/gymes.com/controller/doctor/updatePatientController.php",
        data: data,
        dataType: 'json',
        success: function (response) {
            if(response.success) {
                $('#updatePatientModal').modal('hide');
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("Respuesta del servidor: ", jqXHR.responseText);
            alert('Error al actualizar paciente');
        }
    });
}

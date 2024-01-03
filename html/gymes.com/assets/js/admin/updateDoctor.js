$(document).ready(function () {
    let currentDoctorId = null;

    $(".update").click(function () {
        currentDoctorId = $(this).data('id'); 
        console.log("ID Doctor seleccionado: ", currentDoctorId);
        fetchDoctorDetails(currentDoctorId);
        $('#updateDoctorModal').modal('show');
    });

    $("#updateDoctorModal form").on('submit', function (e) {
        e.preventDefault();
        const formData = gatherFormData(currentDoctorId);
        
        if (isValid(formData)) {
            updateDoctor(formData);
        }
    });
});

function gatherFormData(id) {
    return {
        id_doctor: id,
        nombre: $('#update_nombre').val(),
        apellido: $('#update_apellido').val(),
        email: $('#update_email').val(),
        direccion: $('#update_direccion').val(),
        telefono: $('#update_telefono').val(),
        cedula: $('#update_cedula').val(),
        password: $('#update_password').val(),
        repeatPassword: $('#update_password').val()
    };
}

function fetchDoctorDetails(id_doctor) {
    $.ajax({
        url: '/gymes.com/controller/admin/readDoctorController.php',
        method: 'POST',
        data: { id_doctor: id_doctor },
        success: function(data) {
            console.log("ID Paso el id?: ", id_doctor);
            fillDoctorForm(data);
        },
        error: function(error) {
            console.error("Error al obtener detalles del doctor: ", error);
        }
    });
}

function fillDoctorForm(doctor) {
    $("#update_nombre").val(doctor.nombre);
    $("#update_apellido").val(doctor.apellido);
    $("#update_email").val(doctor.email);
    $("#update_direccion").val(doctor.direccion);
    $("#update_telefono").val(doctor.telefono);
    $("#update_cedula").val(doctor.cedula);
    $("#update_password").val(doctor.password);
    $("#update_repeatPassword").val(doctor.repeatPassword);
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

function updateDoctor(data) {
    console.log(data);
    $.ajax({
        type: "POST",
        url: "/gymes.com/controller/admin/updateDoctorController.php",
        data: data,
        dataType: 'json',
        success: function (response) {
            if(response.success) {
                $('#updateDoctorModal').modal('hide');
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function () {
            alert('Error al actualizar doctor');
        }
    });
}
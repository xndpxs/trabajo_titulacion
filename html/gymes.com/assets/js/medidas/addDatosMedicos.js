$(document).ready(function() {
    var sesionId = $("[data-sesion-id]").data("sesion-id");

    var datosMedicosExisten = false; // Por defecto, asumimos que no existen
    console.log("ID de sesión:", sesionId);
    // Obtén datos previos
    $.ajax({
        url: '/gymes.com/controller/datosMedicos/readDatosMedicosController.php',
        type: 'GET',
        data: { id_sesion: sesionId },
        success: function(response) {
            try {
                var datosPrevios = JSON.parse(response);
                if(datosPrevios && datosPrevios.id_sesion) {
                    datosMedicosExisten = true;  // Aquí detectamos que sí existen
                    for(var campo in datosPrevios) {
                        $('#' + campo).val(datosPrevios[campo]);
                    }
                }
            } catch (e) {
                console.error("Error al parsear la respuesta JSON:", e);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });

    $('#guardarDatosMedicos').click(function(e) {
        e.preventDefault();
    
        var datosMedicosForm = $('#datosMedicosForm');
        var sesionId = $("[data-sesion-id]").data("sesion-id");
    
        var urlController = datosMedicosExisten 
            ? '/gymes.com/controller/datosMedicos/updateDatosMedicosController.php' 
            : '/gymes.com/controller/datosMedicos/addDatosMedicosController.php';
    
        $.ajax({
            url: urlController,
            type: 'POST',
            data: datosMedicosForm.serialize() + "&id_sesion=" + sesionId,
            success: function(response) {
                console.log("esta es la respuesta: ", response);
                try {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        alert(result.message);
                    } else {
                        alert(result.message);
                    }
                } catch (e) {
                    console.error("Error al parsear la respuesta JSON:", e);
                }
                $('#datosMedicosModal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                alert("Hubo un error al enviar los datos. Por favor intenta nuevamente.");
            }
        });
    });
});
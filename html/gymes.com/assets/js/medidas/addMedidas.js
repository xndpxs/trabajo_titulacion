$(document).ready(function() {
    var sesionId = $("[data-sesion-id]").data("sesion-id");

    var medidasExisten = false; // Por defecto, asumimos que no existen
    console.log("ID de sesión:", sesionId);
    // Obtén datos previos
    $.ajax({
        url: '/gymes.com/controller/medidas/readMedidasController.php',
        type: 'GET',
        data: { id_sesion: sesionId },
        success: function(response) {
            try {
                var datosPrevios = JSON.parse(response);
                if(datosPrevios && datosPrevios.id_sesion) {
                    medidasExisten = true;  // Aquí detectamos que sí existen
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

    $('#guardarMedidas').click(function(e) {
        e.preventDefault();
    
        var medidasForm = $('#medidasForm');
        var sesionId = $("[data-sesion-id]").data("sesion-id");
    
        var urlController = medidasExisten 
            ? '/gymes.com/controller/medidas/updateMedidasController.php' 
            : '/gymes.com/controller/medidas/addMedidasController.php';
    
        $.ajax({
            url: urlController,
            type: 'POST',
            data: medidasForm.serialize() + "&id_sesion=" + sesionId,
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
                $('#medidasModal').modal('hide');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                alert("Hubo un error al enviar los datos. Por favor intenta nuevamente.");
            }
        });
    });
});
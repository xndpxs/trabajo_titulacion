$(document).ready(function() {
    var sesionId = $("[data-sesion-id]").data("sesion-id");
    console.log("ID de sesión:", sesionId);

    // Obtén datos previos
    $.ajax({
        url: '/gymes.com/controller/tratamiento/readTratamientoController.php',
        type: 'GET',
        data: { id_sesion: sesionId },
        success: function(response) {
            try {
                var datosPrevios = JSON.parse(response);
                var tratamientoDiagnosticoExisten = datosPrevios && datosPrevios.tratamiento && datosPrevios.enfermedad; // Asume que existen si ambos, tratamiento y enfermedad, están presentes

                // Rellenar el formulario con datos previos si existen
                if (tratamientoDiagnosticoExisten) {
                    for (var campo in datosPrevios.tratamiento) {
                        $('#' + campo).val(datosPrevios.tratamiento[campo]);
                    }
                    for (var campo in datosPrevios.enfermedad) {
                        $('#' + campo).val(datosPrevios.enfermedad[campo]);
                    }
                }

                // Evento click para guardar tratamiento
                $('#guardarTratamiento').click(function(e) {
                    e.preventDefault();
                    var tratamientoDiagnosticoForm = $('#tratamientoForm');
                    var urlController = tratamientoDiagnosticoExisten 
                        ? '/gymes.com/controller/tratamiento/updateTratamientoController.php' 
                        : '/gymes.com/controller/tratamiento/addTratamientoController.php';

                    $.ajax({
                        url: urlController,
                        type: 'POST',
                        data: tratamientoDiagnosticoForm.serialize() + "&id_sesion=" + sesionId,
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
                            $('#tratamientoModal').modal('hide');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
                            alert("Hubo un error al enviar los datos. Por favor intenta nuevamente.");
                        }
                    });
                });
            } catch (e) {
                console.error("Error al parsear la respuesta JSON:", e);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        }
    });
});

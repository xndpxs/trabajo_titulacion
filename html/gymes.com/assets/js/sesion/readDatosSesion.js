$(document).ready(function() {

    function limpiarCampos() {
        $('#nota, #talla, #peso, #ta, #pulso, #fr, #medicamentos, #nombre, #area, #enfermedad_tipo, #enfermedad_detalle, #torax, #axilas, #busto, #brazo_der, #brazo_izq, #abd_alto, #abd_bajo, #cintura, #cadera, #gluteos, #muslo_der, #muslo_izq, #rodilla_der, #rodilla_izq, #desayuno, #almuerzo, #merienda, #extra, #observaciones, #recomendada').html('');
    }

    $("body").on('click', '.btnModalDatos', function() {
        var id_sesion = $(this).data('id');
        console.log("ID de sesión:", id_sesion);
        
        $.ajax({
            url: '/gymes.com/controller/readDatosController.php',
            method: 'POST',
            data: {
                id_sesion: id_sesion
            },
            dataType: 'json',
            success: function(data) {
                limpiarCampos();
                console.log(data.sesion.notas);
                //Notas de la sesion
                $('#nota').html(data.sesion.notas);

                // Datos Médicos
                $('#talla').html(data.datosMedicos.talla);
                $('#peso').html(data.datosMedicos.peso);
                $('#ta').html(data.datosMedicos.ta);
                $('#pulso').html(data.datosMedicos.pulso);
                $('#fr').html(data.datosMedicos.fr);
                $('#medicamentos').html(data.datosMedicos.medicamentos);

                // Medidas
                $('#torax').html(data.medidas.torax);
                $('#axilas').html(data.medidas.axilas);
                $('#busto').html(data.medidas.busto);
                $('#brazo_der').html(data.medidas.brazo_der);
                $('#brazo_izq').html(data.medidas.brazo_izq);
                $('#abd_alto').html(data.medidas.abd_alto);
                $('#abd_bajo').html(data.medidas.abd_bajo);
                $('#cintura').html(data.medidas.cintura);
                $('#cadera').html(data.medidas.cadera);
                $('#gluteos').html(data.medidas.gluteos);
                $('#muslo_der').html(data.medidas.muslo_der);
                $('#muslo_izq').html(data.medidas.muslo_izq);
                $('#rodilla_der').html(data.medidas.rodilla_der);
                $('#rodilla_izq').html(data.medidas.rodilla_izq);

                // Diagnóstico y Tratamiento
                $('#nombre').html(data.tratamiento.nombre);
                $('#area').html(data.tratamiento.area);
                $('#enfermedad_tipo').html(data.enfermedad.tipo);
                $('#enfermedad_detalle').html(data.enfermedad.detalle);

                // Alimentación
                $('#desayuno').html(data.alimentacion.desayuno);
                $('#almuerzo').html(data.alimentacion.almuerzo);
                $('#merienda').html(data.alimentacion.merienda);
                $('#extra').html(data.alimentacion.extra);
                $('#observaciones').html(data.alimentacion.observaciones);
                $('#recomendada').html(data.alimentacion.recomendada);

                // Mostrar el modal
                $('#datosModal').modal('show');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error("Error al obtener datos: ", textStatus, errorThrown);
            }
        });

    });
});
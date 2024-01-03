$(document).ready(function () {
  function limpiarCampos() {
    // Limpia todos los campos del modal
    // Aquí van todos los campos que necesitas limpiar
    // #profile_nombre, #profile_apellido, #profile_cedula, #profile_email, #profile_fecha_nacimiento, #profile_fecha_creacion, #profile_telefono, #profile_ocupacion, #nota,
    $(
      "#talla, #peso, #ta, #pulso, #fr, #medicamentos, #nombre, #area, #enfermedad_tipo, #enfermedad_detalle, #torax, #axilas, #busto, #brazo_der, #brazo_izq, #abd_alto, #abd_bajo, #cintura, #cadera, #gluteos, #muslo_der, #muslo_izq, #rodilla_der, #rodilla_izq, #desayuno, #almuerzo, #merienda, #extra, #observaciones, #recomendada"
    ).html("");
  }

  $(document).on("click", ".btnModalDatos", function () {
    var idPaciente = $(this).data("id-paciente");
    var idSesion = $(this).data("id-sesion");
    console.log("Imprimir id_paciente: ", idPaciente);
    console.log("Imprimir id_sesion: ", idSesion);

    limpiarCampos();

    // Si hay un ID de paciente, carga los datos del paciente
    if (idPaciente) {
      cargarDatosPaciente(idPaciente);
    }

    // Si hay un ID de sesión, carga los datos de la sesión
    if (idSesion) {
      cargarDatosSesion(idSesion);
    }

    // Mostrar el modal
    $("#datosModal").modal("show");
  });

  function cargarDatosPaciente(idPaciente) {
    $.ajax({
      url: "/gymes.com/controller/doctor/readPatientDetailsController.php",
      method: "POST",
      data: {
        id_paciente: idPaciente,
      },
      dataType: "json",
      success: function (data) {
        console.log(data);

        // Datos Personales
        $("#profile_nombre").html(data.nombre);
        $("#profile_apellido").html(data.apellido);
        $("#profile_cedula").html(data.cedula);
        $("#profile_email").html(data.email);
        $("#profile_fecha_nacimiento").html(data.fecha_nacimiento);
        $("#profile_fecha_creacion").html(data.fecha_creacion);
        $("#profile_direccion").html(data.direccion);
        $("#profile_telefono").html(data.telefono);
        $("#profile_ocupacion").html(data.ocupacion);
        //$("#profile_ocupacion").html(data.ocupacion);

        //$('#datosModal').modal('show');
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error al obtener datos: ", textStatus, errorThrown);
      },
    });
  }

  function cargarDatosSesion(idSesion) {
    console.log("Imprimir id_sesion dentro de cargarDatosSesion:", idSesion);
    $.ajax({
      url: "/gymes.com/controller/readDatosController.php",
      method: "POST",
      data: {
        id_sesion: idSesion,
      },
      dataType: "json",
      success: function (data) {
        limpiarCampos();
        console.log("Estas son las notas: ",data.sesion.notas);
        //Notas de la sesion
        $("#nota").html(data.sesion.notas);

        // Datos Médicos
        $("#talla").html(data.datosMedicos.talla);
        $("#peso").html(data.datosMedicos.peso);
        $("#ta").html(data.datosMedicos.ta);
        $("#pulso").html(data.datosMedicos.pulso);
        $("#fr").html(data.datosMedicos.fr);
        $("#medicamentos").html(data.datosMedicos.medicamentos);

        // Medidas
        $("#torax").html(data.medidas.torax);
        $("#axilas").html(data.medidas.axilas);
        $("#busto").html(data.medidas.busto);
        $("#brazo_der").html(data.medidas.brazo_der);
        $("#brazo_izq").html(data.medidas.brazo_izq);
        $("#abd_alto").html(data.medidas.abd_alto);
        $("#abd_bajo").html(data.medidas.abd_bajo);
        $("#cintura").html(data.medidas.cintura);
        $("#cadera").html(data.medidas.cadera);
        $("#gluteos").html(data.medidas.gluteos);
        $("#muslo_der").html(data.medidas.muslo_der);
        $("#muslo_izq").html(data.medidas.muslo_izq);
        $("#rodilla_der").html(data.medidas.rodilla_der);
        $("#rodilla_izq").html(data.medidas.rodilla_izq);

        // Diagnóstico y Tratamiento
        $("#nombre").html(data.tratamiento.nombre);
        $("#area").html(data.tratamiento.area);
        $("#enfermedad_tipo").html(data.enfermedad.tipo);
        $("#enfermedad_detalle").html(data.enfermedad.detalle);

        // Alimentación
        $("#desayuno").html(data.alimentacion.desayuno);
        $("#almuerzo").html(data.alimentacion.almuerzo);
        $("#merienda").html(data.alimentacion.merienda);
        $("#extra").html(data.alimentacion.extra);
        $("#observaciones").html(data.alimentacion.observaciones);
        $("#recomendada").html(data.alimentacion.recomendada);

        // Mostrar el modal
        $("#datosModal").modal("show");
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Error al obtener datos: ", textStatus, errorThrown);
      },
    });
  }
});

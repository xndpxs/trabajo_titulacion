$(document).ready(function () {
  $("#advancedSearchForm").submit(function (e) {
    e.preventDefault();

    var cedulaPaciente = $('input[name="cedulaPaciente"]').val() || "";
    var cedulaDoctor = $('input[name="cedulaDoctor"]').val() || "";
    var nombrePaciente = $('input[name="nombrePaciente"]').val() || "";
    var apellidoPaciente = $('input[name="apellidoPaciente"]').val() || "";
    var nombreDoctor = $('input[name="nombreDoctor"]').val() || "";
    var apellidoDoctor = $('input[name="apellidoDoctor"]').val() || "";

    // Recoger los valores de los checkboxes de estado
    var estados = [];
    $('input[name="estado[]"]:checked').each(function () {
      estados.push($(this).val());
    });

    var fecha = $('input[name="fecha"]').val() || "";
    var hora = $('select[name="hora"]').val() || "";

    console.log(estados);

    $.ajax({
      url: "/gymes.com/controller/sesion/searchSesionController.php",
      type: "GET",
      traditional: true, // Asegura el correcto envío de arrays
      data: {
        cedulaPaciente: cedulaPaciente,
        cedulaDoctor: cedulaDoctor,
        nombrePaciente: nombrePaciente,
        apellidoPaciente: apellidoPaciente,
        nombreDoctor: nombreDoctor,
        apellidoDoctor: apellidoDoctor,
        "estado[]": estados,
        fecha: fecha,
        hora: hora,
      },
      success: function (response) {
        console.log("Tipo de respuesta:", typeof response);
        console.log("Respuesta del servidor antes del JSON.PARSE:", response);
        console.log("Conexión exitosa con searchSesionController.php");
        // Convertir la respuesta JSON a un objeto JavaScript
        var data = JSON.parse(response);

        // Limpiar la tabla actual
        $("#tabla_sesiones").empty();

        //debug
        console.log("Respuesta del servidor:", data);

        // Renderizar los resultados en la tabla
        data.forEach(function (sesion) {
          $("#tabla_sesiones").append(`
                    <tr>
                        <td>
                            <span class='custom-checkbox'>
                                <input type='checkbox' id='checkbox${sesion.id_sesion}' name='sesiones[]' value='${sesion.id_sesion}'>
                                <label for='checkbox${sesion.id_sesion}'></label>
                            </span>
                        </td>
                        <td>${sesion.nombre_paciente} ${sesion.apellido_paciente}</td>
                        <td>${sesion.cedula_paciente}</td>
                        <td>${sesion.nombre_doctor} ${sesion.apellido_doctor}</td>
                        <td>${sesion.cedula_doctor}</td>
                        <td>${sesion.fecha}</td>
                        <td>${sesion.tiempo}</td>
                        <td>${sesion.estado}</td>
                        <td>
                            <button class='btnModalDatos' data-id-paciente='${sesion.id_paciente}' data-id-sesion='${sesion.id_sesion}' data-bs-toggle="modal" data-bs-target="#datosModal">
                                <i class='material-icons'>&#xe8b6;</i>
                            </button>
                            <a href='medidasView.php?sesionId=${sesion.id_sesion}' class='medidas'>
                                <i class='material-icons' data-bs-toggle='tooltip' title='Tomar Medidas'>&#xE1D5;</i>
                            </a>
                        </td>
                    </tr>
                    `);
        });
      },
      error: function (error) {
        console.error("Error en la llamada AJAX", error);
        // Aquí puedes agregar manejo de errores, como mostrar un mensaje al usuario
      },
    });
  });

  // Función de imprimir tabla
  $("#printButton").click(function () {
    // Clonar la tabla para no modificar la original
    var tablaClonada = $("#tabla_sesiones").clone();

    // Eliminar la primera y última columna de cada fila
    tablaClonada.find("tr").each(function () {
      $(this).find("th:last-child, td:last-child").remove(); // Elimina la última columna
      $(this).find("th:first-child, td:first-child").remove(); // Elimina la primera columna
    });

    var contenidoTabla = tablaClonada.prop("outerHTML");
    var encabezado = `
        <div class="print-header">
            <img src="/gymes.com/assets/images/gymes_horizontal.png" alt="Encabezado">
        </div>
    `;
    var contenidoAImprimir = `
        <html>
        <head>
            <title>Resultados de Búsqueda</title>            
            <style>
                .print-header {
                    text-align: center;
                    margin-bottom: 20px;
                }
                .print-header img {
                    max-width: 100%;
                    height: auto;
                }
                @media print {
                  .table-to-print {
                    border-collapse: collapse;
                    width: 100%;
                    margin: 15px 0; /* Margen alrededor de la tabla */
                    border: 1px solid black !important; /* Borde alrededor de la tabla */
                    border-right: 1px solid black !important; /* Borde derecho de cada celda */
                  }
                  .table-to-print th, .table-to-print td {
                      padding: 8px;
                      border-top: 1px solid black !important; /* Borde superior de cada celda */
                      border-bottom: 1px solid black !important; /* Borde inferior de cada celda */
                      
                      
                  }
                  .table-to-print tr:nth-child(even) {
                      background-color: #f2f2f2; /* Fondo para filas pares */
                  }
                  .table-to-print tr:nth-child(odd) {
                      background-color: #ffffff; /* Fondo para filas impares */
                  }
                }
            </style>
        </head>
        <body>
            ${encabezado}

            <table class='table-to-print table table-striped table-hover'>
              <tr>              
                <th>Nombre del Paciente</th>
                <th>Cedula del Paciente</th>
                <th>Nombre del Doctor</th>
                <th>Cedula del Doctor</th>
                <th>Fecha de la Sesión</th>
                <th>Hora</th>
                <th>Estado</th>              
              </tr>
              ${contenidoTabla}
            </table>
        </body>
        </html>
    `;

    var ventanaImpresion = window.open("", "_blank");
    ventanaImpresion.document.write(contenidoAImprimir);
    ventanaImpresion.document.close();
    ventanaImpresion.focus();
    ventanaImpresion.print();
    ventanaImpresion.onafterprint = function () {
      ventanaImpresion.close();
    };
  });
});

$(document).ready(function () {
  // Inicialización de Select2 para seleccionar un nuevo doctor
  $("#doctor").select2({
    dropdownParent: $("#deleteDoctorModal"),
    //matcher: matchStart,
    minimumInputLength: 3,
  });

  // Cuando se abre el modal para eliminar un doctor
  $("#deleteDoctorModal").on("show.bs.modal", function (e) {
    var selected = getSelectedDoctors();
    if (selected.length === 0) {
      e.preventDefault();
      alert("No se ha seleccionado doctor para borrar");
      return;
    }
    cargarDoctores();
    // Restablecer el Select2 para el nuevo doctor
    $("#doctor").val(null).trigger("change");
  });

  // Cuando se envía el formulario para eliminar un doctor
  $("#deleteDoctorForm").on("submit", function (e) {
    e.preventDefault();

    var idsToDelete = getSelectedDoctors();
    var nuevoDoctorId = $("#doctor").val();

    console.log("IDs a eliminar:", idsToDelete);
    console.log("Nuevo ID del doctor:", nuevoDoctorId);

    if (idsToDelete.length > 0 && nuevoDoctorId) {
      $.ajax({
        type: "POST",
        url: "/gymes.com/controller/admin/deleteDoctorController.php",
        data: {
          ids: idsToDelete.join(","),
          nuevo_id_doctor: nuevoDoctorId,
        },
        success: function (data) {
          alert("Doctor eliminado y citas reasignadas con éxito.");
          $("#deleteDoctorModal").modal("hide");
          location.reload();
        },
        error: function (xhr, status, error) {
          console.error("Error en AJAX:", xhr, status, error);
        },
      });
    } else {
      alert(
        "Debes seleccionar un nuevo doctor y confirmar la selección para eliminar"
      );
    }
  });
});

function cargarDoctores() {
  const selectDoctor = document.getElementById("doctor");
  selectDoctor.innerHTML = ""; // Limpia las opciones existentes

  const defaultOption = document.createElement("option");
  defaultOption.value = "";
  defaultOption.textContent = "Seleccione un doctor";
  defaultOption.disabled = true;
  defaultOption.selected = true;
  selectDoctor.appendChild(defaultOption);

  doctores.forEach((doctor) => {
    const option = document.createElement("option");
    option.value = doctor.id_doctor;
    option.textContent = `${doctor.nombre} ${doctor.apellido} (${doctor.cedula})`;
    selectDoctor.appendChild(option);
  });

  $("#doctor").trigger("change"); // Actualiza Select2 con las nuevas opciones
}

function getSelectedDoctors() {
  var selected = [];
  $('input[name="options[]"]:checked').each(function () {
    selected.push($(this).val());
  });
  return selected;
}

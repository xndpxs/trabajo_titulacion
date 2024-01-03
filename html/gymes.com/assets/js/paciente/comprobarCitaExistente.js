document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("btnGestion").addEventListener("click", function (e) {
    e.preventDefault();
    fetch("/gymes.com/controller/paciente/checkCitaController.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        checkCita: true,
      }),
    })
      .then((response) => response.text()) // Primero obtenemos la respuesta como texto
      .then((text) => {
        console.log("Respuesta en texto:", text); // Imprimimos la respuesta para ver qué estamos recibiendo
        return JSON.parse(text); // Intentamos convertir el texto a JSON
      })
      .then((data) => {
        if (data.error && data.type === "cita_existente") {
          // Mostrar el modal
          var myModal = new bootstrap.Modal(
            document.getElementById("citaExistenteModal"),
            {}
          );
          myModal.show();
        } else {
          // Redirigir a la página de agendamiento
          console.log("Redirigiendo...");
          window.location.href =
            "/gymes.com/view/paciente/agendarCitasView.php";
        }
      })
      .catch((error) => {
        console.error("Error Fetch:", error);
        alert(
          "Ha ocurrido un error. Por favor, revisa la consola para más detalles."
        );
      });
  });
});

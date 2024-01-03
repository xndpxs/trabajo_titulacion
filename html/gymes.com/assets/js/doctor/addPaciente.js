document.addEventListener("DOMContentLoaded", function() {
    let formElement = document.querySelector('#addPatientModal form');
    
    formElement.addEventListener('submit', function(e) {
        e.preventDefault();

        let nombre = document.getElementById('nombre').value;
        let apellido = document.getElementById('apellido').value;
        let email = document.getElementById('email').value;
        let direccion = document.getElementById('direccion').value;
        let telefono = document.getElementById('telefono').value;
        let cedula = document.getElementById('cedula').value;
        let fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
        let ocupacion = document.getElementById('ocupacion').value;

        if (nombre === "" || apellido === "" || email === "" || direccion === "" || telefono === "" || cedula === "" || fecha_nacimiento === "" || ocupacion === "") {
            alert('Por favor, completa todos los campos');
            return;
        }

        fetch("/gymes.com/controller/doctor/addPatientController.php", {  // Asegúrate de actualizar esta ruta a la correcta para agregar un paciente.
            method: "POST",
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                nombre: nombre,
                apellido: apellido,
                email: email,
                direccion: direccion,
                telefono: telefono,
                cedula: cedula,
                fecha_nacimiento: fecha_nacimiento,
                ocupacion: ocupacion
            })
        })
        .then(response => response.text())
        .then(data => {
            alert(data); // Esto mostrará el mensaje que enviaste desde PHP.
            location.reload(); // Esto recargará la página.
        })
        .catch(error => {
            alert('Ha ocurrido un error al agregar el paciente. Por favor, intenta de nuevo.');
        });
    });
});
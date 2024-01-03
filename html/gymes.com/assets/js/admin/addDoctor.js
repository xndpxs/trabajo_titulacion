document.addEventListener("DOMContentLoaded", function() {
    
    console.log("addDoctor.js ha sido cargado");
    let formElement = document.querySelector('#addDoctorModal form');
    
    formElement.addEventListener('submit', function(e) {
        console.log("Intentando enviar el formulario");
        e.preventDefault();

        let nombre = document.getElementById('nombre').value;
        let apellido = document.getElementById('apellido').value;
        let email = document.getElementById('email').value;
        let direccion = document.getElementById('direccion').value;
        let telefono = document.getElementById('telefono').value;
        let cedula = document.getElementById('cedula').value;

        if (nombre === "" || apellido === "" || email === "" || direccion === "" || telefono === "" || cedula === "") {
            console.log("Faltan campos por completar");
            alert('Por favor, completa todos los campos');
            return;
        }

        fetch("/gymes.com/controller/admin/addDoctorController.php", {
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
                cedula: cedula
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
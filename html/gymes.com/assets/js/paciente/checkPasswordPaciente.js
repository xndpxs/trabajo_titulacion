document.querySelector('form').addEventListener('submit', function(e) {
    console.log("Formulario intentando enviarse");
    
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('passwordConfirm').value;
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const direccion = document.getElementById('direccion').value;
    const telefono = document.getElementById('telefono').value;
    const cedula = document.getElementById('cedula').value;
    const email = document.getElementById('email').value;

    // Aquí añadimos las dos líneas para obtener los valores de fecha_nacimiento y ocupacion
    const fecha_nacimiento = document.getElementById('fecha_nacimiento').value;
    const ocupacion = document.getElementById('ocupacion').value;

    // Comprueba si alguno de los campos está vacío
    if (!password || !confirmPassword || !nombre || !apellido || !direccion || !telefono || !cedula || !email || !fecha_nacimiento || !ocupacion) {
        alert('Todos los campos son obligatorios.');
        e.preventDefault();
        return;
    }

    // Comprueba si las contraseñas coinciden
    if (password !== confirmPassword) {
        alert('Las contraseñas no coinciden.');
        e.preventDefault();
        return;
    }
});
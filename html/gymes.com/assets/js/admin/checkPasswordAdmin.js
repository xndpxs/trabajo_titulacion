document.querySelector('form').addEventListener('submit', function(e) {
    console.log("Formulario intentando enviarse");  // Esta línea
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('passwordConfirm').value;
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const direccion = document.getElementById('direccion').value;
    const telefono = document.getElementById('telefono').value;
    const cedula = document.getElementById('cedula').value;
    const email = document.getElementById('email').value;
    // Añade otros campos si es necesario

    // Comprueba si alguno de los campos está vacío
    if (!password || !confirmPassword || !nombre || !apellido || !direccion || !telefono || !cedula || !email) {
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
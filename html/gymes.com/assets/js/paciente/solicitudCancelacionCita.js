document.querySelector('.btn-secondary').addEventListener('click', function() {
    fetch('/gymes.com/controller/paciente/correoCancelacionController.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
    })
    .then(response => response.text())
    .then(data => {
        alert(data);  // Mostrar la respuesta del servidor
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
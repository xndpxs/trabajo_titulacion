document.addEventListener('DOMContentLoaded', (event) => {
    // Inicialización de Select2 para paciente y doctor con búsqueda personalizada
    
    $('#paciente').select2({
        dropdownParent: $('#createSesionModal'),
        matcher: matchStart,
        minimumInputLength: 3
    });

    $('#doctor').select2({
        dropdownParent: $('#createSesionModal'),
        matcher: matchStart,
        minimumInputLength: 3
    });

    // Cargar los datos iniciales
    cargarPacientes();
    cargarDoctores();

    let formElement = document.querySelector('#createSesionModal #agregarSesionForm');
    
    if (formElement) {
        formElement.addEventListener('submit', function(e) {
            e.preventDefault();
            
            let fecha = document.getElementById('fecha').value;
            let tiempo = document.getElementById('tiempo').value;
            let lugar = document.getElementById('lugar').value;
            let notas = document.getElementById('notas').value;
            let id_paciente = document.getElementById('paciente').value;
            let id_doctor = document.getElementById('doctor').value;

            if (fecha === "" || tiempo === "" || lugar === "") {
                alert('Por favor, completa todos los campos');
                return;
            }

            fetch("/gymes.com/controller/sesion/createSesionController.php", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },            
                body: new URLSearchParams({
                    fecha: fecha,
                    tiempo: tiempo,
                    lugar: lugar,
                    notas: notas,
                    id_paciente: id_paciente,
                    id_doctor: id_doctor
                })
            })
            .then(response => response.text())
            .then(data => {
                if (data === "Sesión agregada con éxito") {
                    alert(data);
                    location.reload();
                } else {
                    alert(data); 
                }
            })
            .catch(error => {
                alert('Ha ocurrido un error al agregar la sesión. Por favor, intenta de nuevo.');
            });
        });
    } else {
        console.error('Formulario no encontrado');
    }
});

function cargarPacientes() {
    const selectPaciente = document.getElementById('paciente');
    if (selectPaciente) {
        // Añadir una opción inicial
        const defaultOption = document.createElement('option');
        defaultOption.value = "";
        defaultOption.textContent = "Ingrese nombre o cédula";
        defaultOption.disabled = true;
        defaultOption.selected = true;
        selectPaciente.appendChild(defaultOption);

        pacientes.forEach(paciente => {
            const option = document.createElement('option');
            option.value = paciente.id_paciente;
            option.textContent = `${paciente.nombre} ${paciente.apellido} (${paciente.cedula})`;
            selectPaciente.appendChild(option);
        });
    }
}

function cargarDoctores() {
    const selectDoctor = document.getElementById('doctor');
    if (selectDoctor) {
        // Añadir una opción inicial
        const defaultOption = document.createElement('option');
        defaultOption.value = "";
        defaultOption.textContent = "Ingrese nombre o cédula";
        defaultOption.disabled = true;
        defaultOption.selected = true;
        selectDoctor.appendChild(defaultOption);

        doctores.forEach(doctor => {
            const option = document.createElement('option');
            option.value = doctor.id_doctor;
            option.textContent = `${doctor.nombre} ${doctor.apellido} (${doctor.cedula})`;
            selectDoctor.appendChild(option);
        });
    }
}

function matchStart(params, data) {
    if ($.trim(params.term) === '') {
        return data;
    }

    if (typeof data.text === 'undefined') {
        return null;
    }

    if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
        return data;
    }

    return null;
}
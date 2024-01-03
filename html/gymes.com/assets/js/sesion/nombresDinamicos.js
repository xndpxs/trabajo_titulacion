document.addEventListener('DOMContentLoaded', (event) => {
    cargarPacientes();
    cargarDoctores();

    // Inicializa select2 con los padres de despliegue correctos
    $('#paciente').select2({
        dropdownParent: $('#createSesionModal'),
        minimumInputLength: 3
    });

    $('#doctor').select2({
        dropdownParent: $('#createSesionModal'),
        minimumInputLength: 3
    });
});

function cargarPacientes() {
    console.log("Cargando pacientes", pacientes);  // Agregado para depuración
    const selectPaciente = document.getElementById('paciente');
    if (selectPaciente) {
        pacientes.forEach(paciente => {
            const option = document.createElement('option');
            option.value = paciente.id_persona;
            option.textContent = `${paciente.nombre} ${paciente.apellido}`;
            selectPaciente.appendChild(option);
        });
        $('#paciente').select2(); 
    }
}

function cargarDoctores() {
    console.log("Cargando doctores", doctores);  // Agregado para depuración
    const selectDoctor = document.getElementById('doctor');
    if (selectDoctor) {
        doctores.forEach(doctor => {
            const option = document.createElement('option');
            option.value = doctor.id_persona;
            option.textContent = `${doctor.nombre} ${doctor.apellido}`;
            selectDoctor.appendChild(option);
        });
        $('#doctor').select2(); 
    }
}

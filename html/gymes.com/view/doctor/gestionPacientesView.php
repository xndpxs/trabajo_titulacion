<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();

$returnUrl = $session->get('return_url');

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../view/LoginView.php');
    exit;
}
//require '../../config/config.php';
include_once '../../model/PatientModel.php';
include_once '../../controller/paginationController.php';

// Creamos una instancia del modelo y del controlador de paginación.
$patientModel = new PatientModel($conn);
$paginationController = new PaginationController($patientModel);

// Recogemos los parámetros desde la URL.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Obtenemos los datos usando el controlador.
$paginationData = $paginationController->getPaginationData($searchQuery, $page);
$patients = $paginationData['items'];
$total_records = $paginationData['total_records'];
$total_pages = $paginationData['total_pages'];
$start_page = $paginationData['start_page'];
$end_page = $paginationData['end_page'];
$current_page = $paginationData['current_page'];

include_once '../includes/header.php';

//Agregamos los modals
include_once 'modals/addPatientModal.php';
include_once 'modals/updatePatientModal.php';
include_once 'modals/deletePatientModal.php';
include_once 'modals/profilePatientModal.php';

ob_end_flush();
?>

<title>Gestión de Pacientes</title>
<div class="container">
    <!-- Titulo -->
    <div class="d-flex align-items-center justify-content-between">
        <div class="col-md-4">
            <a href="gestionPacientesView.php" class="text-decoration-none">
                <h2>Gestionar <b>Pacientes</b></h2>
            </a>
        </div>

        <!-- Botones -->
        <div class="col-md-4">
            <div class="crud-buttons">
                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPatientModal" id="addPatientButton">
                    <i class="material-icons">&#xE147;</i>
                    <span>Agregar</span>
                </a>
                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deletePatientModal" id="deletePatientButton">
                    <i class="material-icons">&#xE15C;</i>
                    <span>Borrar</span>
                </a>
            </div>
        </div>

        <!-- Search form -->
        <div id="search-bar" class="col-md-4">
            <form class="example" action="gestionPacientesView.php" method="GET">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
                <input type="text" placeholder="Buscar.." name="query">
            </form>
        </div>
    </div>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Cedula</th>
                <th>Telefono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($patients as $patient) : ?>
                <tr>
                    <td>
                        <span class='custom-checkbox'>
                            <input type='checkbox' id='checkbox<?= $patient['id_paciente'] ?>' name='options[]' value='<?= $patient['id_paciente'] ?>'>
                            <label for='checkbox<?= $patient['id_paciente'] ?>'></label>
                        </span>
                    </td>
                    <td><?= $patient['nombre'] ?></td>
                    <td><?= $patient['apellido'] ?></td>
                    <td><?= $patient['email'] ?></td>
                    <td><?= $patient['cedula'] ?></td>
                    <td><?= $patient['telefono'] ?></td>
                    <td>
                        <button class='btnModalPaciente' data-id='<?= $patient['id_paciente'] ?>' data-bs-toggle="modal" data-bs-target="#pacienteModal">
                            <i class='material-icons'>&#xe8b6;</i>
                        </button>
                        <a href='#' class='update' data-id='<?= $patient['id_paciente'] ?>'>
                            <i class='material-icons' data-bs-toggle='tooltip' title='Editar'>&#xE254;</i>
                        </a>
                        <!--    
                        <a href='#' class='delete' data-id='<?= $patient['id_paciente'] ?>'>
                            <i class='material-icons' data-bs-toggle='tooltip' title='Borrar'>&#xE872;</i>
                        </a>
                        Boton de borrado -->
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Logica de paginacion abreviada -->
    <div class="d-flex align-items-center justify-content-between">
        <div class="pagination-container">
            <?php
            // Calculamos el número de registros mostrados en la página actual
            $records_on_current_page = count($patients);

            // Preparamos el mensaje de la paginación
            $pagination_message = $searchQuery
                ? "Mostrando <b>$records_on_current_page</b> de <b>$total_records</b> entradas totales"
                : "Mostrando <b>$total_records</b> registros posibles";
            ?>

            <div class="hint-text"><?= $pagination_message; ?></div>
            <ul class="pagination">
                <?php if ($current_page > 1) : ?>
                    <li class='page-item'>
                        <a href='gestionPacientesView.php?page=<?= ($current_page - 1) ?>' class='page-link'>Anterior</a>
                    </li>
                <?php endif; ?>

                <?php if ($start_page > 1) : ?>
                    <li class='page-item disabled'>
                        <span class='page-link'>...</span>
                    </li>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                    <li class='page-item <?= ($i == $current_page) ? "active" : "" ?>'>
                        <a href='gestionPacientesView.php?page=<?= $i ?>' class='page-link'><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages) : ?>
                    <li class='page-item disabled'>
                        <span class='page-link'>...</span>
                    </li>
                <?php endif; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <li class='page-item'>
                        <a href='gestionPacientesView.php?page=<?= ($current_page + 1) ?>' class='page-link'>Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Botones de regresar y cerrar sesion -->
        <div class="logout-buttons">
            <a href="<?= htmlspecialchars($returnUrl); ?>" class="btn btn-outline-secondary">Regresar</a>
            <a href="/gymes.com/controller/SessionController.php?action=logout" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <script src="../../assets/js/doctor/addPaciente.js"></script>
    <script src="../../assets/js/doctor/updatePatient.js"></script>
    <script src="../../assets/js/doctor/deletePatientModal.js"></script>
    <script src="../../assets/js/doctor/deletePatientOnClick.js"></script>
    <script src="../../assets/js/doctor/readPatientProfile.js"></script>
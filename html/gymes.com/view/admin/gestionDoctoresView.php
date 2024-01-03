<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador'])) {
    header('Location: ../../view/LoginView.php');
    exit();
}

include_once '../includes/header.php';
include_once '../../model/DoctorModel.php';
include_once '../../controller/paginationController.php';

// Creamos una instancia del modelo y del controlador de paginación.
$doctorModel = new DoctorModel($conn);
$paginationController = new PaginationController($doctorModel);

// Recogemos los parámetros desde la URL.
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$searchQuery = isset($_GET['query']) ? $_GET['query'] : '';

// Obtenemos los datos usando el controlador.
$paginationData = $paginationController->getPaginationData($searchQuery, $page);
$doctors = $paginationData['items'];
$total_records = $paginationData['total_records'];
$total_pages = $paginationData['total_pages'];
$start_page = $paginationData['start_page'];
$end_page = $paginationData['end_page'];
$current_page = $paginationData['current_page'];

// Doctores para el select2 de borrado
$doctores = $doctorModel->getDoctors();

echo "
    <script>
        var doctores = " . json_encode($doctores) . ";
    </script>
";


//Agregamos los modals
include_once 'modals/addDoctorModal.php';
include_once 'modals/updateDoctorModal.php';
include_once 'modals/deleteDoctorModal.php';
include_once 'modals/readDoctorModal.php';
include_once 'modals/profileDoctorModal.php';

ob_end_flush();
?>
<title>Gestión de Doctores</title>
<div class="container">
    <!-- Titulo -->
    <div class="d-flex align-items-center justify-content-between">
        <div class="col-md-4">
            <a href="gestionDoctoresView.php" class="text-decoration-none">
                <h2>Gestionar <b>Doctores</b></h2>
                <div id="message" class="mt-3"></div>
            </a>
        </div>

        <!-- Botones -->
        <div class="col-md-4">
            <div class="crud-buttons">
                <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDoctorModal" id="addDoctorButton">
                    <i class="material-icons">&#xE147;</i>
                    <span>Agregar</span>
                </a>
                <a href="#" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteDoctorModal" id="deleteDoctorButton">
                    <i class="material-icons">&#xE15C;</i>
                    <span>Borrar</span>
                </a>
            </div>
        </div>

        <!-- Search form -->
        <div id="search-bar" class="col-md-4">
            <form class="example" action="gestionDoctoresView.php" method="GET">
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
            <?php foreach ($doctors as $doctor) : ?>
                <tr data-id='<?= $doctor['id_doctor'] ?>'>
                    <td>
                        <span class='custom-checkbox'>
                            <input type='checkbox' id='checkbox<?= $doctor['id_doctor'] ?>' name='options[]' value='<?= $doctor['id_doctor'] ?>'>
                            <label for='checkbox<?= $doctor['id_doctor'] ?>'></label>
                        </span>
                    </td>
                    <td class='view-doctor'><?= $doctor['nombre'] ?></td>
                    <td class='view-doctor'><?= $doctor['apellido'] ?></td>
                    <td class='view-doctor'><?= $doctor['email'] ?></td>
                    <td class='view-doctor'><?= $doctor['cedula'] ?></td>
                    <td class='view-doctor'><?= $doctor['telefono'] ?></td>
                    <td>

                        <button class='btnModalDoctor' data-id='<?= $doctor['id_doctor'] ?>' data-bs-toggle="modal" data-bs-target="#doctorModal">
                            <i class='material-icons'>&#xe8b6;</i>
                        </button>

                        <a href='#' class='update' data-id='<?= $doctor['id_doctor'] ?>'>
                            <i class='material-icons' data-bs-toggle='tooltip' title='Editar'>&#xE254;</i>
                        </a>
                        <!--  
                            <a href='#' class='delete' data-id='<?= $doctor['id_doctor'] ?>'>
                                <i class='material-icons' data-bs-toggle='tooltip' title='Borrar'>&#xE872;</i>
                            </a>
                            -->

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
            $records_on_current_page = count($doctors);

            // Preparamos el mensaje de la paginación
            $pagination_message = $searchQuery
                ? "Mostrando <b>$records_on_current_page</b> de <b>$total_records</b> entradas totales"
                : "Mostrando <b>$total_records</b> registros posibles";
            ?>

            <div class="hint-text"><?= $pagination_message; ?></div>
            <ul class="pagination">
                <?php if ($current_page > 1) : ?>
                    <li class='page-item'>
                        <a href='gestionDoctoresView.php?page=<?= ($current_page - 1) ?>' class='page-link'>Anterior</a>
                    </li>
                <?php endif; ?>

                <?php if ($start_page > 1) : ?>
                    <li class='page-item disabled'>
                        <span class='page-link'>...</span>
                    </li>
                <?php endif; ?>

                <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                    <li class='page-item <?= ($i == $current_page) ? "active" : "" ?>'>
                        <a href='gestionDoctoresView.php?page=<?= $i ?>' class='page-link'><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($end_page < $total_pages) : ?>
                    <li class='page-item disabled'>
                        <span class='page-link'>...</span>
                    </li>
                <?php endif; ?>

                <?php if ($current_page < $total_pages) : ?>
                    <li class='page-item'>
                        <a href='gestionDoctoresView.php?page=<?= ($current_page + 1) ?>' class='page-link'>Siguiente</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Botones de regresar y cerrar sesion -->
        <div class="logout-buttons">
            <a href="/gymes.com/view/admin/dashboard.php" class="btn btn-outline-secondary">Regresar</a>
            <a href="/gymes.com/controller/SessionController.php?action=logout" class="btn btn-danger">Cerrar sesión</a>
        </div>
    </div>

    <!-- Scripts de acciones -->
    <script src="../../assets/js/admin/addDoctor.js"></script>
    <script src="../../assets/js/admin/deleteDoctorModal.js"></script>
    <script src="../../assets/js/admin/deleteDoctorOnClick.js"></script>
    <script src="../../assets/js/admin/updateDoctor.js"></script>
    <script src="../../assets/js/admin/readDoctorProfile.js"></script>
<?php
ob_start();
include_once '../../utils/Session.php';
$session = new Session();
$session->start();

$returnUrl = $session->get('return_url');

if (!$session->has('login_active') || !in_array($session->get('rol'), ['administrador', 'doctor'])) {
    header('Location: ../../../LoginView.php');
    exit;
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../model/PatientModel.php';
include_once '../../model/SesionModel.php';
$sesionModel = new SesionModel($conn);


// Datos para autorellenar el modal
$pacientes = $sesionModel->getPacientes();
$doctores = $sesionModel->getDoctores();


echo "
    <script>
        var pacientes = " . json_encode($pacientes) . ";
        var doctores = " . json_encode($doctores) . ";
    </script>
";


// Configuración de paginación
$records_per_page = 20; // Número de registros por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $records_per_page;
$limit = $records_per_page;

// Obtenemos los datos usando el modelo con los filtros aplicados
$filtros = [];
$sesiones = $sesionModel->getSesiones($filtros, $start, $limit);
$paginationData = $sesionModel->getPaginationSesiones($page, $records_per_page);
$total_records = $paginationData['total_records'];
$total_pages = $paginationData['total_pages'];
$current_page = $paginationData['current_page'];

$start_page = max(1, $current_page - 2);
$end_page = min($total_pages, $current_page + 2);

include_once '../includes/header.php';

// ... [Código para modals y estructura básica] ...
include_once 'modals/createSesionModal.php';
include_once 'modals/readDatosModal.php';
include_once 'modals/cancelSesionModal.php';

ob_end_flush();
?>

<body>
    <title>Gestión de Sesiones</title>
    <div class="container">
        <!-- Titulo -->
        <div class="d-flex align-items-center justify-content-between">
            <div class="col-md-4">
                <a href="gestionSesionesView.php" class="text-decoration-none">
                    <h2>Gestionar <b>Citas</b></h2>
                </a>
            </div>
        </div>


        <div class="container">
            <form id="advancedSearchForm" method="GET">
                <div class="row mb-3">
                    <!-- Campo de cédula del paciente y botón de filtros avanzados -->
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Cédula del Paciente" name="cedulaPaciente" id="cedulaPacienteInput" />
                            <button class="btn btn-outline-secondary" type="submit" form="advancedSearchForm">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#extraFilters" aria-expanded="false">
                                Filtros Avanzados <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Botones -->

                    <div class="col-md-6">
                        <div class="crud-buttons float-end">
                            <a href="#" class="btn btn-success ml-auto" data-bs-toggle="modal" data-bs-target="#createSesionModal" id="addSesionButton">
                                <i class="material-icons">&#xE147;</i>
                                <span>Agregar</span>
                            </a>


                            <a href="#" class="btn btn-danger ml-auto" data-bs-toggle="modal" data-bs-target="#cancelSesionModal" id="cancelSesionButton">
                                <i class="material-icons">&#xE15C;</i>
                                <span>Cancelar</span>
                            </a>

                            <a href="#" class="btn btn-secondary ml-auto" data-bs-toggle="modal" id="printButton">
                                <i class="material-icons">&#xe8ad;</i>
                                <span>Imprimir</span>
                            </a>
                        </div>
                    </div>

                </div>




                <!-- Filtros avanzados desplegables -->
                <div class="collapse" id="extraFilters">

                    <div class="row mb-3">
                        <!-- Campo para la cédula del doctor -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Cédula del Doctor" name="cedulaDoctor" id="cedulaDoctorInput" />
                        </div>

                        <div class="col-md-6">
                            <div class="form-check form-check-inline ml-2">
                                <input class="form-check-input" type="checkbox" name="estado[]" id="estadoActivo" value="activo" checked>
                                <label class="form-check-label" for="estadoActivo">Activo</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="estado[]" id="estadoPasado" value="pasado">
                                <label class="form-check-label" for="estadoPasado">Pasado</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="estado[]" id="estadoCancelado" value="cancelado">
                                <label class="form-check-label" for="estadoCancelado">Cancelado</label>
                            </div>
                        </div>

                    </div>
                    <div class="row mb-3">
                        <!-- Campos para el nombre del paciente y del doctor -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nombre del Paciente" name="nombrePaciente" />
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nombre del Doctor" name="nombreDoctor" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Campos para el apellido del paciente y del doctor -->
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Apellido del Paciente" name="apellidoPaciente" />
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Apellido del Doctor" name="apellidoDoctor" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Selectores para fecha y hora -->
                        <div class="col-md-6">
                            <input type="date" class="form-control" name="fecha" />
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="hora">
                                <option value="">Hora</option>
                                <?php for ($i = 8; $i <= 20; $i++) : ?>
                                    <option value="<?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>:00"><?= str_pad($i, 2, '0', STR_PAD_LEFT) ?>:00</option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <!-- Botón de búsqueda fuera de los filtros avanzados 
                <div class="row">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary" form="advancedSearchForm">Buscar</button>
                    </div>
                </div>
                -->
                </div>
            </form>

        </div>







        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th></th>
                    <th>Nombre del Paciente</th>
                    <th>Cedula del Paciente</th>
                    <th>Nombre del Doctor</th>
                    <th>Cedula del Doctor</th>
                    <th>Fecha de la Sesión</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla_sesiones">
                <?php foreach ($sesiones as $sesion) : ?>
                    <tr>
                        <td>
                            <span class='custom-checkbox'>
                                <input type='checkbox' id='checkbox<?= $sesion['id_sesion'] ?>' name='sesiones[]' value='<?= $sesion['id_sesion'] ?>'>
                                <label for='checkbox<?= $sesion['id_sesion'] ?>'></label>
                            </span>
                        </td>
                        <td><?= $sesion['nombre_paciente'] . " " . $sesion['apellido_paciente'] ?></td>
                        <td><?= $sesion['cedula_paciente'] ?></td>
                        <td><?= $sesion['nombre_doctor'] . " " . $sesion['apellido_doctor'] ?></td>
                        <td><?= $sesion['cedula_doctor'] ?></td>
                        <td><?= $sesion['fecha'] ?></td>
                        <td><?= $sesion['tiempo'] ?></td>
                        <td><?= $sesion['estado'] ?></td>
                        <td>


                            <button class='btnModalDatos' data-id-paciente='<?= $sesion['id_paciente'] ?>' data-id-sesion='<?= $sesion['id_sesion'] ?>' data-bs-toggle="modal" data-bs-target="#datosModal">
                                <i class='material-icons'>&#xe8b6;</i>
                            </button>

                            <a href='medidasView.php?sesionId=<?= $sesion['id_sesion'] ?>' class='medidas'>
                                <i class='material-icons' data-bs-toggle='tooltip' title='Tomar Medidas'>&#xE1D5;</i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


        <!-- ... [Código para botones de acción] ... -->


        <!-- Logica de paginacion abreviada -->
        <div class="d-flex align-items-center justify-content-between">
            <div class="pagination-container">
                <div class="hint-text">Mostrando <b><?= min($records_per_page, $total_records - (($page - 1) * $records_per_page)); ?></b> de <b><?= $total_records; ?></b> entradas totales.</div>
                <ul class="pagination">
                    <?php
                    $start_page = max(1, $current_page - 2); // Definición de $start_page
                    $end_page = min($total_pages, $current_page + 2); // Definición de $end_page

                    if ($current_page > 1) :
                    ?>
                        <li class='page-item'>
                            <a href='gestionSesionesView.php?page=<?= ($current_page - 1) ?>' class='page-link'>Anterior</a>
                        </li>
                    <?php endif; ?>

                    <?php if ($start_page > 1) : ?>
                        <li class='page-item disabled'>
                            <span class='page-link'>...</span>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                        <li class='page-item <?= ($i == $current_page) ? "active" : "" ?>'>
                            <a href='gestionSesionesView.php?page=<?= $i ?>' class='page-link'><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($end_page < $total_pages) : ?>
                        <li class='page-item disabled'>
                            <span class='page-link'>...</span>
                        </li>
                    <?php endif; ?>

                    <?php if ($current_page < $total_pages) : ?>
                        <li class='page-item'>
                            <a href='gestionSesionesView.php?page=<?= ($current_page + 1) ?>' class='page-link'>Siguiente</a>
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

    </div>
</body>

<!-- ... [Código para scripts de acciones] ... -->
<script src="../../assets/js/sesion/addSesion.js"></script>
<script src="../../assets/js/sesion/cancelSesionModal.js"></script>
<script src="../../assets/js/sesion/searchSesion.js"></script>
<script src="../../assets/js/sesion/pacienteSesionHandler.js"></script>...
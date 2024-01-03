<?php
require_once 'PersonModel.php';

class SesionModel extends PersonModel
{

    public function __construct($conn)
    {
        parent::__construct($conn);
    }

    //Este par de metodos sirven para el autocompletado
    public function getPacientes()
    {
        $sql = "SELECT personas.id_persona, paciente.id_paciente, personas.cedula, personas.nombre, personas.apellido 
                FROM personas 
                INNER JOIN paciente ON personas.id_persona = paciente.id_persona";
        $result = $this->conn->query($sql);

        $pacientes = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $pacientes[] = $row;
        }
        return $pacientes;
    }

    public function leerSesion($id_sesion)
    {
        try {
            $sql = "SELECT * FROM sesion WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_sesion', $id_sesion);

            if (!$stmt->execute()) {
                throw new Exception("Error al leer los datos de la sesión.");
            }

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$resultado) {
                throw new Exception("Sesión no encontrada.");
            }

            return $resultado;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }

    public function getDoctores()
    {
        $sql = "SELECT personas.id_persona, doctor.id_doctor, personas.cedula, personas.nombre, personas.apellido 
                FROM personas 
                INNER JOIN doctor ON personas.id_persona = doctor.id_persona";
        $result = $this->conn->query($sql);

        $doctores = [];
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $doctores[] = $row;
        }
        return $doctores;
    }




    //CREAR SESION********************************
    public function crearSesion($fecha, $hora, $lugar, $id_paciente, $id_doctor, $notas)
    {
        try {
            // Iniciar una transacción
            $this->conn->beginTransaction();

            // Crear una nueva asignación con id_paciente y id_doctor
            $queryAsignacion = "INSERT INTO asignacion (id_paciente, id_doctor) VALUES (:id_paciente, :id_doctor)";
            $stmtAsignacion = $this->conn->prepare($queryAsignacion);
            $stmtAsignacion->bindParam(':id_paciente', $id_paciente);
            $stmtAsignacion->bindParam(':id_doctor', $id_doctor);

            // Ejecutar y verificar la primera consulta
            if (!$stmtAsignacion->execute()) {
                throw new Exception('Error en la creación de la asignación.');
            }

            // Obtener el id de la nueva asignación
            $id_asignacion = $this->conn->lastInsertId();

            // Crear una nueva sesión con el id_asignacion
            $querySesion = "INSERT INTO sesion (id_asignacion, fecha, tiempo, lugar, notas) VALUES (:id_asignacion, :fecha, :hora, :lugar, :notas)";
            $stmtSesion = $this->conn->prepare($querySesion);
            $stmtSesion->bindParam(':id_asignacion', $id_asignacion);
            $stmtSesion->bindParam(':fecha', $fecha);
            $stmtSesion->bindParam(':hora', $hora);
            $stmtSesion->bindParam(':lugar', $lugar);
            $stmtSesion->bindParam(':notas', $notas);

            // Ejecutar y verificar la segunda consulta
            if (!$stmtSesion->execute()) {
                throw new Exception('Error en la creación de la sesión.');
            }

            // Si todo fue exitoso, confirmar la transacción
            $this->conn->commit();

            return true;
        } catch (Exception $e) {
            // Si hubo algún error, revertir la transacción
            $this->conn->rollBack();
            throw $e;
        }
    }

    //Metodo para contar el total de sesiones
    public function getTotalSesiones()
    {
        $sql = "SELECT COUNT(*) FROM sesion";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    //Metodo para mostrar la paginacion de las sesiones:
    public function getPaginationSesiones($page = 1, $records_per_page = 20)
    {
        // Calcular el límite inicial de la consulta
        $start_from = ($page - 1) * $records_per_page;

        // Query para obtener las últimas 20 sesiones
        $sql = "SELECT * FROM sesion ORDER BY fecha DESC LIMIT $start_from, $records_per_page";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // Obtener los resultados
        $sessions = $stmt->fetchAll();

        // Query para obtener el número total de sesiones
        $total_records_sql = "SELECT COUNT(*) FROM sesion";
        $stmt = $this->conn->prepare($total_records_sql);
        $stmt->execute();
        $total_records = $stmt->fetchColumn();

        // Calcular el total de páginas
        $total_pages = ceil($total_records / $records_per_page);

        // Preparar el array de datos de paginación
        return [
            'sessions' => $sessions,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'records_per_page' => $records_per_page
        ];
    }


    // LEER sesiones de un paciente
    public function readByPatient($id_paciente)
    {
        $sql = "SELECT sesion.* 
                FROM sesion 
                JOIN asignacion ON sesion.id_asignacion = asignacion.id_asignacion
                WHERE asignacion.id_paciente = :id_paciente 
                ORDER BY sesion.fecha ASC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_paciente', $id_paciente);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // CANCELAR una sesión***********************************************************************

    public function cancelarSesion($id_sesion)
    {
        try {
            // Verificar si la fecha y hora de la sesión son anteriores a la fecha y hora actuales
            $sqlFechaHora = "SELECT fecha, tiempo FROM sesion WHERE id_sesion = :id_sesion";
            $stmtFechaHora = $this->conn->prepare($sqlFechaHora);
            $stmtFechaHora->bindParam(':id_sesion', $id_sesion);
            $stmtFechaHora->execute();
            $sesion = $stmtFechaHora->fetch(PDO::FETCH_ASSOC);

            if (!$sesion) {
                throw new Exception("La sesión no fue encontrada.");
            }

            $fechaHoraSesion = new DateTime($sesion['fecha'] . ' ' . $sesion['tiempo']);
            $fechaHoraActual = new DateTime();

            if ($fechaHoraSesion < $fechaHoraActual) {
                throw new Exception("No se puede cancelar una sesión que ya ha pasado.");
            }

            // Preparar y ejecutar la consulta SQL para actualizar el estado de la sesión a 'cancelado'
            $sql = "UPDATE sesion SET estado = 'cancelado' WHERE id_sesion = :id_sesion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_sesion', $id_sesion);

            if (!$stmt->execute()) {
                throw new Exception("Error al cancelar la sesión.");
            }

            if ($stmt->rowCount() === 0) {
                throw new Exception("La sesión a cancelar no fue encontrada o ya estaba cancelada.");
            }

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // GET SESIONES***********************************
    // para rellenar la tabla:
    public function getAllSesiones($start, $limit)
    {
        $sql = "
            SELECT 
                sesion.id_sesion, 
                pacientePersonas.nombre AS nombre_paciente, 
                pacientePersonas.apellido AS apellido_paciente,
                pacientePersonas.cedula AS cedula_paciente, 
                doctorPersonas.nombre AS nombre_doctor, 
                doctorPersonas.apellido AS apellido_doctor, 
                doctorPersonas.cedula AS cedula_doctor,
                sesion.fecha,
                sesion.tiempo,
                sesion.lugar,
                sesion.notas,
                sesion.estado
            FROM 
                sesion 
            JOIN 
                asignacion ON sesion.id_asignacion = asignacion.id_asignacion 
            JOIN 
                paciente ON asignacion.id_paciente = paciente.id_paciente 
            JOIN 
                personas AS pacientePersonas ON paciente.id_persona = pacientePersonas.id_persona 
            JOIN 
                doctor ON asignacion.id_doctor = doctor.id_doctor 
            JOIN 
                personas AS doctorPersonas ON doctor.id_persona = doctorPersonas.id_persona 
            ORDER BY sesion.fecha DESC, sesion.tiempo DESC LIMIT :start, :limit";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // FIND SESIONES************************************************************************************
    //para buscar las sesiones 

    public function getSesiones($filtros, $start, $limit)
    {
        $sql = "
            SELECT
                sesion.id_sesion,
                paciente.id_paciente,            
                pacientePersonas.nombre AS nombre_paciente,
                pacientePersonas.apellido AS apellido_paciente,
                pacientePersonas.cedula AS cedula_paciente,
                doctorPersonas.nombre AS nombre_doctor,
                doctorPersonas.apellido AS apellido_doctor,
                doctorPersonas.cedula AS cedula_doctor,
                sesion.fecha,
                sesion.tiempo,
                sesion.lugar,
                sesion.notas,
                sesion.estado
            FROM
                sesion
            JOIN
                asignacion ON sesion.id_asignacion = asignacion.id_asignacion
            JOIN
                paciente ON asignacion.id_paciente = paciente.id_paciente
            JOIN
                personas AS pacientePersonas ON paciente.id_persona = pacientePersonas.id_persona
            JOIN
                doctor ON asignacion.id_doctor = doctor.id_doctor
            JOIN
                personas AS doctorPersonas ON doctor.id_persona = doctorPersonas.id_persona
            WHERE 1 = 1";

        // Aplicar el filtro de cedulaPaciente si existe
        if (!empty($filtros['cedulaPaciente'])) {
            $sql .= " AND pacientePersonas.cedula = :cedulaPaciente";
        }

        // Aplicar el filtro de cedulaDoctor si existe
        if (!empty($filtros['cedulaDoctor'])) {
            $sql .= " AND doctorPersonas.cedula = :cedulaDoctor";
        }

        // Aplicar el filtro de fecha si existe
        if (!empty($filtros['fecha'])) {
            $sql .= " AND sesion.fecha = :fecha";
        }

        // Aplicar el filtro de hora si existe
        if (!empty($filtros['hora'])) {
            $sql .= " AND sesion.tiempo = :hora";
        }

        // Aplicar el filtro de nombre paciente si existe
        if (!empty($filtros['nombrePaciente'])) {
            $nombrePaciente = '%' . $filtros['nombrePaciente'] . '%';
            $sql .= " AND pacientePersonas.nombre LIKE :nombrePaciente";
        }

        if (!empty($filtros['apellidoPaciente'])) {
            $apellidoPaciente = '%' . $filtros['apellidoPaciente'] . '%';
            $sql .= " AND pacientePersonas.apellido LIKE :apellidoPaciente";
        }

        // Aplicar el filtro de nombre doctor si existe
        if (!empty($filtros['nombreDoctor'])) {
            $nombreDoctor = '%' . $filtros['nombreDoctor'] . '%';
            $sql .= " AND doctorPersonas.nombre LIKE :nombreDoctor";
        }

        // Aplicar el filtro de apellido doctor si existe
        if (!empty($filtros['apellidoDoctor'])) {
            $apellidoDoctor = '%' . $filtros['apellidoDoctor'] . '%';
            $sql .= " AND doctorPersonas.apellido LIKE :apellidoDoctor";
        }

        // Filtro de estado
        if (!empty($filtros['estado']) && is_array($filtros['estado'])) {
            $estadoParams = [];
            foreach ($filtros['estado'] as $i => $estado) {
                $estadoParams[] = ':estado' . $i;
            }
            $sql .= " AND sesion.estado IN (" . implode(', ', $estadoParams) . ")";
        }


        $sql .= " ORDER BY sesion.fecha DESC, sesion.tiempo DESC LIMIT :start, :limit";

        $stmt = $this->conn->prepare($sql);

        // Vincular el parámetro cedulaPaciente si existe
        if (!empty($filtros['cedulaPaciente'])) {
            $stmt->bindParam(':cedulaPaciente', $filtros['cedulaPaciente'], PDO::PARAM_STR);
        }

        // Vincular el parámetro cedulaDoctor si existe
        if (!empty($filtros['cedulaDoctor'])) {
            $stmt->bindParam(':cedulaDoctor', $filtros['cedulaDoctor'], PDO::PARAM_STR);
        }

        // Vincular el parámetro fecha si existe
        if (!empty($filtros['fecha'])) {
            $stmt->bindParam(':fecha', $filtros['fecha'], PDO::PARAM_STR);
        }

        // Vincular el parámetro hora si existe
        if (!empty($filtros['hora'])) {
            $stmt->bindParam(':hora', $filtros['hora'], PDO::PARAM_STR);
        }


        // Vincular el nombre paciente si existe
        if (!empty($filtros['nombrePaciente'])) {
            $stmt->bindParam(':nombrePaciente', $nombrePaciente, PDO::PARAM_STR);
        }

        if (!empty($filtros['apellidoPaciente'])) {
            $stmt->bindParam(':apellidoPaciente', $apellidoPaciente, PDO::PARAM_STR);
        }

        // Vincular el nombre doctor si existe
        if (!empty($filtros['nombreDoctor'])) {
            $stmt->bindParam(':nombreDoctor', $nombreDoctor, PDO::PARAM_STR);
        }

        // Vincular el apellido doctor si existe
        if (!empty($filtros['apellidoDoctor'])) {
            $stmt->bindParam(':apellidoDoctor', $apellidoDoctor, PDO::PARAM_STR);
        }

        // Vincular el filtro de estado
        if (!empty($filtros['estado']) && is_array($filtros['estado'])) {
            //var_dump($filtros['estado']);
            foreach ($filtros['estado'] as $i => $estado) {
                $stmt->bindValue(':estado' . $i, $estado, PDO::PARAM_STR);
            }
        }


        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // LOGICA DEL NEGOCIO***************************************************************
    // Horas de la sesion, para que solo se puedan seleccionar horas enteras. de 8 a 4 esta prohibido por frontend
    public function existeSesion($fecha, $hora, $id_doctor)
    {
        $horaExacta = date("H:00:00", strtotime($hora));

        $sql = "SELECT COUNT(*) 
            FROM sesion 
            JOIN asignacion ON sesion.id_asignacion = asignacion.id_asignacion 
            WHERE sesion.fecha = :fecha 
            AND sesion.tiempo >= :horaExacta 
            AND sesion.tiempo < ADDTIME(:horaExacta, '01:00:00')
            AND asignacion.id_doctor = :id_doctor
            AND sesion.estado = 'activo';";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':horaExacta', $horaExacta);
        $stmt->bindParam(':id_doctor', $id_doctor);
        $stmt->execute();

        return $stmt->fetchColumn() > 0;
    }

    //Detectar si el paciente tiene cita programada***************************
    public function tieneCitaProgramada($id_paciente)
    {
        $currentDate = date('Y-m-d');

        $sql = "SELECT sesion.*
                FROM sesion
                JOIN asignacion ON sesion.id_asignacion = asignacion.id_asignacion
                WHERE asignacion.id_paciente = :id_paciente 
                AND sesion.fecha >= :currentDate
                AND sesion.estado = 'activo'
                LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
        $stmt->bindParam(':currentDate', $currentDate);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    // Obtener proxima sesion para el email de cancelacion***************************************************
    public function obtenerProximaSesion($id_paciente)
    {
        try {
            $hoy = date('Y-m-d');
            $sql = "SELECT sesion.*, asignacion.id_doctor 
                    FROM sesion 
                    JOIN asignacion ON sesion.id_asignacion = asignacion.id_asignacion 
                    JOIN doctor ON asignacion.id_doctor = doctor.id_doctor 
                    WHERE asignacion.id_paciente = :id_paciente 
                    AND sesion.fecha >= :hoy 
                    AND sesion.estado = 'activo'
                    ORDER BY sesion.fecha ASC, sesion.tiempo ASC 
                    LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_paciente', $id_paciente, PDO::PARAM_INT);
            $stmt->bindParam(':hoy', $hoy, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log($e->getMessage());
            return false;
        }
    }

    // En borrado de doctor, asignar un nuevo doctor a un doctor todavía existente*********************

    // Método para obtener todas las asignaciones de un doctor específico
    public function getAsignacionesPorDoctor($idDoctor)
    {
        $sql = "SELECT id_asignacion FROM asignacion WHERE id_doctor = :id_doctor";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_doctor', $idDoctor, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function reasignarDoctor($id_asignacion, $nuevo_id_doctor)
    {
        try {
            $sql = "UPDATE asignacion SET id_doctor = :nuevo_id_doctor WHERE id_asignacion = :id_asignacion";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nuevo_id_doctor', $nuevo_id_doctor, PDO::PARAM_INT);
            $stmt->bindParam(':id_asignacion', $id_asignacion, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }
}

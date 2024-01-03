<?php
use PHPUnit\Framework\TestCase;

require_once 'model/BaseModel.php';
require_once 'model/PersonModel.php';
require_once 'model/PatientModel.php';

class PatientModelTest extends TestCase {
    private $patientModel;
    private $pdoMock;

    protected function setUp(): void {
        // Crear un mock de PDO en lugar de PDOStatement para lastInsertId
        $this->pdoMock = $this->createMock(PDO::class);
        $this->patientModel = new PatientModel($this->pdoMock);
    }

    public function testCreatePacienteAndPersonSuccess() {
        // Configurar el mock de PDO para lastInsertId
        $this->pdoMock->method('lastInsertId')->willReturn('1');

        // Configurar el mock para el método prepare
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->patientModel->createPacienteAndPerson('Nombre', 'Apellido', 'email@example.com', 'Direccion', '1234567890', '1234567890', '2000-01-01', 'Ocupacion', 'paciente');
        $this->assertIsString($result);
    }

    public function testCreatePacienteAndPersonFailure() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $this->expectException(Exception::class);
        $this->patientModel->createPacienteAndPerson('Nombre', 'Apellido', 'email@example.com', 'Direccion', '1234567890', '1234567890', '2000-01-01', 'Ocupacion', 'paciente');
    }

    // Prueba para la actualización exitosa de un paciente
    public function testUpdatePatientPersonSuccess() {
        // Simular que las operaciones de base de datos tienen éxito
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $post = ['nombre' => 'Nombre', 'apellido' => 'Apellido', 'email' => 'email@example.com', 'direccion' => 'Direccion', 'telefono' => '1234567890', 'cedula' => '1234567890', 'password' => 'newpassword', 'fecha_nacimiento' => '2000-01-01', 'ocupacion' => 'Ocupacion'];
        $result = $this->patientModel->updatePatientPerson($post, 1);
        $this->assertTrue($result);
    }

    public function testUpdatePatientPersonFailure() {
        // Simular que la operación de base de datos falla
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $post = ['nombre' => 'Nombre', 'apellido' => 'Apellido', 'email' => 'email@example.com', 'direccion' => 'Direccion', 'telefono' => '1234567890', 'cedula' => '1234567890', 'password' => 'newpassword', 'fecha_nacimiento' => '2000-01-01', 'ocupacion' => 'Ocupacion'];
        $result = $this->patientModel->updatePatientPerson($post, 1);
        $this->assertFalse($result);
    }

    // Prueba para la obtención exitosa de los detalles de un paciente
    public function testGetPacienteDetailsSuccess() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['nombre' => 'John', 'apellido' => 'Doe']);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
        $result = $this->patientModel->getPacienteDetails(1);
        $this->assertIsArray($result);
        $this->assertEquals('John', $result['nombre']);
    }

    // Prueba para el fallo al obtener los detalles de un paciente
    public function testGetPacienteDetailsFailure() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
        $this->expectException(Exception::class);
        $this->patientModel->getPacienteDetails(1);
    }

    // Prueba para la eliminación exitosa de un paciente
    public function testDeletePacienteAndPersonSuccess() {
        // Configuración del mock para obtener el ID de persona
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn('1'); // ID de persona simulado
    
        // Configuración del mock para las operaciones de borrado
        $deleteStmtMock = $this->createMock(PDOStatement::class);
        $deleteStmtMock->method('execute')->willReturn(true);
    
        // Configura las llamadas consecutivas a 'prepare'
        $this->pdoMock->method('prepare')->willReturnOnConsecutiveCalls($stmtMock, $deleteStmtMock, $deleteStmtMock);
    
        // Llamada al método del modelo y verificación
        $result = $this->patientModel->deletePacienteAndPerson(1);
        $this->assertTrue($result);
    }

    // Prueba para el fallo al eliminar un paciente
    public function testDeletePacienteAndPersonFailure() {
        // Simular que no se encuentra el paciente
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(false); // Simula que no se encuentra el paciente
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        // Esperar que se lance una excepción específica
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Paciente no encontrado");
    
        // Llamada al método del modelo que se espera que falle
        $this->patientModel->deletePacienteAndPerson(1);
    }
    

}
?>

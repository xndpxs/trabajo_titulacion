<?php
use PHPUnit\Framework\TestCase;

require_once 'model/PersonModel.php';
require_once 'model/DoctorModel.php';

class DoctorModelTest extends TestCase {
    private $pdoMock;
    private $doctorModel;

    protected function setUp(): void {
        $this->pdoMock = $this->createMock(PDO::class);
        $this->doctorModel = new DoctorModel($this->pdoMock);
    }

    public function testCreateDoctorAndPersonSuccess() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
        $this->pdoMock->method('lastInsertId')->willReturn('1');

        $result = $this->doctorModel->createDoctorAndPerson('John', 'Doe', 'john@example.com', '123 Street', '123456789', '12345', 'doctor');
        $this->assertIsString($result);
    }

    public function testCreateDoctorAndPersonFailure() {
        // Simular un fallo en la ejecución de la consulta
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->will($this->throwException(new Exception("Error al crear la persona.")));
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $this->expectException(Exception::class);
        $this->doctorModel->createDoctorAndPerson('John', 'Doe', 'john@example.com', '123 Street', '123456789', '12345', 'doctor');
    }

    public function testUpdateDoctorAndPersonSuccess() {
        // Configurar el comportamiento simulado
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        // Llamar a la función y verificar el resultado
        $result = $this->doctorModel->updateDoctorAndPerson(1, "Nombre", "Apellido", "email@example.com", "Direccion", "Telefono", "Cedula", "Password", "Rol");
        $this->assertTrue($result);
    }
    
    public function testUpdateDoctorAndPersonFailure() {
        // Configurar el comportamiento simulado para fallar
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        // Llamar a la función y verificar el resultado
        $result = $this->doctorModel->updateDoctorAndPerson(1, "Nombre", "Apellido", "email@example.com", "Direccion", "Telefono", "Cedula", "Password", "Rol");
        $this->assertFalse($result);
    }

    public function testDeleteDoctorAndPersonSuccess() {
        // Simular un ID de persona válido
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn('1'); // ID de persona simulado
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->doctorModel->deleteDoctorAndPerson(1);
        $this->assertTrue($result);
    }

    public function testDeleteDoctorAndPersonFailure() {
        // Simular que no se encuentra el doctor
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(false); // Simular que no se encuentra el doctor
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $result = $this->doctorModel->deleteDoctorAndPerson(1);
        $this->assertFalse($result); // Verificar que el resultado es false
    }

    public function testGetDoctorDetails() {
        // Simular la obtención de detalles de un doctor
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['id_doctor' => 1, 'nombre' => 'Nombre', 'apellido' => 'Apellido']);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->doctorModel->getDoctorDetails(1);
        $this->assertIsArray($result);
        $this->assertEquals(1, $result['id_doctor']);
    }

    public function testGetDoctorDetailsFailure() {
        // Simular que no se encuentran detalles del doctor
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(false); // Simular que no se encuentran detalles
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $result = $this->doctorModel->getDoctorDetails(1);
        $this->assertFalse($result); // Verificar que el resultado es false
    }
    

    // Pruebas para evitar mail o cedula repetidos

    // Test para verificar si un correo electrónico ya existe
    public function testEmailExists() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(1); // Simula que encontró un registro
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->doctorModel->emailExists('email@example.com');
        $this->assertEquals(1, $result); // Espera un ID de persona existente
    }

    public function testEmailNotExists() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(false); // Simula que no encontró registros
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->doctorModel->emailExists('email@example.com');
        $this->assertFalse($result);
    }

    public function testCedulaExists() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(1);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->doctorModel->cedulaExists('1234567890');
        $this->assertEquals(1, $result);
    }

    public function testCedulaNotExists() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        $result = $this->doctorModel->cedulaExists('1234567890');
        $this->assertFalse($result);
    }


}
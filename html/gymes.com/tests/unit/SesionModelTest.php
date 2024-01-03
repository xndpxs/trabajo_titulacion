<?php
use PHPUnit\Framework\TestCase;

require_once 'model/BaseModel.php';
require_once 'model/PersonModel.php';
require_once 'model/SesionModel.php';

class SesionModelTest extends TestCase {
    private $sesionModel;
    private $pdoMock;

    protected function setUp(): void {
        // Crear un mock del PDO para simular la base de datos
        $this->pdoMock = $this->createMock(PDO::class);

        // Inyectar el mock del PDO en SesionModel
        $this->sesionModel = new SesionModel($this->pdoMock);
    }



    public function testCrearSesionSuccess() {
        // Configurar los mocks para la inserción en la tabla `asignacion` y `sesion`
        $stmtMockAsignacion = $this->createMock(PDOStatement::class);
        $stmtMockAsignacion->method('execute')->willReturn(true);
        $stmtMockAsignacion->method('fetchColumn')->willReturn('1'); // ID de asignación simulado
    
        $stmtMockSesion = $this->createMock(PDOStatement::class);
        $stmtMockSesion->method('execute')->willReturn(true);
    
        // Configurar las llamadas consecutivas al método `prepare`
        $this->pdoMock->method('prepare')->willReturnOnConsecutiveCalls($stmtMockAsignacion, $stmtMockSesion);
    
        // Llamada al método del modelo y verificación
        $result = $this->sesionModel->crearSesion('2023-01-01', '08:00:00', 'Consultorio', 1, 1, 'Notas de la sesión');
        $this->assertTrue($result);
    }

    public function testCrearSesionFailure() {
        $stmtMockAsignacion = $this->createMock(PDOStatement::class);
        $stmtMockAsignacion->method('execute')->willReturn(false); // Simula un fallo en la inserción
    
        $this->pdoMock->method('prepare')->willReturn($stmtMockAsignacion);
    
        $this->expectException(Exception::class);
        $this->sesionModel->crearSesion('2023-01-01', '08:00:00', 'Consultorio', 1, 1, 'Notas de la sesión');
    }

    public function testLeerSesionSuccess() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetch')->willReturn(['id_sesion' => 1, 'id_asignacion' => 1, 'fecha' => '2023-01-01', 'tiempo' => '08:00:00', 'lugar' => 'Consultorio', 'notas' => 'Notas de la sesión']);
    
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $result = $this->sesionModel->leerSesion(1);
        $this->assertIsArray($result);
        $this->assertEquals('Consultorio', $result['lugar']);
    }

    public function testLeerSesionFailure() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
    
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $this->expectException(Exception::class);
        $this->sesionModel->leerSesion(1);
    }

    public function testDeleteSesionSuccess() {
        // Configuración del mock para simular un ID de sesión que no existe
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('rowCount')->willReturn(0); // Simula que no se encontró la sesión
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        // Espera que se lance una excepción específica
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('La sesión a eliminar no fue encontrada.');
    
        // Llamada al método del modelo
        $this->sesionModel->deleteSesion(1);
    }
    

    public function testDeleteSesionFailure() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
    
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $this->expectException(Exception::class);
        $this->sesionModel->deleteSesion(1);
    }

    public function testExisteSesionSuccess() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(1);
    
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $result = $this->sesionModel->existeSesion('2023-01-01', '08:00:00', 1);
        $this->assertTrue($result);
    }

    public function testExisteSesionFailure() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchColumn')->willReturn(0);
    
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $result = $this->sesionModel->existeSesion('2023-01-01', '08:00:00', 1);
        $this->assertFalse($result);
    }
    
    




}
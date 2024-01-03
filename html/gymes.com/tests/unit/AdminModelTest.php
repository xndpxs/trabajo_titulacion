<?php
use PHPUnit\Framework\TestCase;

require_once 'model/PersonModel.php';
require_once 'model/AdminModel.php';

class AdminModelTest extends TestCase {
    private $pdoMock;
    private $adminModel;

    protected function setUp(): void {
        // Mock del objeto PDO
        $this->pdoMock = $this->createMock(PDO::class);

        // Crear una instancia de AdminModel con el mock de PDO
        $this->adminModel = new AdminModel($this->pdoMock);
    }

    public function testUpdateAdminPerson() {
        // Datos de entrada simulados
        $postData = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'direccion' => 'Calle 123',
            'telefono' => '1234567890',
            'cedula' => '1234567890',
            'email' => 'juan@example.com',
            'password' => 'password123'
        ];
        $idPersona = 1;

        // Preparar el objeto PDOStatement mock
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Realizar la prueba
        $result = $this->adminModel->updateAdminPerson($postData, $idPersona);
        $this->assertTrue($result);
    }

    public function testUpdateAdminPersonFailure() {
        // Datos de entrada simulados
        $postData = [
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            // ... (otros campos)
            'password' => 'password123'
        ];
        $idPersona = 1;

        // Preparar el objeto PDOStatement mock para simular un fallo
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false); // Simula un fallo en la ejecución
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Realizar la prueba
        $result = $this->adminModel->updateAdminPerson($postData, $idPersona);
        $this->assertFalse($result); // Esperamos false como resultado de un fallo
    }


}
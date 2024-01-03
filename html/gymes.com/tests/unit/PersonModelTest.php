<?php
use PHPUnit\Framework\TestCase;

require_once 'model/BaseModel.php';
require_once 'model/PersonModel.php';

class PersonModelTest extends TestCase {
    private $pdoMock;
    private $stmtMock;
    private $personModel;

    protected function setUp(): void {
        // Mock del objeto PDO
        $this->pdoMock = $this->createMock(PDO::class);
        
        // Mock del objeto PDOStatement
        $this->stmtMock = $this->createMock(PDOStatement::class);

        // Crear una instancia de PersonModel con el mock de PDO
        $this->personModel = new PersonModel($this->pdoMock);
    }


    public function testCreatePerson() {
        // Configurar el PDOStatement mock para simular la inserción
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
        $this->pdoMock->method('lastInsertId')->willReturn('1');

        // Llamar al método createPerson y verificar el resultado
        $result = $this->personModel->createPerson('Nombre', 'Apellido', 'email@example.com', 'Direccion', '123456789', '0123456789', 'password', 'rol');
        $this->assertEquals(1, $result);
    }

    public function testCreatePersonWithError() {
        // Configurar el PDOStatement mock para simular un error en la inserción
        $this->stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        // Llamar al método createPerson y verificar el resultado
        $result = $this->personModel->createPerson('Nombre', 'Apellido', 'email@example.com', 'Direccion', '123456789', '0123456789', 'password', 'rol');
        $this->assertFalse($result);
    }

    
    public function testUpdatePerson() {
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        $updated = $this->personModel->updatePerson(1, 'NuevoNombre', 'NuevoApellido', 'nuevoemail@example.com', 'NuevaDireccion', '1234567890', '0123456789', 'nuevopassword', 'rol');
        $this->assertTrue($updated);
    }

    public function testUpdatePersonWithError() {
        $this->stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        $updated = $this->personModel->updatePerson(1, 'NuevoNombre', 'NuevoApellido', 'nuevoemail@example.com', 'NuevaDireccion', '1234567890', '0123456789', 'nuevopassword', 'rol');
        $this->assertFalse($updated);
    }

    public function testDeletePerson() {
        $this->stmtMock->method('execute')->willReturn(true);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        $deleted = $this->personModel->deletePerson(1);
        $this->assertTrue($deleted);
    }

    public function testDeletePersonWithError() {
        $this->stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);

        $deleted = $this->personModel->deletePerson(1);
        $this->assertFalse($deleted);
    }

    public function testGetPersonDetails() {
        // Configurar el PDOStatement mock para simular una respuesta exitosa
        $expectedResult = ['id' => 1, 'nombre' => 'Nombre', 'apellido' => 'Apellido'];
        $this->stmtMock->method('fetch')->willReturn($expectedResult);
        $this->stmtMock->method('execute')->willReturn(true); // Asegúrate de que execute devuelva true
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
    
        // Llamar al método getPersonDetails y verificar el resultado
        $result = $this->personModel->getPersonDetails(1);
        $this->assertEquals($expectedResult, $result);
    }

    public function testGetPersonDetailsWithError() {
        $this->stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($this->stmtMock);
    
        $result = $this->personModel->getPersonDetails(1);
        $this->assertFalse($result);
    }
    

    
}


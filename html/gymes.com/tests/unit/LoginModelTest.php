<?php
use PHPUnit\Framework\TestCase;

require_once 'model/BaseModel.php';
require_once 'model/PersonModel.php';
require_once 'model/LoginModel.php';

class LoginModelTest extends TestCase
{
    private $loginModel;
    private $pdoMock;

    protected function setUp(): void
    {
        // Crear un mock del PDO para simular la base de datos
        $this->pdoMock = $this->createMock(PDO::class);

        // Inyectar el mock del PDO en LoginModel
        
        $this->loginModel = new LoginModel($this->pdoMock);
    }

    public function testVerificarUsuarioConCredencialesCorrectas()
    {
        // Configurar el mock del PDOStatement para simular una respuesta de la base de datos
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturn((object)['password' => password_hash('passwordCorrecta', PASSWORD_DEFAULT), 'rol' => 'admin']);
        $stmtMock->method('rowCount')->willReturn(1);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Realizar la prueba
        $resultado = $this->loginModel->verificarUsuario('usuario@example.com', 'passwordCorrecta');
        $this->assertEquals('admin', $resultado);
    }

    public function testVerificarUsuarioConCredencialesIncorrectas()
    {
        // Configurar el mock para simular que no se encontró el usuario
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('rowCount')->willReturn(0);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);

        // Realizar la prueba
        $resultado = $this->loginModel->verificarUsuario('usuario@example.com', 'passwordIncorrecta');
        $this->assertFalse($resultado);
    }

    public function testErrorEnEjecucionDeConsultaSQL() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('execute')->willReturn(false);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $resultado = $this->loginModel->verificarUsuario('usuario@example.com', 'password');
        $this->assertFalse($resultado);
    }
    
    public function testVerificarUsuarioConPasswordIncorrecto() {
        $stmtMock = $this->createMock(PDOStatement::class);
        $stmtMock->method('fetch')->willReturn((object)['password' => password_hash('passwordCorrecta', PASSWORD_DEFAULT), 'rol' => 'admin']);
        $stmtMock->method('rowCount')->willReturn(1);
        $this->pdoMock->method('prepare')->willReturn($stmtMock);
    
        $resultado = $this->loginModel->verificarUsuario('usuario@example.com', 'passwordIncorrecta');
        $this->assertFalse($resultado);
    }

    
}

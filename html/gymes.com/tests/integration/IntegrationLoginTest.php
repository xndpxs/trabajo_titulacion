<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;


class IntegrationLoginTest extends TestCase
{
    protected $webDriver;

    public function setUp(): void
    {
        $host = 'http://selenium:4444/wd/hub'; // URL del servidor Selenium
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
    }

    public function tearDown(): void
    {
        $this->webDriver->quit();
    }

    public function testLogin()
    {
        $this->webDriver->get('http://web/gymes.com/view/LoginView.php'); // URL de tu formulario de login

        // Encuentra y completa el campo de email
        $emailField = $this->webDriver->findElement(WebDriverBy::name('email'));
        $emailField->sendKeys('admin@gymes.com');

        // Encuentra y completa el campo de contraseña
        $passwordField = $this->webDriver->findElement(WebDriverBy::name('password'));
        $passwordField->sendKeys('1111');

        // Encuentra y hace clic en el botón de enviar
        $submitButton = $this->webDriver->findElement(WebDriverBy::name('login'));
        $submitButton->click();

        // Espera y verifica el resultado esperado
        $this->assertStringContainsString('Panel de Control', $this->webDriver->getTitle());
    }
}

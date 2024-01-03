<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use PHPUnit\Framework\TestCase;

class IntegrationAddSesionPaciente extends TestCase {
    protected $webDriver;

    public function setUp(): void {
        $host = 'http://selenium:4444/wd/hub'; // URL del servidor Selenium
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
    }

    public function tearDown(): void {
        $this->webDriver->quit();
    }

    public function testAgendarCita() {
        // Paso 1: Iniciar sesión como paciente
        $this->webDriver->get('http://web/gymes.com/view/LoginView.php');
        $this->webDriver->findElement(WebDriverBy::name('email'))->sendKeys('milo@gymes.com'); // Usar un email de paciente real
        $this->webDriver->findElement(WebDriverBy::name('password'))->sendKeys('3333'); // Usar contraseña real del paciente
        $this->webDriver->findElement(WebDriverBy::name('login'))->click();

        // Paso 2: Navegar al panel de control del paciente
        $wait = new WebDriverWait($this->webDriver, 20);
        $wait->until(WebDriverExpectedCondition::titleIs('Panel de Control'));

        // Paso 3: Ir a la gestión de citas
        $this->webDriver->findElement(WebDriverBy::id('btnGestion'))->click();

        // Paso 4: Verificar si se muestra el formulario de agendar citas o el modal de cita existente
        try {
            $wait = new WebDriverWait($this->webDriver, 10);
            $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('agendarCitaForm')));
            $formDisplayed = $this->webDriver->findElement(WebDriverBy::id('agendarCitaForm'))->isDisplayed();
        } catch (Exception $e) {
            $formDisplayed = false;
        }

        try {
            $wait = new WebDriverWait($this->webDriver, 10);
            $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('citaExistenteModal')));
            $modalDisplayed = $this->webDriver->findElement(WebDriverBy::id('citaExistenteModal'))->isDisplayed();
        } catch (Exception $e) {
            $modalDisplayed = false;
        }

        // Afirmar que se muestra uno de los dos
        $this->assertTrue($formDisplayed || $modalDisplayed, 'Ni el formulario de agendar cita ni el modal de cita existente se mostraron.');
    }
}
?>

<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use PHPUnit\Framework\TestCase;

class IntegrationAddPatientTest extends TestCase
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

    public function testAddPatient()
    {
        // Paso 1: Iniciar sesión como administrador
        $this->webDriver->get('http://web/gymes.com/view/LoginView.php');
        $this->webDriver->findElement(WebDriverBy::name('email'))->sendKeys('house@gymes.com');
        $this->webDriver->findElement(WebDriverBy::name('password'))->sendKeys('2222');
        $this->webDriver->findElement(WebDriverBy::name('login'))->click();

        // Esperar a que se redirija automáticamente al dashboard
        $wait = new WebDriverWait($this->webDriver, 20); // Esperar hasta 20 segundos
        $wait->until(WebDriverExpectedCondition::titleIs('Panel de Control'));

        // Paso 2: Identificar la tarjeta de 'Gestión de pacientes' y hacer clic en el botón 'Ir a Gestión'
        $wait = new WebDriverWait($this->webDriver, 10); // Esperar hasta 10 segundos
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath("//h5[contains(text(), 'Gestión de pacientes')]/../..//a[contains(text(), 'Ir a Gestión')]")));
        $this->webDriver->findElement(WebDriverBy::xpath("//h5[contains(text(), 'Gestión de pacientes')]/../..//a[contains(text(), 'Ir a Gestión')]"))->click();

        // Asegurarse de que ha llegado a gestionPacientesView.php
        $wait->until(WebDriverExpectedCondition::titleIs('Gestión de Pacientes'));
        
        // Paso 3: Abrir el modal para agregar un nuevo paciente
        // Suponiendo que el botón para abrir el modal tiene un ID específico
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('addPatientButton')));
        $this->webDriver->findElement(WebDriverBy::id('addPatientButton'))->click();
        
        // Paso 4: Verificar que el modal se ha abierto
        // Aquí buscamos un elemento único dentro del modal que indique que está abierto
        $wait = new WebDriverWait($this->webDriver, 20); // Esperar hasta 20 segundos
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('addPatientModal')));

        // Afirmar que el modal está abierto
        $this->assertTrue(
            $this->webDriver->findElement(WebDriverBy::id('addPatientModal'))->isDisplayed(),
            'El modal para agregar paciente no se ha abierto.'
        );    
    }
}
?>
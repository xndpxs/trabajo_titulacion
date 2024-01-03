<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use PHPUnit\Framework\TestCase;

class IntegrationAddDoctorTest extends TestCase
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

    public function testAddDoctor()
    {
        // Paso 1: Iniciar sesión como administrador
        $this->webDriver->get('http://web/gymes.com/view/LoginView.php');
        $this->webDriver->findElement(WebDriverBy::name('email'))->sendKeys('admin@gymes.com');
        $this->webDriver->findElement(WebDriverBy::name('password'))->sendKeys('1111');
        $this->webDriver->findElement(WebDriverBy::name('login'))->click();

        // Esperar a que se redirija automáticamente al dashboard y luego a Gestión de Doctores
        $wait = new WebDriverWait($this->webDriver, 20); // Esperar hasta 10 segundos
        $wait->until(WebDriverExpectedCondition::titleIs('Panel de Control'));

        //Paso 3: Identificar la tarjeta de 'Gestión de doctores' y hacer clic en el botón 'Ir a Gestión'
        $wait = new WebDriverWait($this->webDriver, 10); // Esperar hasta 10 segundos
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath("//h5[contains(text(), 'Gestión de doctores')]/../..//a[contains(text(), 'Ir a Gestión')]")));
        $this->webDriver->findElement(WebDriverBy::xpath("//h5[contains(text(), 'Gestión de doctores')]/../..//a[contains(text(), 'Ir a Gestión')]"))->click();

        //Asegurarse de que ha llegado a gestionDoctoresView.php
        $wait->until(WebDriverExpectedCondition::titleIs('Gestión de Doctores'));
        
        // Paso 4: Abrir el modal para agregar un nuevo doctor
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('addDoctorButton')));
        $this->webDriver->findElement(WebDriverBy::id('addDoctorButton'))->click();
        
        // Paso 5: Verificar que el modal se ha abierto
        // Aquí debes buscar un elemento único dentro del modal que indique que está abierto
        $wait = new WebDriverWait($this->webDriver, 20); // Esperar hasta 20 segundos
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('addDoctorModal')));

        // Afirmar que el modal está abierto
        $this->assertTrue(
            $this->webDriver->findElement(WebDriverBy::id('addDoctorModal'))->isDisplayed(),
            'El modal para agregar doctor no se ha abierto.'
        );    

    }
}
?>

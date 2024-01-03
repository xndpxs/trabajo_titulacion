<?php
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\WebDriverWait;
use PHPUnit\Framework\TestCase;

class IntegrationAddSesionTest extends TestCase {
    protected $webDriver;

    public function setUp(): void {
        $host = 'http://selenium:4444/wd/hub'; // URL del servidor Selenium
        $this->webDriver = RemoteWebDriver::create($host, DesiredCapabilities::chrome());
    }

    public function tearDown(): void {
        $this->webDriver->quit();
    }

    public function testAddSession() {
        // Paso 1: Iniciar sesión
        $this->webDriver->get('http://web/gymes.com/view/LoginView.php');
        $this->webDriver->findElement(WebDriverBy::name('email'))->sendKeys('house@gymes.com');
        $this->webDriver->findElement(WebDriverBy::name('password'))->sendKeys('2222');
        $this->webDriver->findElement(WebDriverBy::name('login'))->click();

        // Paso 2: Esperar a que se redirija automáticamente al dashboard
        $wait = new WebDriverWait($this->webDriver, 20);
        $wait->until(WebDriverExpectedCondition::titleIs('Panel de Control'));

        // Paso 3: Ir a Gestión de Citas (ajustar XPath según la estructura HTML real)
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::xpath("//h5[contains(text(), 'Administración de Citas')]/../..//a[contains(text(), 'Administrador de Citas')]")));
        $this->webDriver->findElement(WebDriverBy::xpath("//h5[contains(text(), 'Administración de Citas')]/../..//a[contains(text(), 'Administrador de Citas')]"))->click();

        // Paso 4: Abrir el modal para agregar una nueva sesión
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('addSesionButton')));
        $this->webDriver->findElement(WebDriverBy::id('addSesionButton'))->click();

        // Paso 5: Verificar que el modal está abierto
        $wait = new WebDriverWait($this->webDriver, 20);
        $wait->until(WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('createSesionModal')));

        // Afirmar que el modal está abierto
        $this->assertTrue(
            $this->webDriver->findElement(WebDriverBy::id('createSesionModal'))->isDisplayed(),
            'El modal para agregar sesión no se ha abierto.'
        );
    }
}
?>

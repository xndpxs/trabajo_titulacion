<?php
require '../utils/Session.php';
//require '../config/config.php';
require '../model/LoginModel.php';
require '../utils/Request.php';

class SessionController {

    private $loginModel;
    private $request;
    private $session;
    private $recaptcha_secret;

    public function __construct($loginModel, $request, $session, $recaptcha_secret) {
        $this->loginModel = $loginModel;
        $this->request = $request;
        $this->session = $session;
        $this->recaptcha_secret = $recaptcha_secret;
    }

    public function login() {
        $this->session->start();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        // Verificación del token CSRF aquí
        $csrf_token = $this->request->post('csrf_token');
        if (!$this->session->has('csrf_token') || $csrf_token !== $this->session->get('csrf_token')) {
            $this->redirectWithError('Error de validación CSRF.');
            return;
        }

        if (!$this->verifyRecaptcha()) {
            $this->redirectWithError('El reCAPTCHA es incorrecto.');
            return;
        }

        $email = $this->request->post('email');
        $password = $this->request->post('password');

        if (empty($email) || empty($password)) {
            $this->redirectWithError('Por favor, completa todos los campos.');
            return;
        }

        $rol = $this->loginModel->verificarUsuario($email, $password);
        // Debugging: Verificar qué rol está devolviendo
        //var_dump("Rol:", $rol);
        //exit();
        $personIdByEmail = $this->loginModel->getPersonIdByEmail($email);
        $idByEmail = $this->loginModel->getPersonIdByEmail($email);
        $this->session->set('id_persona', $idByEmail);
        //var_dump($idByEmail);
        //exit();


        if (!$rol) {
            $this->redirectWithError('Correo electrónico o contraseña incorrectos.');
            return;
        }

        $primerLogin = $this->loginModel->esPrimerLogin($email);
        //var_dump("Es primer login:", $primerLogin);
        //exit();
        $this->handleSuccessfulLogin(['rol' => $rol, 'primer_login' => $primerLogin]);
    }

    private function verifyRecaptcha() {
        // Omitir la verificación de captcha si estamos en modo de prueba
        if (getenv('APP_ENV') === 'testing') {
            return true;
        }
    
        $captchaResponse = $this->request->post('g-recaptcha-response');
        $response = @file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$this->recaptcha_secret}&response={$captchaResponse}");
    
        if (!$response) {
            return false;
        }
    
        $responseKeys = json_decode($response, true);
        return isset($responseKeys["success"]) && $responseKeys["success"];
    }

    private function handleSuccessfulLogin($loginData) {
        $this->session->set('rol', $loginData['rol']);

        if ($loginData['primer_login']) {            
            header("Location: ../view/firstLoginView.php");
            exit();
        }
    
        // Si llegamos hasta aquí, no es el primer login, así que establecemos el estado de 'login_active' y redirigimos al dashboard correspondiente.
        $this->session->set('login_active', true);
        
        
        switch ($loginData['rol']) {
            case 'paciente':
                header("Location: ../view/paciente/dashboard.php");
                break;
            case 'administrador':
                header("Location: ../view/admin/dashboard.php");
                break;
            case 'doctor':
                header("Location: ../view/doctor/dashboard.php");
                break;
            default:
                header("Location: ../index.php");
                break;
        }
        exit();
    }

    private function redirectWithError($message) {
        $this->session->set('errors', $message);
        header('Location: ../view/LoginView.php');
        exit();
    }

    public function logout() {
        $this->session->start();

        if ($this->session->has('login_active')) {
            $this->session->destroy();
            header("Location: ../index.php");
            exit;
        }
        header("Location: ../index.php");
        exit;
    }

    public function processAction() {
        $action = isset($_GET['action']) ? $_GET['action'] : null;

        switch ($action) {
            case 'login':
                $this->login();
                break;
            case 'logout':
                $this->logout();
                break;
            default:
                // Acción no reconocida
                header("Location: ../index.php");
                break;
        }
    }
}

$loginModel = new LoginModel($conn);
$request = new Request();
$session = new Session();
$controller = new SessionController($loginModel, $request, $session, $recaptcha_secret);
$controller->processAction();

?>
<?php
ob_start();
include_once '../utils/Session.php';
$session = new Session();
$session->start();
$returnUrl = $session->get('return_url');

include_once '../controller/passwordResetController.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new PasswordResetController($conn);
    // Obtener y validar el token CSRF
    $csrf_token = $_POST['csrf_token'] ?? '';
    if (!$session->isValidCsrfToken($csrf_token)) {
        $session->set('error_message', 'Error de seguridad. Intente nuevamente.');
        header("Location: passwordResetView.php");
        exit;
    }

    // Pasar tanto el correo electrónico como el token CSRF
    if ($controller->resetPassword($_POST['email'])) {
        $session->set('success_message', 'Por favor, revise su correo electrónico para obtener la nueva contraseña.');
        sleep(5);
        // Redirige a la página de inicio de sesión
        header("Location: LoginView.php");
        exit;
    } else {
        $session->set('error_message', 'Ocurrió un error al restablecer la contraseña. Correo no encontrado');
    }
}

if ($session->has('error_message')) {
    $errorMessage = $session->get('error_message');
    $session->remove('error_message');
}

if ($session->has('success_message')) {
    $successMessage = $session->get('success_message');
    $session->remove('success_message');
}

include_once './includes/header.php';
ob_end_flush();
?>

<main class="container py-5 text-center">
    <?php if (isset($errorMessage)) : ?>
        <div id="error-message" class="text-danger mt-2">
            <?php echo $errorMessage; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($successMessage)) : ?>
        <div id="success-message" class="text-success mt-2">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form action="passwordResetView.php" method="post">
        <h1 class="h3 mb-3 fw-bold">Olvidé mi contraseña</h1>
        <div class="form-floating col-12 col-lg-4 mx-auto">
            <input name="email" type="email" class="form-control" id="floatingEmail" placeholder="name@example.com">
            <label for="floatingEmail">Dirección de E-mail</label>
        </div>

        <button name="reset" class="btn btn-primary btn-lg px-4 gap-3 mt-3" type="submit">Restablecer contraseña</button>
        <a href="LoginView.php" class="btn btn-outline-secondary btn-lg px-4 gap-3 mt-3">Regresar</a>

        <!--CSRF TOKEN-->
        <input type="hidden" name="csrf_token2" value="<?php echo htmlspecialchars($session->getCsrfToken()); ?>">
    </form>
</main>
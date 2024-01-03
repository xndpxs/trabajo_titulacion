<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../assets/phpmailer/src/Exception.php';
require __DIR__ . '/../assets/phpmailer/src/PHPMailer.php';
require __DIR__ . '/../assets/phpmailer/src/SMTP.php';

function sendMail($to, $subject, $message) {
    $mail = new PHPMailer(true);

    try {
        // Configuraciones del servidor
        $mail->SMTPDebug = 0;                                       // Habilitar el debug (0 para deshabilitarlo, 1 para mensajes del cliente, 2 para cliente y servidor)
        $mail->isSMTP();                                            // Usar SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Servidor SMTP
        $mail->SMTPAuth   = true;                                   // Habilitar autenticación SMTP
        $mail->Username   = EMAIL;                                  // Correo del SMTP
        $mail->Password   = APP_PASSWORD;                           // Contraseña o clave de app del SMTP
        $mail->SMTPSecure = 'tls';                                  // Habilitar encriptación TLS, `ssl` también es aceptada
        $mail->Port       = 587;                                    // Puerto para conectarse con el servidor

        // Destinatarios
        $mail->setFrom(EMAIL, 'Gymes Test'); // Quien envía el correo
        $mail->addAddress($to);                                     // A quien va dirigido

        // Contenido
        $mail->isHTML(true);                                        // Habilitar contenido HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        return true;
    } catch (Exception $e) {
        return "No se pudo enviar el correo: {$mail->ErrorInfo}";
    }
}
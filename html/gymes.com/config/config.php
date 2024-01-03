<?php
$servername = "db";
$username = "root";
$password = "xxxx";
$dbname = "gymes";
$recaptcha_secret = "xxxx";
define('EMAIL', 'xxxx@xxxx');
define('APP_PASSWORD', 'xxxx');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // establece el modo de error de PDO a excepción
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "conexion exitosa"; //No es recomendado imprimir nada en el archivo de configuración, podría interferir con las redirecciones.
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

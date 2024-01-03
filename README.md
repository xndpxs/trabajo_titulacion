# Prototipo de Página web de un Centro Médico de Fisioterapia.

## Descripción
Este proyecto fue realizado como parte del trabajo de titulación.

## Instalación
- Agregar contraseñas al archivo `docker-compose.yml`

### Configuración de la página
- Dentro de `html/gymes.com` existe el archivo `config/config.php`. Agregar la contraseña de la base de datos que se agregó en el `docker-compose.yml`
- Para que funcione el captcha se necesita agregar la contraseña de Google Captcha v2.
- Se necesita un e-mail y una contraseña para poder hacer uso del servicio de correo, desde donde saldrán los mails de notificacion
- Para las pruebas y otros problemas, seguir el README.md indicado dentro de `html/gymes.com`

## Uso
- Instalar Docker.
- `docker compose up` en la raíz del proyecto.
- Agregar la base de datos `gymesv11.sql` que se encuentra en `html/gymes.com` a PHPMyAdmin. A la página web se puede ingresar mediante `http://localhost:8080/gymes.com` y a PHPMyAdmin mediante `http://localhost:8081/` como fue definido en el `docker-compose.yml`.

## Configuración y Ejecución del Proyecto
Este proyecto utiliza Docker y Composer para manejar sus dependencias y entorno de ejecución. Aquí están los pasos para configurar y ejecutar el proyecto en tu máquina local.

## Prerrequisitos
Asegúrate de tener instalado Docker y Docker Compose en tu máquina. Para verificar, puedes ejecutar:

## Configuración en una nueva Máquina
 `docker-compose up -d`
- Utiliza `docker-compose up --build` si es necesario reconstruir las imágenes después de realizar cambios en el Dockerfile.
### Para instalar las dependencias de composer como PHPMailer y PHPUnit
`docker-compose run web composer install`

## Ejecución de Pruebas con PHPUnit
Para garantizar la calidad y el correcto funcionamiento del código, este proyecto utiliza pruebas automatizadas con PHPUnit. Las pruebas se pueden ejecutar dentro del contenedor Docker para asegurar un entorno consistente.

### Ejecutando Pruebas
Para ejecutar las pruebas, usa el siguiente comando:

`docker compose exec web php vendor/bin/phpunit tests/unit/<nombre_prueba>.php`

Este comando ejecuta las pruebas definidas en <nombre_prueba>.php **dentro del contenedor Docker**. Asegúrate de que el contenedor esté en ejecución antes de ejecutar este comando. Asegurarse tambien de estar en gymes.com/ en la raiz del proyecto.

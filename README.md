# Proyecto OS-Telesalud

### Instalación
* Clonar repositorio
* Copiar `.env.example` a `.env` y configurar los parámetros deseados. Los parámetros relevantes tienen comentarios
* Si desea montar un servidor de desarrollo reemplace `docker-compose.yml` por `docker-compose.dev.yml`
* El uso de HTTPS es obligatorio para las videoconsultas. Se debe obtener un certificado y clave SSL y ubicarlos en el directorio `docker-config`. Los archivos se deben llamar `cert.crt` y `cert.key`
  * Para uso en servidor local, puede generar un certificado auto firmado: `openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker-config/cert.key -out docker-config/cert.crt`
* Ejecutar `docker-compose up` (puede agregar `-d` para ejecutar en modo dettached)
* Por única vez, ejecutar:
  * `docker-compose exec app composer install`. Esto instalará librerías externas
  * `docker-compose exec app php artisan key:generate`. Esto generará una clave única de Laravel
  * `docker-compose exec app php artisan migrate`. Esto creará las tablas necesarias en la base de datos

### API
Los endpoints de la API permiten generar videoconsultas y descargar todos los datos referidos a las mismas. Para más información, lea la [documentación de la API](https://documenter.getpostman.com/view/2176254/2s847HPYG1)

### Generar un token de API
Los servicios de la API están protegidos por autenticación vía token utilizando Laravel Sanctum.
Para consumir los servicios de la API se debe generar un token, existe un comando especial de `artisan` diseñado para crear un usuario si no existe y generar un token para el mismo.  
Para generar un token, ejecuta `docker-compose exec app php artisan token:issue`.  
El token generado se debe usar en las peticiones a la API en una cabecera de HTTP: `Authorization: Bearer <token>`. Los tokens no tienen fecha de expiración y se pueden generar tantos tokens como sea necesario. Si desea un control más específico de los tokens, consulta la [documentación de Laravel Sanctum](https://laravel.com/docs/9.x/sanctum).

### Notificaciones
Opcionalmente se puede configurar una URL a la cual el sistema enviará notificaciones de cambios relevantes en videoconsultas. Para activar esta funcionalidad se debe configurar el parámetro `NOTIFICATION_URL` en el archivo `.env`.   
Adicionalmente se puede configurar un token secreto en caso de que el endpoint esté securizado, el token configurado en el parámetro `NOTIFICATION_TOKEN` se enviará como Bearer token en cada notificación.  
Las notificaciones se envían a la URL configurada como `POST`, el cuerpo de la petición contiene los siguientes datos en formato `json`
* `vc`: Contiene un objeto con los datos relevantes de la videoconsulta
* `topic`: Indica el tipo de notificación, el cuál puede ser:
  * `medic-set-attendance`: El médico ingresa a la videoconsulta
  * `medic-unset-attendance`: El médico cierra la pantalla de videoconsulta
  * `videoconsultation-started`: Se da por iniciada la videoconsulta, esto se da cuando tanto el médico como el paciente están presentes
  * `videoconsultation-finished`: El médico presiona el botón `Finalizar consulta`
  * `patient-set-attendance`: El paciente anuncia su presencia

### Jitsi
Este módulo utiliza Jitsi como servicio de videoconsultas, puede utilizar el [servicio gratuito de Jitsi](https://meet.jit.si/) o una instalación alojada por usted mismo. Revise el parámetro `JITSI_PROVIDER` en el archivo `.env`.   
Este repositorio contiene una instancia preconfigurada lista para usar. Para más información consulte el [archivo README.md](jitsi-docker/README.md) en el directorio `jitsi-docker`.

### Mesa de ayuda
Opcionalmente, se puede utilizar una solución de mesa de ayuda brindada por el proyecto [Freescout](https://freescout.net/). Para activar la integración de este módulo con Freescout, configure el parametro `HELPDESK_EMAIL` en el archivo `.env`.  
Este repositorio contiene una instancia preconfigurada lista para usar. Para más información consulte el [archivo README.md](freescout-docker/README.md) en el directorio `freescout-docker`.

### Personalización
Para personalizar esta aplicación, se pueden reemplazar los logos y el favicon, todo se encuentra dentro de la carpeta `public`.   
Los estilos CSS están basados en [Bulma](https://bulma.io/). Para personalizar los colores se debe recompilar el archivo `public/css/telesalud.bulma.min.css`. Para más información visite la [documentación personalización de Bulma](https://bulma.io/documentation/customize/).

## English

### Installation
* Clone repository
* Copy `.env.example` to `.env` and set up desired settings. Relevant settings are commented
* If you are running on dev server replace `docker-compose.yml` with `docker-compose.dev.yml`
* HTTPS use is mandatory for videoconsultations. You must get an SSL certificate and key, and place them in `docker-config` directory, the files should be named `cert.crt` and `cert.key`
  * To run in localhost, you can generate a self-signed certificate: `openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout docker-config/cert.key -out docker-config/cert.crt`
* Run `docker-compose up` (You can add `-d` to run in dettached mode)
* Just the first time, run:
  * `docker-compose exec app composer install`. This will install external libraries
  * `docker-compose exec app php artisan key:generate`. This will generate your Laravel instance's `APP KEY`
  * `docker-compose exec app php artisan migrate`. This will create necesary tables in the database

### API
API endpoints allow you to create videoconsultations and download data. Please refer to the [API Documentation](https://documenter.getpostman.com/view/2176254/2s847HPYG1)

### Issuing an API Token
API Endpoints are protected by authentication via token provided by Laravel Sanctum.
In order to consume API endpoints you must issue a token, there's a custom `artisan` command designed to create an user if doesn't exists and issue a token for that user.  
To issue a token, simply run `docker-compose exec app php artisan token:issue`.  
This token should be used on API requests as an HTTP Header: `Authorization: Bearer <token>`. Tokens do not expire and you can issue as many as needed, for more granular control on tokens, refer to [Laravel Sanctum documentation](https://laravel.com/docs/9.x/sanctum)

### Notifications
Optionally, you can set an URL to send notifications about relevant teleconsultations changes to an external system. To enable this functionality you must set the `NOTIFICATION_URL` parameter in `.env` file.  
You can also set a secret token in case your endpoint is protected, to enable this you must set the `NOTIFICATION_TOKEN`, this value will be sent in notifications as a Bearer token.  
Notifications are sent as a `POST` request, each notification will contain relevant data in its body in `json` format with these properties:
* `vc`: Contains an object with videoconsultation's relevant data
* `topic`: This indicates the notification type, which can be:
  * `medic-set-attendance`: Medic enters the videoconsultation
  * `medic-unset-attendance`: Medic closes the videoconsultation window
  * `videoconsultation-started`: The videoconsultation starts, this is fired then both medic and patient are in the videoconsultation
  * `videoconsultation-finished`: Medic presses the `Finish consultation` button
  * `patient-set-attendance`: Patient announces its presence

### Jitsi
This module uses Jitsi as a backend to run videoconsultations, you can use [Jitsi's free service](https://meet.jit.si/) or a self-hosted instance. Please refer to the `JITSI_PROVIDER` parameter in `.env` file.   
This repository contains a pre-configured Jitsi self-hosted instance. Please refer to [Jitsi Docker's Readme.md](jitsi-docker/README.md) in `jitsi-docker` directory

### Helpdesk
Optionally, you can use a helpdesk solution powered by the [Freescout project](https://freescout.net/). In order to enable Freescout integration, please set the `HELPDESK_EMAIL` parameter in `.env` file.  
This repository contains a pre-configured Freescout instance. Please refer to [Readme.md file](jitsi-docker/README.md) in `freescout-docker` directory.

### Customization
To customize this app, you can replace logos and favicon, everything is located in the `public` directory.   
CSS stylesheet is based on [Bulma](https://bulma.io/). To customize color schemes you must recompile the `public/css/telesalud.bulma.min.css` file. More info on [Bulma's customization docs](https://bulma.io/documentation/customize/)

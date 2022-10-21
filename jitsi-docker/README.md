# Jitsi Meet on Docker

[Jitsi](https://jitsi.org/) is a set of Open Source projects that allows you to easily build and deploy secure videoconferencing solutions.

[Jitsi Meet](https://jitsi.org/jitsi-meet/) is a fully encrypted, 100% Open Source video conferencing solution that you can use all day, every day, for free — with no account needed.

### Installation
This is a quick guide to setup your Jitsi self hosted instance, for more detailed info refer to [Jitsi docs](https://jitsi.github.io/handbook/docs/devops-guide/devops-guide-docker/)
* Copy `.env.example` to `.env` and customize the following parameters.
  * `HTTP_PORT`: Port to listen to HTTP connections, will automatically redirect to HTTPS
  * `HTTPS_PORT`: Port to listen to HTTPS connections
  * `TZ`: Timezone
  * `PUBLIC_URL`: URL for the service
  * `JWT_APP_ID`: An unique string to identify the application, this has to match Laravel's `JITSI_APP_ID` parameter
  * `JWT_APP_SECRET`: A secret string, this has to match Laravel's `JWT_APP_SECRET` parameter
* Run `docker-compose up -d`

### Español
Esta es una guía rápida para poner en funcionamiento su propia instancia de Jitsi, para más información visite la [documentación de Jitsi](https://jitsi.github.io/handbook/docs/devops-guide/devops-guide-docker/) (en inglés)
* Copiar `.env.example` a `.env` y configure los siguientes parámetros.
    * `HTTP_PORT`: Puerto en el que se escucharán las conexiones HTTP, estas serán redireccionadas automáticamente a HTTPS
    * `HTTPS_PORT`: Puerto en el que se escucharán las conexiones HTTPS
    * `TZ`: Zona horaria
    * `PUBLIC_URL`: URL pública donde será alojado el servicio
    * `JWT_APP_ID`: Una cadena de texto única, debe coincidir con el parámetro `JITSI_APP_ID` de la instalación de Laravel
    * `JWT_APP_SECRET`: Una cadena de texto secreta, debe coincidir con el parámetro `JWT_APP_SECRET` de la instalación de Laravel
* Ejecute `docker-compose up -d`

# Freescout on Docker

[FreeScout](https://freescout.net/) is the super lightweight and powerful free open source help desk and shared inbox.  

This is a `docker-compose` bundle composed of `tiredofit/docker-freescout` Freescout docker image ([Github](https://github.com/tiredofit/docker-freescout)) and `DanielDent/docker-nginx-ssl-proxy` ([Github](https://github.com/DanielDent/docker-nginx-ssl-proxy)) nginx docker image acting as proxy.

### Requirements
In order to run this solution, you must have free the `TCP 443` port free on a server, or use an external `reverse-proxy`.  
Additionally, you need an external email provider with `POP3/IMAP` and `SMTP` servers.

### Installation
This is a quick guide to setup your Freescout self hosted instance, for more detailed info refer to [Freescout installation guide](https://github.com/freescout-helpdesk/freescout/wiki/Installation-Guide)
* Copy `.env.example` to `.env` and customize the parameters as stated by line comments
* Run `docker-compose up -d`. This will setup all required services and will attempt to get a `SSL certificate` on `Let's encrypt`
* On an explorer, navigate to the address provided for the `SITE_URL` parameter in `.env` file and log in with the admin credentials set in that file. You will be asked to set up the email settings
  * Click on `Manage Mailboxes`
  * Click on `New Mailbox`
  * Type the email address and description for your helpdesk email
  * You can customize the email details like names, signatures, etc.
  * Go to `Connection Settings`
  * For the `Sending Emails` tab, select `SMTP` and fill the details provided by your email host provider
  * For the `Fetching Emails` tab, set the details provided by your email host provider
  * On `Permissions` you can manage your users permissions for this mailbox, you must create users first
  * To create users go to `Manage` menu and click on `Users`, click on `New user` and fill the details

For further customization, refer to [Freescout wiki](https://github.com/freescout-helpdesk/freescout/wiki)

### Español
Esta es una guía rápida para poner en funcionamiento su propia instancia de Freescout, para más información visite la [guía de instalación de Freescout](https://github.com/freescout-helpdesk/freescout/wiki/Installation-Guide)
* Copiar `.env.example` a `.env` y configurar los parámetros de acuerdo a los comentarios de cada línea
* Ejecutar `docker-compose up -d`. Esto inicializará todos los servicios requeridos e intentará obtener un certificado SSL en `Let's encrypt`
* En un navegador, visite la dirección configurada en el parámetro `SITE_URL` del archivo `.env` e inicie sesión con las credenciales configuradas en dicho archivo. En el primer ingreso se requerirá configurar una mesa de ayuda
  * Clickear en el menu `Admin` y en `Profile`
  * En `Language` seleccionar `Español` y clickear en Save profile 
  * Clickear en el menú `Administrar` y `Correos`
  * Clickear en `Nuevo correo`
  * Ingresar la dirección de email y la descripción para su mesa de ayuda
  * Se pueden personalizar más detalles como Alias, nombres y firmas, luego clickear en `Guardar`
  * En `Configurar conexion` seleccionar `SMTP` e ingresar los datos provistos por su proveedor de correo electrónico
  * En la pestaña `Rescatando correos` ingresar los datos provistos por su proveedor de correo
  * En `Permisos` se puede administrar los permisos de usuarios para la mesa de ayuda, primero se debe crear otros usuarios
  * Para crear usuarios clickear en el menú `Administrar` y `Usuarios`. Clickear en `Nuevo usuario` e ingresar los detalles

Para una mayor personalización, consule la [wiki de Freescout](https://github.com/freescout-helpdesk/freescout/wiki) (en inglés).

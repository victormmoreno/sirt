<p align="center"><img src="https://ci4.googleusercontent.com/proxy/N1TwiELk9ROqhnFRUubnvlQrOh6eSS1ktRcBU9x1IJtovs54lp_vDAjizw13S3G9mdlnbXY7bqss1h4Yg6s8Pgev7IDzs3aDSILLAABKqIp1x92j4WcAFJrvJG_N2w=s0-d-e1-ft#http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C"></p>


# **PLATAFORMA RED TECNOPARQUE COLOMBIA**


_La **PLATAFORMA RED TECNOPARQUE COLOMBIA** es un sistema de información desarrollado para gestionar los procesos que actualmente lleva a cabo los diferentes nodos del país._

## Comenzando 🚀

_Sigue las siguientes instrucciones que te permitirán obtener una copia del proyecto en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._


Mira  **[Styde](https://styde.net/como-instalar-proyectos-existentes-de-laravel/)** para conocer más sobre como desplegar el proyecto.


### Pre-requisitos 📋

_Los siguientes programas son necesarios para el funcionamiento del proyecto en tu máquina local_

##### Servidor Local

_Eliga el servidor local de su preferencia, el cual incluye un servidor apache y un servidor de base de datos_
```
[laragon](https://laragon.org/) -recomendado para proyectos laravel
[wamp](http://www.wampserver.com/en/)
[xampp](https://www.apachefriends.org/es/index.html)

```

##### otros softwares necesarios
_instale node js para el manejo de paquetes javascript y el editor de código favorito_
```
[git](https://git-scm.com/) - obligatorio
[composer](https://getcomposer.org/) - manejador paquetes php - obligatorio
[node js](https://nodejs.org/es/) - incluye npm - Manejador de paquetes javascript
[vs code](https://code.visualstudio.com/) - recomendado
[atom](https://atom.io/)

```

## Instalación 🔧

_para la conrrecta instalación del proyecto siga los siguientes pasos_

_1. clonar proyecto en máquina local_

```
git clone https://gitlab.com/tecnoparque/gestion2020.git --optional=nombre_de_carpeta
```

_e ingresa las credenciales perfil de git_

_2. Instalando dependencias con Composer_
_Lo primero que debes hacer luego de descargar un proyecto existente a tu maquina local, es instalar las dependencias del proyecto con Composer._

```
composer install
```

_De esta forma se instalarán todas las dependencias necesarias para el proyecto que fueron definidas en el archivo composer.json durante el desarrollo._

_3. Archivo de configuración de Laravel_
_Cada nuevo proyecto con Laravel, por defecto tiene un archivo .env con los datos de configuración necesarios para el mismo, cuando utilizamos un sistema de control de versiones como git, este archivo se excluye del repositorio por medidas de seguridad._

_Sin embargo  existe un archivo llamado .env.example que es un ejemplo de como crear un el archivo de configuración, podemos copiar este archivo desde la consola con:_

```
cp .env.example .env
```

_4. Creando un nuevo API key_
_Por medidas de seguridad cada proyecto de Laravel cuenta con una clave única que se crea en el archivo .env al iniciar el proyecto. En caso de que el desarrollador no te haya proporcionado están información, puedes generar una nueva API key desde la consola usando:._

```
php artisan key:generate
```

_5. Base de datos y migraciones_
_Si el proyecto que estas instalando tiene definida una base de datos para su funcionamiento, por ejemplo MySql, debes primero crearla en tu servidor local, para Abrir el administrador de bases de datos y crear una base de datos con un nombre determinado._

_Con esto habrás ingresado al sql de MySql y desde ahí creas la base de datos con_

```
CREATE DATABASE tu_base_de_datos;
```

_Posteriormente debes agregar las credenciales al archivo .env_
```
DB_HOST=localhost
DB_DATABASE=tu_base_de_datos
DB_USERNAME=root
DB_PASSWORD=
```

_Finalmente estarás habilitado para ejecutar la migración desde la consola usando artisan_
```
php artisan migrate
```
_Para ejecutar los seeders puedes usar el siguiente flag_
```
php artisan db:seed
```

_6. Assets_
_Laravel cuenta con laravel mix, una herramienta para configurar los assets de cada proyecto._

_En este caso deberás seguir dos pasos mas antes de poder visualizar tu proyecto._

_Primero ejecutar_
```
npm install
```
_Esto instalará todas las herramientas necesarias, posteriormente debes instalar las dependencias utilizando_

_Para compilar los assets lo puedes hacer con uno de los siguientes comandos_
```
npm run dev
npm run watch
npm run production
```

## Ejecutando las pruebas ⚙️

_No hay pruebas automatizadas para este sistema_



### estilo de codificación ⌨️

_PSR4_


## Deployment 📦

_Dentro de git debe crear su propia rama de desarrollo_

## Construido con 🛠️

_Menciona las herramientas que utilizaste para crear tu proyecto_

* [Laravel](https://laravel.com/docs/5.8) - El framework web usado
* [JQuery](https://jquery.com/) - Use para simplificar la forma de manejar el JavaScript
* [Dropzone](https://www.dropzonejs.com/) - Usado para subir archivos al servidor
* [Datatables](http://yajrabox.com/docs/laravel-datatables) - Usado para el manejo de las tablas
* [Dompdf](https://github.com/barryvdh/laravel-dompdf) - Usado para generar archivos PDF

## Wiki 📖

Puedes encontrar mucho más de cómo utilizar este proyecto en nuestra [Wiki](https://github.com/tu/proyecto/wiki)

## Autores ✒️

_Menciona a todos aquellos que ayudaron a levantar el proyecto desde sus inicios_

* **Julian Dario Londoño Raigosa** - [jlondono433](https://gitlab.com/jlondono433)
* **Victor Manuel Moreno Vega**  - [Dumuzid](https://gitlab.com/Dumuzid)

También puedes mirar la lista de todos los [contribuyentes](https://gitlab.com/tecnoparque/gestion2019/-/graphs/master) quíenes han participado en este proyecto.

## Licencia 📄

Este proyecto está bajo la Licencia (MIT) - mira el archivo [LICENSE.md](LICENSE.md) para detalles

## Expresiones de Gratitud 🎁

* Comenta a otros sobre este proyecto 📢
* Invita una cerveza 🍺 a alguien del equipo.
* Da las gracias públicamente 🤓.
* etc.



---
⌨️ con ❤️ por [jlondono433](https://gitlab.com/jlondono433) ❤️ [Dumuzid](https://gitlab.com/Dumuzid)  😊 ⌨️

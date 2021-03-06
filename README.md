## Plantilla Backend con Laravel-Lumen (Con autenticación JWT)
-----------


![jwt-auth-banner](https://cloud.githubusercontent.com/assets/1801923/9915273/119b9350-5cae-11e5-850b-c941cac60b32.png)
-----------
### Tabla de Contenido

[Descripción](#descripcion)

[Consideraciones Previas](#consideraciones-previas)

[Colaboradores](#colaboradores)

[Enlaces de Ayuda](#enlaces-ayuda)

[Licencia](#licencia)

-----------

## Descripción
Sistema Base con autenticación JWT.

## Consideraciones Previas

Versión de PHP: 7.3+

Abrir una terminal y ejecutar:

Ejecute **composer update**

**php -S localhost:8000 -t public** 
El comando anterior difiere cuando debemos de correr la documentación de swagger, para ello hacemos lo siguiente:
**php -S localhost:8000 public/index.php** 

Vaya a su navegador preferido (google Chrome, Firefox u otros) y escriba la siguiente dirección url:
**http://localhost:8000/**

Para el manejo de Json Web Token (JWT) es necesario tener en el archivo .env una variable llamada JWT_SECRET, para generarla hacer lo siguiente:
**php artisan jwt:secret**, 
Luego un:
**php artisan cache:clear**

Para actualizar los archivos necesarios para que swagger se ejecute es necesario correr los siguientes 2 comandos (esto cada vez hayan cambios en las api)

**php artisan swagger-lume:publish**

**php artisan swagger-lume:generate**

Para poder ver la documentación de swagger visitar la url siguiente:

**http://localhost:8000/api/documentation**



## Colaboradores
* Ever Murcia <ever.murcia@salud.gob.sv>
* Sergio Gálvez <sergio.galvez@salud.gob.sv>

Ministerio de Salud de El Salvador

[www.salud.gob.sv](http://www.salud.gob.sv)

## Enlaces de Ayuda
* Lumen Laravel [lumen.laravel](https://lumen.laravel.com/).
* Jquery [Jquery](https://jquery.com/).

## Licencia
<a rel="license" href="https://www.gnu.org/licenses/gpl-3.0.en.html"><img alt="Licencia GNU GPLv3" style="border-width:0" src="https://next.salud.gob.sv/index.php/s/qxdZd5iwcqCyJxn/preview" width="96" /></a>

Este proyecto está bajo la <a rel="license" href="http://codigo.salud.gob.sv/plantillas/api-rest-admin/blob/master/LICENSE">licencia GNU General Public License v3.0</a>


<!--The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).-->


# DashTool



## Descripción

Un dashboar utilizando Laravel 11 con algunas características esenciales desarrolladas a mi manera. Éste proyecto lo utilicé como parte de la facultad, por lo que sólo lo actualicé a la versión más reciente de Laravel, para compartirlo con ustedes.

## Funcionalidades

- Control de permisos
- Control de usuario
- Control de módulos
- Uso ajax
- PHP > 8.2
- Buscador con ajax
- Login
- Registro
- Recuperación de contraseña
- Uso de imágenes

## Implmentación

- Si se usa XAMPP crear la base de datos con nombre **lnxdash**
- Cambiar el nombre del archivo env => .env
- Configurar la url del proyecto
- En caso de ser necesario, configurar los accesos de base de datos contraseñas
- Ejecutar migraciones de base de datos desde laravel

```
php artisan migrate:fresh --seed
```

## Pruebas
Para las pruebas correspondientes abrir el navegador con la ruta que se configure:

<http://localhost/lnxdash>

* El correo por defecto para usuario root es andy@dev.com y contraseña es holamundo

## Capturas

![alt tag](1.png)

![alt tag](2.png)

![alt tag](3.png)

## MIT License

License: MIT

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

#### Developed By
----------------
 * linuxitos - <contact@linuxitos.com>
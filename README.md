![image 1](https://uploads-ssl.webflow.com/62141f21700a64ab3f816206/62166bef1267334c9262f777_Group%20(1).svg)

Este es un proyecto creado con Laravel 9 (https://laravel.com/](https://laravel.com/)
## Paquetes usados

composer require tymon/jwt-auth

## Creación de base de datos

Ejecutando security_Script

>sudo mysql_secure_installation

Creando MYSQL user baldecash_dev con contraseña baldecash123

>CREATE USER 'baldecash_dev'@'localhost' IDENTIFIED BY 'baldecash123';

Creando abse de datos

>create database baldecashdb_dev

Brindando privilegios a solo usuario de aplicativo a solo base de datos baldecash_dev

>GRANT ALL PRIVILEGES ON baldecashdb_dev.* TO 'baldecash_dev'@'localhost' WITH GRANT OPTION;

>FLUSH PRIVILEGES;

## Ejecución de migrate

>php artisan migrate:run

## Ejecución de seeder

>php artisan db:seed

## Ejecución de factorie

>php artisan tinker # luego de abrir la consola
>>Users::factory()->count(CANTIDAD DE REGISTROS)->create();  

## Configuración para envio de correos mediante mailtrap.

Se reviso la documentación oficial de mailtrap para la configuración/implementación [https://mailtrap.io/blog/send-email-in-laravel/](https://mailtrap.io/blog/send-email-in-laravel/)

```
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=************
MAIL_PASSWORD=************
MAIL_ENCRYPTION=tls
```

## Ejecutar pruebas

Como se tiene implementado jwt para algunas APIs, entonces se genero un TRAIT para generar un JWT con un email y password de prueba, previamente registrado a nivel de base de datos. Por favor, modificar los siguientes valores

> Path archivo: app/Http/Traits

```
/**
     * Email for test.
     *
     * @var string
     */
    private $emailTest = "email@gmail.com";
    /**
     * PAssword for test.
     *
     * @var string
     */
    private $passwordTest = "123456";
```
Una vez modificado estos campos, ya se pueden ejecutar las pruebas con el siguiente comando.

php artisan test


## Rutas disponibles 


<pre> <font color="#3465A4">GET</font><font color="#6C7280">|HEAD</font>  <font color="#D3D7CF">/</font><font color="#6C7280"> 
  <font color="#C4A000">POST</font>      <font color="#D3D7CF">api/v1/login</font><font color="#6C7280"> ............................................................................... Authentication\AuthController@login</font>
  <font color="#C4A000">POST</font>      <font color="#D3D7CF">api/v1/register</font><font color="#6C7280"> ..................................................................... Authentication\AuthController@registerUser</font>
  <font color="#C4A000">POST</font>      <font color="#D3D7CF">api/v1/user/create</font><font color="#6C7280"> ............................................................................. Dashboard\UsersController@store</font>
  <font color="#CC0000">DELETE</font>    <font color="#D3D7CF">api/v1/user/destroy/</font><font color="#C4A000">{id}</font><font color="#6C7280"> ..................................................................... Dashboard\UsersController@destroy</font>
  <font color="#3465A4">GET</font><font color="#6C7280">|HEAD</font>  <font color="#D3D7CF">api/v1/user/index/</font><font color="#C4A000">{page}</font><font color="#6C7280"> ....................................................................... Dashboard\UsersController@index</font>
  <font color="#3465A4">GET</font><font color="#6C7280">|HEAD</font>  <font color="#D3D7CF">api/v1/user/show/</font><font color="#C4A000">{id}</font><font color="#6C7280"> ........................................................................... Dashboard\UsersController@show</font>
  <font color="#C4A000">PUT</font>       <font color="#D3D7CF">api/v1/user/update</font><font color="#6C7280"> ............................................................................ Dashboard\UsersController@update</font>
  <font color="#3465A4">GET</font><font color="#6C7280">|HEAD</font>  <font color="#D3D7CF">sanctum/csrf-cookie</font><font color="#6C7280"> .......................................... sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show</font></pre>
  
  Para la documentación de el esqueleto de request y response nos apoyamos de POSTMAN.

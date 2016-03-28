<?php

/**
 * GTA7X - PHP Framework
 *
 * @package  Base Project
 * @author   Gustavo Perez <gtgustavo20@hotmail.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels nice to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

$app = require __DIR__.'/../bootstrap/app.php';


/*_________________________________________________________________________
|  php error handling for cool kids
| --------------------------------------------------------------------------
| whoops is an error handler framework for PHP. Out-of-the-box, it provides
| a pretty error interface that helps you debug your web projects,
| but at heart it's a simple yet powerful stacked error
| handling system.
 */

require __DIR__.'/../bootstrap/handler.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$app->run();


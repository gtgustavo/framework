<?php

/*
|--------------------------------------------------------------------------
| Load environment
|--------------------------------------------------------------------------
|
| If our project contains a .env file then we should load that here, if we
| don't have such a file then we need to make sure we skip this step.
|
*/

try {

    (new Dotenv\Dotenv(__DIR__.'/../'))->load();

} catch (Dotenv\Exception\InvalidPathException $e) {

    //
}

/*
|--------------------------------------------------------------------------
| Create Container
|--------------------------------------------------------------------------
*/

$app = new Silex\Application();

$app['debug'] = getenv('APP_DEBUG');

/*
|--------------------------------------------------------------------------
| Load Service Providers
|--------------------------------------------------------------------------
*/

require_once 'ServiceProviders.php';

/*
|--------------------------------------------------------------------------
| Load Routes App
|--------------------------------------------------------------------------
*/

require_once '../app/Http/router.php';


return $app;

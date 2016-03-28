<?php

/**
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
 */

$app->get('/', function () use ($app) { return $app->redirect('/welcome/home'); });

$app->get('/auth', function () use ($app) { return $app->redirect('/auth/login'); });

$app->get('/password', function () use ($app) { return $app->redirect('/password/email'); });

$app->get('/admin', function () use ($app) { return $app->redirect('/admin/home'); });

$app->get('/logout', 'App\Http\Controllers\Auth\LogoutController::logout')->bind('logout');

$app->mount('/welcome', new App\Http\Controllers\WelcomeController());

$app->mount('/auth', new App\Http\Controllers\Auth\AuthController());

$app->mount('/password', new App\Http\Controllers\Auth\PasswordController());

$app->mount('/admin', new App\Http\Controllers\Admin\UserController());




<?php

use App\Helpers\Config;

$app->register(new Silex\Provider\TwigServiceProvider(), [

    'twig.path'    => Config::load_config('app', 'views.folder'),

    'twig.options' => [

        'cache'    => Config::load_config('app', 'views.compiler'),
    ],
]);

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

$app->register(new Silex\Provider\SessionServiceProvider(), array(

    'session.storage.save_path' => Config::load_config('app', 'session.tpm'),

    /*'session.storage.options'   => [

        'cookie_lifetime' => 1,

    ]*/

));
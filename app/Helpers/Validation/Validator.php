<?php

namespace App\Helpers\Validation;

use App\Helpers\Config;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;
use Illuminate\Database\Capsule\Manager as Capsule;

class Validator
{

    public static function make($data, $rules)
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver'    => getenv('DB_CONNECTION'),
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_DATABASE'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

        $loader = new FileLoader(new Filesystem, Config::load_config('app', 'validation.folder'));

        $translator = new Translator($loader, Config::load_config('app', 'validation.translation'));

        $presence = new DatabasePresenceVerifier($capsule->getDatabaseManager());

        $validation = new Factory($translator, new Container);

        $validation->setPresenceVerifier($presence);

        $errors = null;

        $validator = $validation->make($data, $rules);

        if ($validator->fails()) {

            $errors = $validator->errors();

        }

        return $errors;
    }

}
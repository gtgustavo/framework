<?php

namespace App\Helpers;

use Illuminate\Config\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Pagination\Paginator;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Silex\Application;

class Config
{

    static $configPath = __DIR__ . '/../../config/';

    public static function load_config($file, $line)
    {
        $config = new Repository(require self::$configPath . $file . '.php');

        return $config->get($line);
    }

    public static function flash(Application $app, $type, $title, $message)
    {
        $app['session']->getFlashBag()->add(

            $type, [

                'title'   => $title,

                'message' => $message
            ]
        );
    }

    public static function trans($line)
    {
        // Prepare the FileLoader
        $loader = new FileLoader(new Filesystem(), Config::load_config('app', 'validation.folder'));

        // Register the translator
        $trans = new Translator($loader, Config::load_config('app', 'validation.translation'));

        return $trans->get($line);
    }

    public static function paginate()
    {
        // Set up a current path resolver so the paginator can generate proper links
        Paginator::currentPathResolver(function () {
            return isset($_SERVER['REQUEST_URI']) ? strtok($_SERVER['REQUEST_URI'], '?') : '/';
        });

        // Set up a current page resolver
        Paginator::currentPageResolver(function ($pageName = 'page') {
            $page = isset($_REQUEST[$pageName]) ? $_REQUEST[$pageName] : 1;
            return $page;
        });
    }
}
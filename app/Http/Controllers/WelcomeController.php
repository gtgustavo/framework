<?php

namespace App\Http\Controllers;

use Silex\Application;
use Silex\ControllerProviderInterface;

class WelcomeController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $welcome = $app['controllers_factory'];

        $welcome->before(function() use($app) {
            if (! $app['session']->get('user'))
            {
                return $app->redirect('/auth');
            }
        });

        $welcome->get('/home', array($this, 'index'))->bind('welcome');

        return $welcome;
    }

    public function index(Application $app)
    {
        return $app['twig']->render('home.twig');
    }

}
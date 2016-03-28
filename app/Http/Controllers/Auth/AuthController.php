<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Auth\Authentication;
use App\Helpers\Config;
use App\Helpers\Session\Session;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class AuthController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $auth = $app['controllers_factory'];

        $auth->before(function() use($app) {
            if ($app['session']->get('user')) {
                return $app->redirect('/');
            }
        });


        $auth->get('/login',  array($this, 'get_login'))->bind('get_login');

        $auth->post('/login', array($this, 'post_login'))->bind('post_login');

        return $auth;
    }

    /*
     * Sign return form
     */

    public function get_login(Application $app)
    {
        return $app['twig']->render('auth/login.twig');
    }

    /*
     * Method charge of processing the session request
     */

    public function post_login(Application $app, Request $request)
    {
        $auth = Authentication::credentials($request);

        if($auth == null)
        {
            return $this->message_errors($app);
        }

        Session::start($app, $auth);

        return $app->redirect('/admin/home');
    }

    /*
     * Return Errors
     */

    public function message_errors(Application $app)
    {
        $error = [Config::trans('users.error_credentials')];

        $title = Config::trans('users.title_error_credentials');

        Config::flash($app, 'danger', $title, $error);

        return $app->redirect('/auth');
    }
}
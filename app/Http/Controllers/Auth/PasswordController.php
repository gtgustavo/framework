<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Auth\Password;
use App\Helpers\Config;
use App\Helpers\Validation\Validator;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class PasswordController implements ControllerProviderInterface
{

    public function connect(Application $app)
    {
        $reset = $app['controllers_factory'];

        $reset->before(function() use($app) {
            if ($app['session']->get('user')) {
                return $app->redirect('/');
            }
        });

        $reset->get('/email',  array($this, 'get_email'))->bind('get_email');

        $reset->post('/email', array($this, 'post_email'))->bind('post_email');

        $reset->get('/reset/{token}', array($this, 'get_reset'))->bind('get_reset');

        $reset->post('/reset', array($this, 'post_reset'))->bind('post_reset');

        return $reset;
    }


    public function get_email(Application $app)
    {
        return $app['twig']->render('auth/password.twig');
    }


    public function post_email(Application $app, Request $request)
    {
        $errors = Validator::make($request->request->all(), ['email' => 'required|email']);

        if($errors == null){

            $response = Password::SendMail($app, $request->get('email'));

            switch ($response) {

                case 'send_email':

                    Config::flash($app, 'success', 'Email Enviado', null);

                    return $app->redirect('/password/email');

                case 'error_email':

                    Config::flash($app, 'danger', 'No existe el email', null);

                    return $app->redirect('/password/email');
            }

        } else {

            Config::flash($app, 'danger', 'Error!!', $errors->getMessageBag()->all());

            return $app->redirect('/password/email');
        }

    }


    public function get_reset(Application $app, $token)
    {
        return $app['twig']->render('auth/reset.twig', compact('token'));
    }


    public function post_reset(Application $app, Request $request)
    {
        $errors = Validator::make($request->request->all(), [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        if($errors == null){

            $response = Password::reset($request);

            switch ($response) {

                case 'success':

                    Config::flash($app, 'success', 'Password Reset', null);

                    return $app->redirect('/auth');

                case 'error_token':

                    Config::flash($app, 'danger', 'Token no es valido para el email introducido', null);

                    return $app->redirect('/password/reset/'.$request->get('token'));

                case 'token_expired':

                        Config::flash($app, 'danger', 'El token ha expirado', null);

                        return $app->redirect('/password/reset/'.$request->get('token'));

                case 'error_email':

                    Config::flash($app, 'danger', 'No existe el email', null);

                    return $app->redirect('/password/reset/'.$request->get('token'));
            }

        } else {

            Config::flash($app, 'danger', 'Error!!', $errors->getMessageBag()->all());

            return $app->redirect('/password/reset/'.$request->get('token'));
        }
    }

}
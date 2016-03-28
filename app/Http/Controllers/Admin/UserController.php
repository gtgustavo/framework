<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Auth\Authentication;
use App\Helpers\Config;
use App\Helpers\Mailer\Mail;
use App\Helpers\Validation\Validator;
use App\Models\User;
use Silex\Application;
use Silex\ControllerProviderInterface;
use Symfony\Component\HttpFoundation\Request;

class UserController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $admin = $app['controllers_factory'];

        $admin->before(function() use($app) {
            if(! $app['session']->get('user'))
            {
                return $app->redirect('/');
            }
        });

        $admin->before(function() use($app){
            if($app['session']->get('user')['credential']['role'] != 'admin')
            {
                return $app->redirect('/');
            }
        });

        $admin->get('/home',         array($this, 'index'))->bind('admin_home');

        $admin->get('/register',     array($this, 'create'))->bind('admin_register');

        $admin->post('/register',    array($this, 'store'))->bind('admin_store');

        $admin->get('/edit/{id}',    array($this, 'edit'))->bind('admin_edit');

        $admin->post('/update/{id}', array($this, 'update'))->bind('admin_update');

        $admin->get('/delete/{id}',  array($this, 'destroy'))->bind('admin_delete');

        return $admin;
    }


    public function index(Application $app, Request $request)
    {
        /*
        $body = $app['twig']->render('emails/test.twig',
            array('name'=>'JustSteveKing', 'age'=>26));

        $d = Mail::send('Texto de Prueba', 'gtgustavo20@hotmail.com', $body);

        if($d == 1){

            return 'Send Mail Success';

        } else {

            return 'Error Send Mail';
        }

        */
        $users = User::FilterAndPaginate($request->get('card'));

        return $app['twig']->render('users/index.twig', compact('users'));
    }


    public function create(Application $app)
    {
        return $app['twig']->render('users/create.twig');
    }


    public function store(Request $request, Application $app)
    {
        $data = $request->request->all();

        $rules = User::rules($request);

        $errors = Validator::make($data, $rules);

        if($errors == null){

            //User::create($request->request->all());

            $password = Authentication::encrypt($request->get('password'));

            User::create([
                'name'     => $request->get('name'),
                'id_card'  => $request->get('id_card'),
                'phone'    => $request->get('phone'),
                'email'    => $request->get('email'),
                'password' => $password
            ]);

            Config::flash($app, 'success', Config::trans('users.register'), null);

            return $app->redirect('/admin/home');

        } else {

            Config::flash($app, 'danger', 'Error!!', $errors->getMessageBag()->all());

            return $app->redirect('/admin/register');
        }
    }


    public function edit(Application $app, $id)
    {
        $user = User::findOrFail($id);

        return $app['twig']->render('users/edit.twig', compact('user'));
    }


    public function update(Application $app, $id, Request $request)
    {
        $user = User::findOrFail($id);

        $data = $request->request->all();

        $rules = User::rules($request);

        $errors = Validator::make($data, $rules);

        if($errors == null)
        {
            $password = Authentication::encrypt($request->get('password'));

            $data = ([
                'name'     => $request->get('name'),
                'id_card'  => $request->get('id_card'),
                'phone'    => $request->get('phone'),
                'email'    => $request->get('email'),
                'password' => $password
            ]);

            $user->update($data);

            Config::flash($app, 'info', Config::trans('users.update'), null);

            return $app->redirect('/admin/home');

        } else {

            Config::flash($app, 'danger', 'Error!!', $errors->getMessageBag()->all());

            return $app->redirect('/admin/edit/'.$id);
        }
    }


    public function destroy(Application $app, $id)
    {
        User::destroy($id);

        Config::flash($app, 'info', Config::trans('users.delete'), null);

        return $app->redirect('/admin/home');
    }

}
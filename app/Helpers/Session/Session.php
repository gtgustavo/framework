<?php

namespace App\Helpers\Session;

use Silex\Application;

class Session
{

    public static function start(Application $app, $data)
    {
        return $app['session']->set('user', array('credential' => [

            'id'    => $data->id,
            'email' => $data->email,
            'name'  => $data->name,
            'role'  => $data->role

        ]));
    }


    public static function destroy(Application $app)
    {
        $app['session']->clear();
    }
}
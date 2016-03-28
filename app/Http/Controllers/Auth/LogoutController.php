<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\Session\Session;
use Silex\Application;

class LogoutController
{
    public function logout(Application $app)
    {
        Session::destroy($app);

        return $app->redirect('/auth');
    }

}
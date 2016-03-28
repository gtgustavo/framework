<?php

namespace App\Helpers\Auth;

use App\Helpers\Config;
use App\Models\User;
use Symfony\Component\HttpFoundation\Request;

class Authentication
{

    public static function credentials(Request $request)
    {
        /*
         * return authentication method, email / username (folder config / app.php)
         */
        $method = Config::load_config('app', 'auth.method');

        /*
         * Validate email / username
         */
        $user = User::where($method, $request->get('user_method'))->get();

        $count = count($user);

        if($count > 0)
        {
            $real = self::real($user);

            $validate = self::decrypting($request->get('password'), $real->password);

            if($validate){

                return $real;

            } else {

                return null;
            }

        } else {

            return null;
        }
    }


    public static function encrypt($password)
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        return $hash;
    }


    private static function decrypting($password, $hash)
    {
        if (password_verify($password, $hash)) {

            return true;

        } else {

            return null;
        }
    }


    private static function real($data)
    {
        foreach($data as $user)
        {
            return $user;
        }
    }

}
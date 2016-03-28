<?php

namespace App\Helpers\Auth;

use App\Helpers\Mailer\Mail;
use App\Models\User;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class Password
{
    public static function SendMail(Application $app, $email)
    {
        $data = self::validate_email($email);

        if($data)
        {
            $token = TokenRepository::create($email);

            self::emailResetLink($app, $email, $token);

            $result = 'send_email';

        } else {

            $result = 'error_email';
        }

        return $result;
    }

    private static function validate_email($email)
    {
        $user = User::where('email', $email)->get();

        $count = count($user);

        $data = null;

        if($count > 0)
        {
            $data = true;
        }

        return $data;
    }

    private static function emailResetLink(Application $app, $email, $token)
    {
        $motive = 'Recuperar Contraseña';

        $body = $app['twig']->render('emails/password.twig', compact('token'));

        return Mail::send($motive, $email, $body);
    }


    public static function reset(Request $request)
    {
        $data = self::validate_email($request->get('email'));

        if($data)
        {
            $token = TokenRepository::exists($request->get('email'), $request->get('token'));

            if($token == 'token_success'){

                return self::new_password($request->get('email'), $request->get('password'));
            }

            return $token;

        } else {

            $result = 'error_email';
        }

        return $result;
    }


    private static function new_password($email, $password)
    {
        $data = User::where('email', $email)->get();

        $new_password = Authentication::encrypt($password);

        foreach($data as $users)
        {
            $id = $users->id;
        }

        $user = User::findOrFail($id);

        $data = ([
            'password' => $new_password
        ]);

        $user->update($data);

        return 'success';
    }

}
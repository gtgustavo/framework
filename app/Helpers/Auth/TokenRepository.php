<?php

namespace App\Helpers\Auth;

use App\Models\Password as PasswordRecovery;
use Illuminate\Support\Str;

class TokenRepository
{
    public static function create($email)
    {
        self::deleteExisting($email);

        $token = self::createNewToken();

        PasswordRecovery::create([
            'email'      => $email,
            'token'      => $token,
        ]);

        return $token;
    }


    private function deleteExisting($email)
    {
        return PasswordRecovery::where('email', $email)->delete();
    }


    private function createNewToken()
    {
        return hash_hmac('sha256', Str::random(40), false);
    }


    public static function exists($email, $token)
    {
        $data = PasswordRecovery::where('email', $email)->where('token', $token)->first();

        $count = count($data);

        if($count > 0){

            $expired = self::tokenExpired($data->created_at);

            if($expired){

                return 'token_expired';
            }

            self::deleteExisting($email);

            return 'token_success';

        } else {

            return 'error_token';
        }
    }


    private function tokenExpired($time)
    {
        $expirationTime = strtotime($time) + 3600;

        $now = time();

        $expired = false;

        if($expirationTime < $now){

            $expired = true;
        }

        return $expired;
    }

}
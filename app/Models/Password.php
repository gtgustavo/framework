<?php

namespace App\Models;

use App\Helpers\Eloquent\EncapsulatedEloquentBase as Eloquent;

date_default_timezone_set('America/Caracas');

class Password extends Eloquent
{

    protected $table = 'password_resets';

    protected $fillable = ['email', 'token', 'created_at'];

    protected $hidden = ['email', 'token'];

}
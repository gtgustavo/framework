<?php namespace App\Models;

use App\Helpers\Config;
use App\Helpers\Eloquent\EncapsulatedEloquentBase as Eloquent;
use Symfony\Component\HttpFoundation\Request;

date_default_timezone_set('America/Caracas');

class User extends Eloquent
{
    protected $table = 'users';

    protected $fillable = ['name', 'phone', 'type_card', 'id_card', 'email', 'password'];

    protected $hidden = ['password'];

    public static function rules(Request $request)
    {
        return [
            'name'     => 'required|string|max:30',
            'id_card'  => 'required|digits_between:6,9|unique:users,id_card,' . $request->get('id'),
            'phone'    => 'required|digits_between:10,11',
            'email'    => 'required|email|max:30|unique:users,email,' . $request->get('id'),
            'password' => 'required|confirmed|min:8',
        ];
    }

    public static function FilterAndPaginate($card)
    {
        Config::paginate();

        return User::card($card)
            ->orderBy('id', 'ASC')
            ->paginate();
    }

    public function scopeCard($query, $card)
    {
        if (trim($card) != ""){
            $query->where("id_card", $card);
        }
    }

}

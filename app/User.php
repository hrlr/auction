<?php

namespace App;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\User
 *
 * @mixin Eloquent
 */

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'tbl_user';
    protected $primaryKey = 'userNumber';
    public $incrementing = false;
    public $timestamps = false;
    protected $guarded = [];

    public static function getSellers() {
        $sellers = User::select('userNumber', 'userName')
            ->where('userStatus', '>=', 1)
            ->orderby('userNumber', 'asc')
            ->get();

        return $sellers;
    }
}

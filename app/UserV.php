<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserV extends Model
{

    protected $table = 'users_v';

    protected $fillable = [
        'name', 'email', 'password','lastName','dataBrith','province','postalCode','phone1','prefix_phone_1','userName','type','status','prefix_id', 'key','mode','location_id','fullAddr',
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

}

<?php

namespace App\Http\Controllers\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Comments;
use Auth;
use App\User;
use App\CountryStates;
use App\Currency;

class CurrencyController extends Controller
{

    public $key;
    public $location_id;
    public $user_id;
    public function __construct($user_id,$location_id)
    {
        $this->middleware('auth:api');
        $this->key =  md5(time());
        $this->location_id = $location_id;
        $this->user_id = $user_id;
        $this->create();

    }


    public function create()
    {
        $states = CountryStates::where('id',$this->location_id)->first();
        $country=strtolower($states->country);
        $currency=Currency::where('entity',$country)->first();

        User::where('id',$this->user_id)->update(['currency_id'=>$currency->id]);

    }

    public function get()
    {
        $user = Auth::user()->id;
        return UserL::find($user);

    }

}

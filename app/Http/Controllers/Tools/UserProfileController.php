<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use App\UserV;
use App\CV;
use App\CVSchool;

class UserProfileController extends Controller
{

    public function __construct()
    {


    }

    public function UserProfile($token)
    {
        $user = UserV::where('key',$token)->first();
        if(isset($user->id)){
            $chef = CV::where('user_id',$user->id)->with('picture','cvExperiences','cvExperiences.country','cvSchool','cvSchool.country')->first();
        }

        return response()->json(["user"=>$user,"chef"=>$chef], 200);
    }

}

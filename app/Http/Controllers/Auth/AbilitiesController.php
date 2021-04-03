<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Http\Controllers\Helpers\FilesController;

class AbilitiesController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api');

    }

    public function abilities()
    {

        if (Auth::check()) {
            $data = Auth::user()->getPermissionsAttribute();
        }else{
            $data = [];
        }

        return response()->json($data,200);
    }

}

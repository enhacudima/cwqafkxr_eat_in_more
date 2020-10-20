<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CountryStates;

class CountryStatesController extends Controller
{
    
    public function getCountryStates()
    {
    	$data=CountryStates::orderby('internet','asc')->get();
    	return response()->json($data, 200); 
    }
}

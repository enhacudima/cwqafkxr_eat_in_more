<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Experiences;

class ExperiencesController extends Controller
{
    
    public function getExperiences()
    {
    	$data=Experiences::all();
    	return response()->json($data, 200); 
    }
}

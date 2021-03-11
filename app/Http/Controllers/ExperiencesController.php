<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Experiences;

class ExperiencesController extends Controller
{
    
    public function getExperiences()
    {
    	$data=Experiences::with('experiencesUsers','experiencesSync','experienceStatus')->get();
    	return response()->json($data, 200); 
    }
}

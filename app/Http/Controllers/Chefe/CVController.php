<?php

namespace App\Http\Controllers\Chefe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CV;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class CVController extends Controller
{
    
    public function createCV(Request $request)
    { 
    	$cvDate=$request->data['cvDate'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($cvDate);

        $validator = Validator::make($myRequest->all(), [
            'title' => 'required|string|max:255',
            'summary' => 'required|string', 
            'experience' => 'required|numeric|exists:experiences,id',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 
    $file = new FilesController; 
    $file_id = $request->data['fileData']['file_id'];      
    $file->useFile($file_id, 'CV', 0);
         
    $input = $myRequest->all(); 
            $input['user_id'] = Auth::user()->id; 
            $input['picture'] = $file_id;
            $input['key'] = md5(time()).Auth::user()->id;
            $cv=CV::firstOrCreate(
            	[
            		'user_id'=> $input['user_id'],
            	],
            	[
            		'title' => $input['title'],
            		'summary' => $input['summary'],
            		'experience' => $input['experience'],
            		'picture' => $input['picture'],
            		'key' => $input['key'],
            		

            	]
            );

    return response()->json(['success'=>'Added new records.'], 200); 
    }

    public function getCVData($id)
    {

    	$chefe_user_id = $id;
    	$data =  CV::where('user_id',$chefe_user_id)
    		->with('picture','users')
    		->first();

    return response()->json($data, 200); 

    }


    public function getAllCVData()
    {

    	$data =  CV::with('picture','users','cvExperiences')->get();

    return response()->json($data, 200); 

    }
}

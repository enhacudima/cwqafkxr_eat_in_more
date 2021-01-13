<?php

namespace App\Http\Controllers\Meal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meals;
use App\CV;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\SyncMealAllergies;
use App\SyncTags;

class CreateMealController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    public function newMeal(Request $request)
    { 

    	$mealData=$request->data['mealData'];
        $tags=$request->data['tags'];
        $file_id = $request->data['fileData']['file_id']; 
        $mealData['tags'] = $tags; 
        $mealData['file_id'] = $file_id;

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($mealData);
        //unique:meals,name
        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:50|unique:meals,name',
            'alias' => 'required|string|max:255',
            'details' => 'required|string|max:255',
            'commonTiming'=>'required',
            'time' => 'required|',
            'people' => 'required|numeric', 
            'experience' => 'required|numeric|exists:experiences,id',
            'tags' => 'required', 
            'file_id' => 'required|numeric',
        ],
        [
     	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            } 

    $input = $myRequest->all(); 
            $input['user_id'] = Auth::user()->id; 
            $input['key'] = md5(time()).Auth::user()->id;

            $meal=Meals::Create(
            	[
                    'user_id'=> $input['user_id'],
                    'name'=> $input['name'],
                    'alias'=> $input['alias'],
            		'details' => $input['details'],
            		'common_timing_id' => $input['commonTiming'],
            		'time' => new Carbon($input['time']),
            		'people' => $input['people'],
            		'experience_id' => $input['experience'],
            		'key' => $input['key'],
            		'cuisine_id' =>$input['cuisine'],

            	]
            );

                    
            $file = new FilesController; 
            $file_id = $myRequest['file_id'];      
            $file->useFile($file_id,$meal->id, 'meals', 0);

           foreach($input['ingredients'] as $key => $ingredient){
               //add ingredients to meal
               SyncMealAllergies::create([
                   'meal_id' => $meal->id ,
                   'ingredients_id' => $ingredient,
               ]);

           }
           if(isset($tags)){
               $tagKey = md5(time()).Auth::user()->id;
               foreach($tags as $key => $tag){
                    SyncTags::create([
                        'tag_id' => $tag,
                        'meal_id' => $meal->id,
                        'user_id'=> $input['user_id'],
                        'key' => $tagKey
                    ]);
               }
           }
           

    return response()->json(['success'=>'Added new records.'], 200); 
    }

}

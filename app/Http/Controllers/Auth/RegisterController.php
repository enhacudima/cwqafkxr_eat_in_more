<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Auth;
use App\CountryStates;
use App\ProvinceStates;


class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('details');
        
    }

    public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 

    public function register(Request $request) 
    { 
    	$userData=$request->data['userData'];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($userData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255', 
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255', 
            'password' => 'required|string|min:8|confirmed', 
            'dataBrith' => 'required|date|date_format:Y-m-d|before:18 years ago',
            'phone1'=>'required|numeric',
            'prefix_phone_1'=>'required|numeric',
            'type'=>'required|numeric',
            'terms_conditions' =>'required|accepted',
        ],
        [
        	
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            }
    $country = CountryStates::find($userData['prefix_phone_1']);
    $province = ProvinceStates::where('state_2_code',$country->internet)->first();
    $key = md5(time()).'U';
    $input = $myRequest->all(); 
            $input['password'] = bcrypt($input['password']); 
            $input['prefix_phone_1'] = '+'.$country->phone; 
            $input['prefix_id'] = $userData['prefix_phone_1'];
            $input['key'] = $key;
            $user = User::create($input);
            $user->sendEmailVerificationNotification();

            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
    return response()->json(['success'=>'Added new records.'], 200); 
    }
}

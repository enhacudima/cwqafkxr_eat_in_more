<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\User;
use Auth;

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
    	$userData=$request->data['userDate'];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($userData);

        $validator = Validator::make($myRequest->all(), [
            'name' => 'required|string|max:255', 
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255', 
            'password' => 'required|string|min:8|confirmed', 
            'dataBrith' => 'required|date|date_format:Y-m-d|before:today', 
            'province'=>'required',
            'postalCode'=>'required|postal_code:MZ,ZA|string|max:100',
            'phone1'=>'required|numeric',
            'prefix_phone_1'=>'required|max:12',
            'userName'=>'required|string|max:100|min:3|unique:users,userName',
        ],
        [
        	'postalCode.postal_code' => 'Invalid Postal Code',
        ]
    	);
    if ($validator->fails()) { 
                return response()->json(['errors'=>$validator->errors()->all()], 422);            
            }

    $input = $myRequest->all(); 
            $input['password'] = bcrypt($input['password']); 
            $user = User::create($input);
            $user->sendEmailVerificationNotification();

            $success['token'] =  $user->createToken('MyApp')-> accessToken; 
            $success['name'] =  $user->name;
    return response()->json(['success'=>'Added new records.'], 200); 
    }
}

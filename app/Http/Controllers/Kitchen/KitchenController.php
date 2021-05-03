<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Kitchen;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class KitchenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function createKitchen(Request $request)
    {
    	$kitchen=$request->data['kitchenData'];
        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($kitchen);

        $validator = Validator::make($myRequest->all(), [
            'aliase' => 'required|string|max:45',
            'full_address' => 'required|string|max:255',
            'type_stove_power_source' => 'required|string',
            'stove_backup' => 'nullable|string',
            'grill_available' => 'required|string',
            'oven_available' => 'required|string',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ],
        [

        ]
    	);
    if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
    }
    $user_id=Auth::user()->id;
    Kitchen::create([
        'aliase' => $myRequest['aliase'],
        'full_address' => $myRequest['full_address'],
        'type_stove_power_source' => $myRequest['type_stove_power_source'],
        'stove_backup' =>$myRequest['stove_backup'],
        'grill_available' =>$myRequest['grill_available'],
        'oven_available' =>$myRequest['oven_available'],
        'lat' =>$myRequest['lat'],
        'lng' =>$myRequest['lng'],
        'key' => md5(time()),
        'user_id' => $user_id,


    ]);

    return response()->json(['success'=>'Added new records.'], 200);
    }


    public function getKitchen($user_id)
    {

    	$data =  Kitchen::where('kitchen_details.user_id',$user_id)
                            //->with('userKitchen')
                            ->get();

    return response()->json($data, 200);

    }
}

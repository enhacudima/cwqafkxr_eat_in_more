<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\BookingV;
use App\cv;
use App\Booking;
use App\StatusDetailes;
use App\StatusName;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getInfo()
    {
      $data = BookingV::where('status','!=',6)->get();
      return response()->json($data, 200);
    }

    public function confirm_chef_booking(Request $request)
    {
    	$confirm=$request->data;
        $confirmRequest = new Request();
        $confirmRequest->setMethod('post');
        $confirmRequest->request->add($confirm);
        $status_code = $confirmRequest->status;

        $chef_id = Auth::user()->id;
        $chef_level = CV::where('user_id',$chef_id)->first();
        $booking_data = Booking::where('id',$confirmRequest->id)
                    ->where('level','>=',$chef_level->experience);

        //check status
        $teste = clone $booking_data;
        $new_booking_status =$teste;
        $new_booking_status=$new_booking_status->where('status',2)->first();


        $data_return = BookingV::where('status','!=',6)->get();

        if(isset($new_booking_status)){
            $this->status_update($new_booking_status,$status_code);
            return response()->json($data_return, 200);
        }

        $teste = clone $booking_data;
        $new_booking_chef =$teste;
        $new_booking_chef = $new_booking_chef->where('chef_id_confirmation',$chef_id)
                        ->where(function ($q){
                            $q->where('status',2)
                              ->orwhere('status',3);
                        })->first();

        if(isset($new_booking_chef)){
            $this->status_update($new_booking_chef,$status_code);
            return response()->json($data_return, 200);
        }

        $mesg=["Unfortunately, we are unable to process your request, because of lack of level or because another Chef has changed the status of this request."];
        return response()->json(['errors'=>$mesg], 422);

    }
    public function status_update($new_booking_status,$status_code)
    {

        $new_booking_status->status = $status_code;
        $new_booking_status->chef_id_confirmation = Auth::user()->id;
        $new_booking_status->save();

        $status = StatusName::where('code',$status_code)->first();
        $status_id=StatusDetailes::create([
        "table_name" =>"booking",
        "table_primary_id"=>$new_booking_status->id,
        "table_token"=>$new_booking_status->key,
        "status"=> $status_code,
        "detail"=> "was modified by chef ".$status->name,
        "notes"=> "",
        "user_id"=> Auth::user()->id,
        ]);

        $new_booking_status->status_id = $status->id;
        $new_booking_status->save();
    }

}

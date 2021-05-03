<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Booking;
use Auth;
use App\Http\Controllers\Helpers\FilesController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Helpers\SelectChefController;
use Carbon\Carbon;
use App\Meals;
use App\BookingSyncMeal;
use App\Http\Controllers\Meal\GetMealController;

class BookingController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function transformDate($data)
    {

        $meals=[];
        $mealPrice=[];
        $newKey=-1;
        $totalPrice=0;
        $numMeals=0;
        $totalTime=0;

        $getMeal = new GetMealController();

        foreach ($data as $key => $value) {
            if(Auth::user()->id == $value['user'] ){
                $newKey=$newKey+1;
                $meals[$newKey]=$value['meal_id'];
                $quantity[$newKey]=$value['quantity'];

                $mealPrice[$newKey]=$getMeal->getOneMealsV2(Auth::user()->currency_id, $value['meal_id'])->first();
                $mealPrice[$newKey]['quantity_to_book'] = $value['quantity'];
                $totalPrice=$totalPrice+$mealPrice[$newKey]->amount*$quantity[$newKey];
                $numMeals=$numMeals+$quantity[$newKey];
                $totalTime=$totalTime+$mealPrice[$newKey]->time_min*$quantity[$newKey];

            }
        }
        return ['meal_id'=>$meals,'quantity'=>$quantity,'totalPrice'=>$totalPrice,'numMeals'=>$numMeals, 'totalTime'=>$totalTime, 'mealPrice'=>$mealPrice];
    }

    public function createBooking(Request $request)
    {
    	$booking=$request->data['bookingData'];
        $bookingRequest = new Request();
        $bookingRequest->setMethod('POST');
        $bookingRequest->request->add($booking);

        $validatorBooking = Validator::make($bookingRequest->all(), [
            'cook_start_date' => 'required|date|date_format:Y-m-d|after:yesterday',
            'Cook_start_time' => 'required|date_format:H:i',
            'kitchen_id' => 'required|numeric|exists:kitchen_details,id',
            'terms_conditions' =>'required|accepted',
            'bookingData' =>'required',
        ],
        [

        ]
    	);
        //get read meals details
        $full_detailhe=$this->transformDate($bookingRequest->bookingData);
        //validate meals
        $meals=['meal_id'=>$full_detailhe['meal_id'],'quantity'=>$full_detailhe['quantity']];

        $mealsRequest=$this->getMealData($meals,$bookingRequest['cook_start_date'], $bookingRequest['Cook_start_time']);

    if ($validatorBooking->fails()) {
                return response()->json(['errors'=>$validatorBooking->errors()->all()], 422);
    }

    $select_chef = new SelectChefController();
    $best_chef = $select_chef->choice(['meals'=>$mealsRequest['meal_id'], 'chefs'=>$mealsRequest['chefs_user_id']]);
    $best_chef = $best_chef['best_chef'];
    $user_id = Auth::user()->id ;
    $key = md5(time());

    $booking=Booking::create([
        'cook_start_date' =>$bookingRequest['cook_start_date'],
        'Cook_start_time' =>$bookingRequest['Cook_start_time'],
        'kitchen_id' =>$bookingRequest['kitchen_id'],
        'key' => $key,
        'user_id' => $user_id,
        'currency_id' =>Auth::user()->currency_id,
        'chef_id' => $best_chef,
    ]);

    foreach ($mealsRequest['meal_id'] as $key => $meal_id) {
        $mealPrice=$full_detailhe['mealPrice'][$key];
        $meal_price_id=$mealPrice->meal_prices_id;
        $meal_fixed_price=$mealPrice->amount;
        $this->createBookingMeal($mealsRequest,$key,$best_chef,$user_id,$booking->id,$booking->key,$meal_price_id,$meal_fixed_price);
    }


    return response()->json(['success'=>'Added new records.'], 200);
    }

    public function createBookingMeal($mealsRequest,$key,$best_chef,$user_id,$booking_id,$booking_key,$meal_price_id,$meal_fixed_price)
    {

        $booking=BookingSyncMeal::create([
            'meal_id' => $mealsRequest['meal_id'][$key],
            'quantity' =>  $mealsRequest['quantity'][$key],
            'chef_id' =>  $mealsRequest['chefs_id'][$key],
            'chefs_user_id' =>  $mealsRequest['chefs_user_id'][$key],
            'meal_fixed_price' => $meal_fixed_price,
            'meal_price_id' => $meal_price_id,
            'user_id' => $user_id,
            'booking_id' => $booking_id,
            'booking_key' => $booking_key,
            'key' => $booking_key,
        ]);

    }


    public function getKitchen($user_id)
    {

    	$data =  Kitchen::where('kitchen_details.user_id',$user_id)
                            ->with('userKitchen')
                            ->get();

    return response()->json($data, 200);

    }
    public function getMealData($meals,$start_date, $start_time)
    {
        //we validate meals
        $this->validateMeals($meals);
        $select_chef = new SelectChefController();
        $arry_chefs=[];
        $arry_chefs_user=[];
        foreach ($meals['meal_id'] as $key => $meal_id) {
            $meal = Meals::find($meal_id);
            if (isset($meal)) {
                $end_date = $this->getEndDate($start_date, $start_time, $meal->time_to);
                $bestExperience=$select_chef->bestExperience($meal_id,$start_date,$end_date);
                if(isset($bestExperience)){
                    $arry_chefs[$key]=$bestExperience->id;
                    $arry_chefs_user[$key]=$bestExperience->user_id;
                }else{

                    $arry_chefs[$key]=0;
                    $arry_chefs_user[$key]=0;
                }
            }

        }
        $meals['chefs_id']=$arry_chefs;
        $meals['chefs_user_id']=$arry_chefs_user;
        //dd($meals);
        return $meals;

    }

    public function validateMeals($meals)
    {
        $mealsRequest = new Request();
        $mealsRequest->setMethod('POST');
        $mealsRequest->request->add($meals);

        $validatorMeals = Validator::make($mealsRequest->all(), [
            'meal_id.*' => 'required|numeric|exists:meals,id',
            'quantity.*' => 'required|numeric',
        ],
        [
        ]
        );


        if ($validatorMeals->fails()) {
                    return response()->json(['errors'=>$validatorMeals->errors()->all()], 422);
        }
    }

    public function getEndDate($start_date, $start_time,$time_to)
    {
        $waiting = 0.5;//time shift 30min
        $end_date = Carbon::createFromFormat('Y-m-d H:i', $start_date . ' '. $start_time)->addHour($time_to+$waiting)->toDateTimeString();
        return $end_date;
    }
}

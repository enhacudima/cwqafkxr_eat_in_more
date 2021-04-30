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
use App\Http\Controllers\Booking\BookingController as Check;
use App\MealsAPI2;
use App\Http\Controllers\Meal\GetMealController;
use App\User;

class CartController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function cartget(Request $request)
    {
    	$cart=$request->data['cart'];
        $cartRequest = new Request();
        $cartRequest->setMethod('POST');
        $cartRequest->request->add($cart);

        $meals=[];
        $mealPrice=[];
        $newKey=-1;
        $totalPrice=0;
        $numMeals=0;
        $totalTime=0;

        if(!$cartRequest->all()){
            return response()->json(['data'=>[],'totalPrice'=>null,'numMeals'=>null, 'totalTime'=>null], 200);
        }


        $getMeal = new GetMealController();

        foreach ($cartRequest->all() as $key => $value) {
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
        $meals=['meal_id'=>$meals,'quantity'=>$quantity];
        $validity=$this->getMealAvailbilty($meals);

        $newMealPrice=[];
        foreach ($mealPrice as $key => $value) {
            $newMealPrice[$key]=$mealPrice[$key];
            $newMealPrice[$key]['chef_to_cook']=$this->getChefName($validity,$value['meal_id']);
        }
        //dd($newMealPrice);

        return response()->json(['data'=>$newMealPrice,'totalPrice'=>$totalPrice,'numMeals'=>$numMeals, 'totalTime'=>$totalTime], 200);
    }
    public function getChefName($validity,$meal_id){
        $meals=$validity["meal_id"];
        $chefs=$validity["chefs_user_id"];
        $key = array_search($meal_id, $meals);
        $chef_user=null;
        if($key){
            $chef_user_id=$chefs[$key];
            $chef_user = User::where('id',$chef_user_id)->select('name','lastName','avatar')->where('status',1)->first();
        }
        return $chef_user;
    }

    public function getMealAvailbilty($meals)
    {

        $validator = new Check();


        $date=Carbon::now()->add(1,'day')->isoFormat('Y-m-d');
        $time=Carbon::now()->add(1,'day')->Format('H:i');
        $mealsCheked=$validator->getMealData($meals,$date,$time);

        return $mealsCheked;

    }



}

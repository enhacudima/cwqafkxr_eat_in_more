<?php

namespace App\Http\Controllers\Meal;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meals;
use App\MealsAPI2;
use App\Http\Controllers\Helpers\RemoveRelectionController as RemoveRelections;
use App\Options;
use App\MealPrices;
use Auth;
use App\MealType;

class GetMealController extends Controller
{

    public function getAllMeals()
    {
    	$data=Meals::with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')->get();
    	return response()->json($data, 200);
    }

    public function getOneMealsV2($currency_id, $meal_id)
    {
        $data=MealsAPI2::with('mealAllergies.allergiesIngredients','mealTags.tagName','mealOptions');
        $data->where('meal_v_api2.meal_id',$meal_id);
        $data=$this->selectCurrency($currency_id,$data)
        ->select('meal_v_api2.*','meal_prices.amount','currency.currency')
        ->distinct();

        return $data;
    }

    public function getMealsV2($currency_id)
    {
        $currency_id=$currency_id;
        $data=MealsAPI2::with('mealAllergies.allergiesIngredients','mealTags.tagName','mealOptions');
        $data=$this->selectCurrency($currency_id,$data)
        ->select('meal_v_api2.*','meal_prices.amount','currency.currency')
        ->distinct();
        $data=$data->get()->toArray();
        $dataRemove=([
            [
            'relaction'=>'meal_allergies',
            'subRelaction'=>'allergies_ingredients',
            'subRelaField'=>'name',
            'newArray'=>'allergies',
            ],
            [
            'relaction'=>'meal_tags',
            'subRelaction'=>'tag_name',
            'subRelaField'=>'name',
            'newArray'=>'tags',
            ],
            [
            'relaction'=>null,
            'subRelaction'=>'meal_options',
            'subRelaField'=>'name',
            'newArray'=>'options',
            ]
        ]);
        $remove= new RemoveRelections($data,$dataRemove);
        $data=$remove->readRelections();

        //$data=$this->readMelsRelections($data,$dataRemove);
    	return response()->json($data, 200);
    }

    public function selectCurrency($currency_id,$data){
        $data->join('meal_prices','meal_prices.meal_id','meal_v_api2.meal_id')
             ->where('meal_prices.currency_id',$currency_id)
             ->where('meal_prices.status',1)
             ->leftjoin('currency','currency.id','meal_prices.currency_id');

        return $data;
    }

    public function getPagmMals()
    {
        $currency_id = Auth::guard('api')->user()->currency_id;

    	$data=MealsAPI2::with('mealAllergies.allergiesIngredients','mealTags.tagName','mealOptions');
        $data=$this->selectCurrency($currency_id,$data)
        ->orderby('meal_v_api2.meal_updated_at','desc')
        ->paginate(50);

        return response()->json($data, 200);
    }
    public function searchMeals($search)
    {
        $currency_id = Auth::guard('api')->user()->currency_id;

        $data=MealsAPI2::where('meal_name','like',"%".$search."%")
        ->orwhere('meal_alias','like',"%".$search."%")
        ->orwhere('cuisine','like',"%".$search."%")
        ->orwhere('meal_type','like',"%".$search."%")
        ->orwhere('common_timing','like',"%".$search."%")
        ->with('mealAllergies.allergiesIngredients','mealTags.tagName','mealOptions');

        $data=$this->selectCurrency($currency_id,$data)
        ->orderby('meal_v_api2.meal_updated_at','desc')
        ->paginate(50);

    	return response()->json($data, 200);
    }

    public function getThisMeal ($idMeal)
    {
        $data=Meals::where('id',$idMeal)
        ->with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs','mealTags.tagName','mealOptions')
        ->first();
    	return response()->json($data, 200);
    }


    public function getThisMealPrices($id){
        $data=MealPrices::where('meal_id',$id)->with('users','priceCurrency','priceStatus')->get();
        return response()->json($data, 200);
    }


    public function getMealType(){
        $data=MealType::get();
        return response()->json($data, 200);
    }
}

<?php

namespace App\Http\Controllers\Meal;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meals;

class GetMealController extends Controller
{
    
    public function getAllMeals()
    {
    	$data=Meals::with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')->get();
    	return response()->json($data, 200); 
    }
        
    public function getPagmMals()
    {
    	$data=Meals::with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')->paginate(7);
    	return response()->json($data, 200); 
    }
    public function searchMeals($search)
    {
        $data=Meals::limit(20)
        ->where('name','like',"%".$search."%")
        ->with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealFile','mealChefs')
        ->get();
    	return response()->json($data, 200); 
    }
}

<?php

namespace App\Http\Controllers\Meal;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Meals;

class GetMealController extends Controller
{
    
    public function getAllMeals()
    {
    	$data=Meals::with('mealUser.userType','mealAllergies.allergiesSync','mealAllergies.allergiesIngredients','mealtiming','mealPrices','mealPrices.priceCurrency','mealType','mealFiles','mealChefs')->get();
    	return response()->json($data, 200); 
    }
}

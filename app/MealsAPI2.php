<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MealsAPI2 extends Model
{
    protected $table = 'meal_v_api2';
    protected $guarded =array();
    public $primaryKey = 'id';
    protected $connection = 'mysqlView';//via connectio 2


    public function mealAllergies()
    {
        return $this->hasMany('App\SyncMealAllergies','meal_id','meal_id');
    }

    public function mealPrices()
    {
        return $this->hasMany('App\MealPrices','meal_id','meal_id');
    }

    public function mealTags()
    {
        return $this->hasMany('App\SyncTags','meal_id','meal_id');
    }

    public function mealOptions()
    {
        return $this->hasMany('App\Options','meal_id','meal_id');
    }

}

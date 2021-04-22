<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;
use DB;

class CurrencyController extends Controller
{

    public function getCurrency()
    {
    	$data=Currency::all();
    	return response()->json($data, 200);
    }


    public function getCurrencyArr ()
    {
        $data=Currency::select(DB::raw("CONCAT(currency.entity,' (',currency.alphabetic_code,')') AS entity"),'currency','id','alphabetic_code')->where('status',1)->orderby('entity','asc')->get()->toArray();
    	return response()->json($data, 200);
    }
}

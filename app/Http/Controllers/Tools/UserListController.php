<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\User;
use App\EloquentVueTablesUsersList;

class UserListController extends Controller
{
         
    public function __construct()
    {
        $this->middleware('auth:api');
        
    }
    
    public function getUsersList()
    {
        $user =new User();
        $data=  new $user();

        $Eloq_table = new EloquentVueTablesUsersList();
        $table_data = $Eloq_table->get(new $data, ["user_type","id","name",	"lastName","dataBrith","prefix_phone_1","phone1","created_at","updated_at","avatar","type","status","email_verified_at"]);
       

        return response()->json($table_data, 200); 
    }


}

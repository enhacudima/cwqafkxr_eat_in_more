<?php

namespace App\Http\Controllers\Tools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use App\User;
use App\UserV;
use App\EloquentVueTablesUsersList;
use App\Http\Controllers\Helpers\BackUpUserController;
use App\CV;

class UserListController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');

    }

    public function getUsersList()
    {
        $user =new UserV();
        $data=  new $user();

        $Eloq_table = new EloquentVueTablesUsersList();
        $table_data = $Eloq_table->get(new $data, ["user_type","id","name",	"lastName","dataBrith","prefix_phone_1","phone1","created_at","updated_at","avatar","type","status","email_verified_at","key","title"]);


        return response()->json($table_data, 200);
    }
    public function UserUpdate(Request $request, $key)
    {

        $backup= new BackUpUserController($key);

        $experienceData=$request->data['userData'];

        $myRequest = new Request();
        $myRequest->setMethod('POST');
        $myRequest->request->add($experienceData);

        $validator = Validator::make($myRequest->all(), [
            'commets' => 'required|string|min:12',
            'type' => 'nullable|',
            'chefType' => 'nullable|',
            'userStatus' => 'nullable|',
        ],
        [

        ]
    	);
        if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()->all()], 422);
                }

        $input = $myRequest->all();


        if(isset($myRequest->type['id'])){
            $input['type'] = $myRequest->type['id'];
            $user=User::where('key',$key)
            ->update(
                [
                    'type'=> $input['type'],
                ]
            );
        }

        if(isset($myRequest->userStatus['id'])){
            $input['userStatus'] =$myRequest->userStatus['id'] ;
            $user=User::where('key',$key)
            ->update(
                [
                    'userStatus'=> $input['userStatus'],
                ]
            );
        }


        if(isset($myRequest->chefType['id'])){
            $input['chefType'] = $myRequest->chefType['id'];
            $user=User::where('key',$key)->first();
            $chefe_id = $user->id;

            CV::where('user_id',$chefe_id)
            ->update(
                [
                    'experience'=> $input['chefType'],
                ]
            );
        }

        return response()->json(['success'=>'Updated records.'], 200);
    }


}

<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Auth;
use Cookie;
use App\User;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use AuthenticatesUsers;
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function forgotPassword(Request $request)
    {
        $arr=null;
        $input = $request->all();
        $rules = array(
            'email' => "required|email|exists:users,email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()], 422);
        }  else {
            try {
                $response = Password::sendResetLink($request->only('email'), function (Message $message) {
                    $message->subject($this->getEmailSubject());
                });
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return \Response::json(array("status" => 200, "message" => trans($response), "data" => array()));
                    case Password::INVALID_USER:
                        return \Response::json(array("status" => 400, "message" => trans($response), "data" => array()));
                }
            } catch (\Swift_TransportException $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            } catch (Exception $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            }
        }
        return \Response::json($arr);
    }

    public function changePassword(Request $request)
    {
        $input = $request->all();
        $userid = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $userid)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        return \Response::json($arr);
    }

    public function reset(Request $request){
            $input = $request->only('email','token','password', 'password_confirmation');
            $validator = Validator::make($input, [
                'token' => 'required',
                'email' => 'required|email|exists:users,email',
                'password' => 'required|confirmed|min:8',
            ]);

             if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()->all()], 422);
            }


                $response = Password::reset($input, function ($user, $password) {
                    $user->password = bcrypt($password);
                    $user->save();
                });

                switch ($response) {
                    case Password::INVALID_TOKEN:
                        return response()->json(['errors'=>[trans($response)]], 422);
                    case Password::INVALID_USER:
                        return response()->json(['errors'=>[trans($response)]], 422);
                }


                 return response()->json(['success'=>'Password reseted successfully.'], 200);
    }

}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    //use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password'=>'required|min:8'
        ]);
    }
    public function update(Request $request)
    {
        if($request->filled('username','password'))
        {
            $user=User::where('username','=',$request->username)->first();
            if($user==null){
                return "user not found";
            }
            if(!password_verify($request->password,$user->password))
            {
                return "wrong password";
            };
            //return $this;
            $this->validator($request->all())->validate(); //新規パスワードの確認

            if($request->new_password==null)
            {
                return "enter your new password";
            }
            // $user->password=bcrypt($request->new_password);
            // $user->save();
            $user->update([
                'password'=>$request->new_password
            ]); //->save();
            return "changed your password";
        }
        else{
            return "enter your 'username', 'password' and 'new_password'";
        }
    }
}

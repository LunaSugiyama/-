<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\TwoFactorAuthPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
class TwoFactorAuthController extends Controller
{
    //
    protected $email;
    public function code_auth(Request $request){
        $random_password='';
        for($i=0;$i<4;$i++){
            $random_password .=strval(rand(0,9));
        }
        $user=User::where('email',$request->email)->first();
        if($user==null){
            return "this email is not pre-registered";
        }
        if($user->email_verified==1)
        {
            return "the user with this email has already been registered";
        }
        $user->tfa_token=$random_password;
        $user->tfa_expiration=now()->addMinutes(10);
        $user->save();
        //return $user->tfa_token;
        //\Mail::to($user)->send(new TwoFactorAuthPassword($random_password,$request->email));
        $this->email=$user->email;
        Mail::raw($user->tfa_token,function($message){
            $message->to($this->email);
            $message->subject('authentication number');
        });
        return "code send to your email";
    }
    public function enter_code(Request $request)
    {
        $result=false;
        if($request->filled('tfa_token','username')){
            $user=User::where('username','=',$request->username)->first();
            if($user==null){
                return "user not found";
            }
            //return $user;
            $expiration=new Carbon($user->tfa_expiration);
            //return $expiration;
            if($user->tfa_token==$request->tfa_token && $expiration>now()){
                $user->tfa_token=null;
                $user->tfa_expiration=null;
                $user->email_verified=1;
                $user->save();
                return "your email has been confirmed and you have been registered to example-app";
            }
            else{
                return"your usesrname maybe wrong or token expired";
            }
        }
        else{
            return "enter tfa_token and username";
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
//use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    protected $email;
    protected $emailaddress;
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    //use SendsPasswordResetEmails;

    public function make_token(ForgotPasswordRequest $request)
    {
        //return "here";
        $token='';
        for($i=0;$i<4;$i++){
            $token.=strval(rand(0,9));
        }
        //return "here";
        $this->email=$request->validated();
        $this->emailaddress=$request->email;
        //return"here";
        $user=User::where('email',$request->email)->first();
        //return "here";
        $user->tfa_token=$token;
        //return "here";
        $user->tfa_expiration=now()->addMinutes(10);
        //return "here";
        $user->save();
        //return "here";
        //return ($this->email)->email;
        Mail::raw($token,function($message){
            $message->to($this->emailaddress);
            $message->subject('reset password token');
        });
        return "email with token sent reaccess within 10 minues";
    }
    protected function validator(array $data)
    {
        return Validator::make($data,[
            'new_password'=>'required|min:8'
        ]);
    }
    public function enter_code(Request $request)
    {
        $result=false;
        if($request->filled('tfa_token','email')){
            $user=User::where('email','=',$request->email)->first();
            if($user==null){
                return "user not found, enter correct email";
            }
            //return $user;
            $expiration=new Carbon($user->tfa_expiration);
            //return $expiration;
            if($user->tfa_token==$request->tfa_token && $expiration>now()){
                $this->validator($request->all())->validate(); //新規パスワードの確認
                if($request->new_password==null)
                {
                    return "enter your new password";
                }

                $user->tfa_token=null;
                $user->tfa_expiration=null;
                $user->password=($request->new_password);
                $user->save();
                return "your password has been reset";
            }
            else{
                return"your email maybe wrong or token expired";
            }
        }
        else{
            return "enter tfa_token and email";
        }
    }

}

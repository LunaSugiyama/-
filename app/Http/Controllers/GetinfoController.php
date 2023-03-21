<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\GetinfoRequest;
use Validator;
class GetinfoController extends Controller
{
    //

    public function getinfo(GetinfoRequest $request)
    {
        if($request->id!=null)
        {
            $user=User::where('id','=',$request->id)->first();
            return $user;
        }
        else if($request->username!=null)
        {
            $username=$this->getUser($request->username);
            if($username==1)
            {
                $user=User::where('email',$request->username)->first();
                if($user->email_verified==1){
                    if(Hash::check($request->password,$user->password))
                    {
                        return $user;
                    }
                    else{
                        return "incorrect password";
                    }
                }
                return "this user is not fully registered";
            }
            else if($username==0)
            {
                $user=User::where('username',$request->username)->first();
                if($user->email_verified==1){
                    if(Hash::check($request->password,$user->password))
                    {
                        return $user;
                    }
                    else
                    {
                        return "incorrect password";
                    }
                }
                return "this user is not fully registered";
            }
        }
        else{
            return "enter your username/email and password";
        }
    }

    private function getUser(string $username)
    {
        $validator = Validator::make(['email' => $username],[
            'email' => 'required|email'
          ]);

          if($validator->passes()){
            // send you email here
            return 1;
          }
          else{
            return 0;
          }

    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function logout(LoginRequest $request)
    {
        $credentials=$request->getCredentials();
        if(!Auth::validate($credentials)):
            return "Logout failed";
        endif;
        $user=Auth::getProvider()->retrieveByCredentials($credentials);
        if($user->login==1):
            $user->login=0;
            $user->save();
            Session::flush();
            Auth::logout();
            return "you have logged out";
        else:
            return "you have not logged in!";
        endif;
    }
}

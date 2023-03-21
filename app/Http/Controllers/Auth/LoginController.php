<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
//use App\Http\Controllers\Auth\Request;
use Illuminate\Http\Request;
//エラーメッセージも付け加えられればなおよし
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(LoginRequest $request)
    {
        //return "klsjdfl";
        $credentials=$request->getCredentials();
        if(!Auth::validate($credentials)):
            return "Login failed";
        endif;
        $user=Auth::getProvider()->retrieveByCredentials($credentials);
        if($user->email_verified==null)
        {
            return "this user is still pre-registered and not fully registered\n";
        }
        //return $user;

        if($user->login!=1)
        {
            $user->login=1;
            $user->save();
            Auth::login($user);
            return "you have successfully been logged in!";
        }
        else{
            return "you are already logged in";
        }
        //return( $this->authenticated($request, $user));
    }
    // protected function authenticated(Request $request,$user)
    // {

    // }
}

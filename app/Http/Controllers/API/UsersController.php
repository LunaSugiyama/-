<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\EmailVerificationController;

class UsersController extends Controller{
    public function storeuser(Request $request)
    {
        $user=new User();
        $user->name=$request->input('name');
        $user->username=$request->input('username');
        $user->email=$request->input('mail');
        $user->password=bcrypt($request->input('password'));
        $user->save();
        //return "until here";
        self::callMailVerificationStore($user);
        return "Mail verification complete";
    }
    private function callMailVerificationStore($user)
    {
        $mail_verification=app()->make('App\Http\Controllers\API\EmailVerificationController');
        $mail_verification->store($user->email);
    }
}

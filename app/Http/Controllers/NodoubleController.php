<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\History;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;

class NodoubleController extends Controller
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
            //ここからhitoryテーブルに保存していく
            $id=$user->id;
            //ここから過去のパスワードと一致していないか確認していく
            $passnew=$this->SamePass1($id,$request->new_password);
            if($passnew==1)
            {
                // return response()->json([
                //     'error'=> "you have already used this password before try another"
                // ]);
                return response('error: you have already used this password before; try another');
            }
            else
            {
                $user->update([
                    'password'=>$request->new_password
                ]); //->save();
                History::create([
                    'user_id'=>$id,
                    'password'=>Hash::make($request->new_password),
                    'username'=>$request->username,
                ]);
                return "changed your password";
            }
        }
        else{
            return "enter your 'username', 'password' and 'new_password'";
        }
    }
    //protected array $users;
    protected array $passwords;
    public function samepass(Request $given_id/*int $given_id, string $password*/)
    {
        // if($given_id->given_id==1)
        // {
        //     return "you have entered 1";
        // }
        $users=History::where('user_id','=',$given_id->given_id)->get();
        if($users==null)
        {
            return "this user is not registered";
        }
        //return $users;
        $passwords=array();
        foreach ($users as $user)
        {
            //$passwords+=$user->password;
            //array_push($passwords,$user->password); //要素ごと配列に格納する
            if($user->password==$given_id->password)
            {
                return 1; //pass is not new
            }
        }
    return 0; //password is new;
    }
    private function SamePass1(int $given_id, string $password)
    {
        // if($given_id->given_id==1)
        // {
        //     return "you have entered 1";
        // }
        $users=History::where('user_id','=',$given_id)->get();
        if($users==null)
        {
            return "this user is not registered";
        }
        //return $users;
        $passwords=array();
        foreach ($users as $user)
        {
            //$passwords+=$user->password;
            //array_push($passwords,$user->password); //要素ごと配列に格納する
            if(Hash::check($password,$user->password))
            {
                return 1; //pass is not new
            }
        }
    return 0; //password is new;
    }

}

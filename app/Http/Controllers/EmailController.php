<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
//use Resources\Views\Email\mail.blade.php as email;


class EmailController extends Controller
{
    //
    public function index(Request $request)
    {
        $data=array('name');
        $mail_name=$request->get('username');
        $email=$request->get('email');
        //Mail::to($email_to);//->send(new SendMail($mail_name,$email_to));
        Mail::raw('Text',function($message){
            $message->to('luppysugiyama@gmail.com');
            $message->subject('test mail');
        });
        // Mail::send(email.sample_mail,$data,function($message){
        //     $message->to('luppysugiyama@gmail.com','testmailname')->subject('test mail');
        // });
        //return $email_to;
        return ('email sent');
    }
}

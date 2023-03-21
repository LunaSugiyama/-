<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\MailVerification;
use App\Models\User;
use App\Mail\MailVerification as MailVerificationMail;
use App\Mail\MailVerificationConfirmComplete as MailVerificationConfirmCompleteMail;
use App\Http\Controllers\Controller;
// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;
define('ACTIVATE_SALT','[秘密鍵]');//秘密鍵がACTIVATE_SALT
class EmailVerificationController extends Controller
{
    //use Queueable, SerializesModels;
    //protected $user;
    /**
     * Create a new message instance.
     */

    public function store($mail)
    {
        //return "until here";
        $mail_verification=new MailVerification();
        $mail_verification->mail_authentication=self::createActivationCode($mail); //createActivationcodeメソッドで認証コードの作成
        //return "until here";
        $mail_verification->mail=$mail;
        $mail_verification->save();
        //return ($mail_verification);
        //return "here";
        self::sendMailVerification($mail_verification);
        //return "until here";
    }
    public function verify($active_code)
    {
        $mail_verification=self::getMailInfoFromActiveCode($active_code);
        $mail=$mail_verification[0]->mail;
        $user=new User();
        $user->isVerified($mail);
        self::destroy($mail_verification[0]->id);
        self::sendMailVerificationComplete($mail);
    }
    private function createActivationCode($mail)
    {
        return hash_hmac('sha256',$mail,ACTIVATE_SALT);
    }
    private function sendMailVerification($mail_verification)
    {
    //     Mail::to($mail_verification->mail)
    // ->send(new MailVerificationMail($mail_verification->mail_authentication/**,$mail_verification->mail)*/));
    $mailaddress=$mail_verification->mail;
    //return "lks";
    $auth_url=config('const.Base_URL').'verify/'.$mail_verification->mail_authentication;
    // return $this->from(config('mail.from.address'))
    // ->subject(MAIL_VERIFICATION_SUBJECT)
    // ->view('mail.verification',compact('auth_url'));
    Mail::raw($auth_url,function($message){
        $message->to("luppysugiyama@gmail.com"); //$mailaddressにするとダメになるなんで？？？？？
        $message->subject('authentication number');
    });
    }
    private function sendMailVerificationComplete($mail)
    {
        Mail::to($mail)
        ->send(new MailVerificationConfirmCompleteMail());
    }
    private function getMailInfoFromActiveCode($active_code)
    {
        return MailVerification::where('mail_authentication',$active_code)->get();
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

define('MAIL_VERIFICATION_SUBJECT','【メールタイトル】');
class MailVerification extends Mailable
{
    use Queueable, SerializesModels;
    protected $mail_verification;
    protected $mailaddress;
    /**
     * Create a new message instance.
     */
    public function __construct($num,$email)
    {
        //
        //return "email with url sent";
        $this->mail_verification=$num;
        $this->mailaddress=$email;
    }
    public function build()
    {
        $auth_url=config('const.Base_URL').'verify/'.$this->mail_verification;
        // return $this->from(config('mail.from.address'))
        // ->subject(MAIL_VERIFICATION_SUBJECT)
        // ->view('mail.verification',compact('auth_url'));
        //return "until here";
        Mail::raw($auth_url,function($message){
            $message->to("luppysugiyama@gmail.com");
            $message->subject('authentication number');
        });
        return "email with url sent";
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Mail Verification',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  */
    // public function content(): Content
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array<int, \Illuminate\Mail\Mailables\Attachment>
    //  */
    // public function attachments(): array
    // {
    //     return [];
    // }
}

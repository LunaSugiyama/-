<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
//use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
//use Illuminate\Mail\Mailables\Content;
//use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class TwoFactorAuthPassword extends Mailable
{
    use Queueable, SerializesModels;

    //private $tfa_token='';
    protected $tfa_token='';
    protected $emailaddress;
    /**
     * Create a new message instance.
     */
    public function __construct($tfa_token,$email)
    {
        $this->tfa_token=$tfa_token;
        $this->emailaddress=$email;
        //
    }
    public function build()
    {
        // return $this->from('test@exampleapp.com','authenticationサイト名')
        // ->subject('authentication code')
        // -view('email.password')
        // ->with('tfa_token',$this->tfa_token);
        //echo "klsjf";
        Mail::raw($this->tfa_token,function($message){
            $message->to($this->emailaddress);
            $message->subject('authentication number');
        });
        return "mail sent";
    }

    /**
     * Get the message envelope.
     */
    // public function envelope(): Envelope
    // {
    //     return new Envelope(
    //         subject: 'Two Factor Auth Password',
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
    //}
}

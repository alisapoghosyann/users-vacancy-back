<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg,$user)
    {
        $this->name = $user->name;
        $this->message= $msg;
        $this->email = $user ->email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = $this->name;
        $email = $this->email;
        $msg =  $this->message;

        return $this->subject($this->email)->view('message',compact('name','email','msg'));
    }
}

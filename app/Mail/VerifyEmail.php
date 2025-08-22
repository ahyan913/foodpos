<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $file = public_path('images').'/male.png';
        return $this
                ->attach($file)
                ->subject("Hey! Congratulation")
                ->from(env("MAIL_FROM_ADDRESS", "system@yanlui.com"), 'Web Services')
                ->view('emails.users.verify')
                ->with(["name"=>"Yan Lui", "information"=>"Congratulation!"]);
    }

}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransferMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $content;
    public $name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $content)
    {
        $this->email = $email;
        $this->name = $name;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails/send-transfer')->subject('Transfer');
    }
}

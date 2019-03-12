<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $content;
    public $name;
    public $to;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $content, $to)
    {
        $this->email = $email;
        $this->name = $name;
        $this->content = $content;
        $this->to = $to;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails/transfer')->subject('New received transfer');
    }
}

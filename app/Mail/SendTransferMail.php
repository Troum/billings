<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTransferMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $content;
    public $receiver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $receiver, $content)
    {
        $this->name = $name;
        $this->receiver = $receiver;
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

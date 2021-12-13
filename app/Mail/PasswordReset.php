<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public $link;
    public $minutes;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($link, $minutes)
    {
        $this->link = $link;
        $this->minutes = $minutes;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.password-reset');
    }
}

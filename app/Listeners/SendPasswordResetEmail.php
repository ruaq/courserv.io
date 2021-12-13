<?php

namespace App\Listeners;

use App\Events\UserForgotPassword;
use App\Mail\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserForgotPassword $event
     * @return void
     * @throws \Exception
     */
    public function handle(UserForgotPassword $event)
    {
        $minutes = 30;
        $reset_link = $event->user->generatePasswordResetLink($event->user, $minutes);
        Mail::to($event->user->email)->send(new PasswordReset($reset_link, $minutes));
    }
}

<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Mail\Welcome;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail implements ShouldQueue
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
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $minutes = 1440; // 24 h
        $reset_link = $event->user->generatePasswordResetLink($event->user, $minutes);
        Mail::to($event->user->email)->send(new Welcome($reset_link, $minutes));
    }
}

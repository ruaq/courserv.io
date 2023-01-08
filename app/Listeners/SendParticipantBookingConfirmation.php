<?php

namespace App\Listeners;

use App\Events\CourseBooked;
use App\Mail\ParticipantBookingConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Nekhbet\LaravelGettext\Facades\LaravelGettext;

class SendParticipantBookingConfirmation implements ShouldQueue
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
     * @param CourseBooked $event
     * @return void
     */
    public function handle(CourseBooked $event)
    {
        LaravelGettext::setLocale($event->locale);

        Mail::to($event->participant->email)
            ->locale($event->locale)
            ->send(new ParticipantBookingConfirmation($event->participant, $event->participant->course));
    }
}

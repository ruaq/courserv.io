<?php

namespace App\Mail;

use App\Models\Course;
use App\Models\Participant;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ParticipantBookingConfirmation extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Course $course;

    public Participant $participant;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($participant, $course)
    {
        $this->participant = $participant;
        $this->course = $course;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(_i('Booking confirmation').' '.$this->course->type->name)
            ->markdown('mail.participant-booking-confirmation');
    }
}

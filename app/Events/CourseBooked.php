<?php

namespace App\Events;

use App\Models\Participant;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseBooked
{
    use Dispatchable;
    use SerializesModels;

    public Participant $participant;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Participant $participant)
    {
        $this->participant = $participant;
    }
}

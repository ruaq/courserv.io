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

    public string $locale;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Participant $participant, $locale)
    {
        $this->participant = $participant;
        $this->locale = $locale;
    }
}

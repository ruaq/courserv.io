<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CertificateRequested
{
    use Dispatchable;
    use SerializesModels;

    public $course;

    public User $user;

    public int $certTemplate;

    public array $participants;

    /**
     * Create a new event instance.
     *
     * @param  User  $user
     * @param $course
     * @param $participants
     */
    public function __construct(User $user, $course, $certTemplate, $participants)
    {
        $this->user = $user;
        $this->course = $course;
        $this->certTemplate = $certTemplate;
        $this->participants = $participants;
    }
}
